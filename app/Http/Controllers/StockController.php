<?php

namespace App\Http\Controllers;

use App\Group;
use App\Session;
use App\Product;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\BinaryOp\GreaterOrEqual;

class StockController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('authCheck');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stockCounts = Session::all();


        return view('stock')->with([
            'sessions' => $stockCounts,
        ]);
    }


    public function add(Request $request)
    {
        $user = Auth::user();

        Session::create([
            'name' => $request->stockCountName,
            'user_id' =>$user->id,
        ]);

        return redirect('stock');

    }

    public function finish(Request $request)
    {

        $currentSession = Session::find($request->id);
        $currentSession->isFinished = true;
        $currentSession->save();

        return redirect('stock');
    }

    public function lobby($id)
    {
        $groupsForSession = Session::find($id)->groups;

        return view('stock_lobby')->with([
                "groups" => $groupsForSession,
                "sessionId" => $id]
        );
    }
    public function addGroup(Request $request)
    {
        $id = $request->id;
        $CurrentUser = Auth::user();
        $session = Session::find($id);
        if($session->canCreateGroup($CurrentUser)){
            $group = Group::create(['name'=>$request->stockGroupName]);
            $session->groups()->attach($group);
            $group->users()->attach($CurrentUser);
            $group->owner()->associate($CurrentUser);
            $group->save();
            return back();
        }else{

            return back()->withErrors(['error'=>'Aynı anda birden fazla grubun lideri olunamaz']);

        }
    }

    public function join($id){
        $currentUser = Auth::user();
        $group = Group::find($id);
        $currentSession = Session::find($group->sessions->first()->id);
        $allGroups = $currentSession->groups;

        foreach ($allGroups as $g){

            if($g->memberOf($currentUser)){
                return back()->withErrors(['error'=>'Aynı anda birden fazla grupta bulunulamaz.']);
            }

        }

        $group->users()->attach($currentUser);
        $group->save();
        return back();


    }
    public function display($id){

        $currentUser = Auth::user();

        $currentGroup = Group::find($id);

        if($currentGroup->memberOf($currentUser)){

            return view('stock_display')->with(['group'=>$currentGroup,
                'description' => '',
                'description2' => '',
                'session'=>$currentGroup->sessions()->get()->first(),
                'ean' => '']);

        }else{
            return back()->withErrors(['error'=>'Yetki Yetersizliği']);
        }
    }

    public function searchByProductCode(Request $request){
        $productCode = $request->productCode;
        $xml = simplexml_load_file('D:\FurtherSoftData\productcatalog.xml');
        foreach ($xml->PRODUCT as $product){
            $temp = (string) $product->ID;
            if($temp == $productCode){

               return
                    ['productcode' => (string)$product->ID,
                        'description' => (string)$product->D1,
                        'description2' => (string)$product->D2,
                        'ean' => (string)$product->EAN,
                        'img' => (string)$product->IMG,];

            }
        }

        return ['error'=>'bulunamamıştır'];
    }


    public function searchByEanCode(Request $request){
        $eanCode = $request->eanCode;
        $xml = simplexml_load_file('D:\FurtherSoftData\productcatalog.xml');
        foreach ($xml->PRODUCT as $product){
            $temp = (string) $product->EAN;
            if($temp == $eanCode){
                return
                    ['productcode' => (string)$product->ID,
                        'description' => (string)$product->D1,
                        'description2' => (string)$product->D2,
                        'ean' => (string)$product->EAN,
                        'img' => (string)$product->IMG,];

            }
        }

        $pentaXML = simplexml_load_file('D:\FurtherSoftData\penta.xml');

        foreach($pentaXML->Stok as $product) {
            $temp = (string) $product['UreticiBarkodNo'];
            if($temp == $eanCode){
                return
                ['productcode' => (string) $product['UreticiKod'],
                        'description' => (string) $product['Ad'],
                        'description2' =>  (string)$product['MarkaIsim'],
                        'ean' => (string) $product['UreticiBarkodNo'],
                        'img' => ''];
            }
        }


        return ['error'=>'bulunamamıştır'];
    }

    public function saveProduct(Request $request){
        $currentUser = Auth::user();
        $product = Product::where('barcode',$request->barcode)->get()->first();

        if($product == null)
        $product = Product::updateOrCreate(
            ['productcode'=>$request->productcode,
                'description1'=>$request->description,
                'description2'=>$request->description2,
                'barcode'=>$request->barcode,
                'imagepath'=>$request->imagepath,
            ]
        );

        $transaction = new Transaction();

        $transaction->group()->associate(Group::find($request->groupid));
        $transaction->product()->associate($product);
        $transaction->quantity = $request->quantity;
        $transaction->save();




        return back()->withErrors(['error'=>'Başarıyla Kaydedildi']);

    }

    public function getQuantity(Request $request){
        dd($request->ean);
        $data = DB::select('select products.productcode,products.barcode,products.description1,products.description2,products.imagepath, sum(transactions.quantity) as \'totalquantity\' from transactions inner join products on products.id=transactions.product_id where transactions.group_id in (select group_id from group_session where session_id = ? ) where products.barcode = ? group by transactions.product_id',[$sessionId,$ean]);
        return $data->quantity;
    }
    public function getData($id){
        
        $data = DB::select('select products.productcode,products.barcode,products.description1,products.description2,products.imagepath, sum(transactions.quantity) as \'totalquantity\' from transactions inner join products on products.id=transactions.product_id where transactions.group_id in (select group_id from group_session where session_id = ? ) group by transactions.product_id',[$id]);

        return view('stock_data',['data'=>$data]);
    }

    public function test($ean){
        $pentaXML = simplexml_load_file('D:\FurtherSoftData\penta.xml');

        foreach($pentaXML->Stok as $product) {
            $temp = (string) $product['UreticiBarkodNo'];
            if($temp == $ean){
                return
                    ['productcode' => (string) $product['UreticiKod'],
                        'description' => (string) $product['Ad'],
                        'description2' =>  (string)$product['MarkaIsim'],
                        'ean' => (string) $product['UreticiBarkodNo'],
                        'img' => ''];
            }
        }


        return ['error'=>'bulunamamıştır'];
    }

}
