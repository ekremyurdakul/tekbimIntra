<?php

namespace App\Http\Controllers;

use App\Customer;
use App\OperationType;
use App\Product;
use App\ServiceProduct;
use App\ServiceProductDetail;
use App\ServiceStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
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
        return view('service');
    }


    public function accept()
    {
        return view('service_accept');
    }
    public function technic(){
        $statuses = ServiceStatus::all();
        $operations = OperationType::all();

        return view('service_technic')->with(
            ['statuses'=>$statuses,
                'operations'=>$operations]
        );
    }
    public function current()
    {
        $statuses = ServiceStatus::all();

        return view('service_current')->with(
            ['statuses'=>$statuses,
            ]
        );
    }

    public function register(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'model' => 'required|max:255',
                'person'=>'required',
                'sno'=>'required',
                'fault'=>'required',
            ]);
            if ($validator->fails()) {
                    return back()->with('error', 'Lütfen formu eksiksiz ve doğru doldurun');
            }


            $id = Customer::where('name',$request->customer)->first()->id;
            $priority = 0;
            if(isset($request->priority)){
                $priority = 1;
            }

            ServiceProduct::create([
                'model'=>$request->model,
                'sno'=>$request->sno,
                'customer_id'=>$id,
                'fault_description'=>$request->fault,
                'person'=>$request->person,
                'user_id'=>Auth::user()->id,
                'priority'=>$priority,
                'service_status_id'=>1,
            ]);

            return back()->with('status', 'Başarıyla Kaydedilmiştir');

        }
        catch (Exception $e){
            return back()->with('errors', 'Sorun !');
        }


    }

    public function technician(Request $request){
        $currentUserId = Auth::user()->id;
        $currentProduct = ServiceProduct::find($request->id);
        $currentProduct->technician_id = $currentUserId;
        $currentProduct->service_status_id = 2;
        $currentProduct->save();

        return back()->with('status', 'Başarıyla Kaydedilmiştir');
    }

    public function statusChange(Request $request){


        $product = ServiceProduct::find($request->id);

        if(count($product->details()->get()) == 0){
            return back()->with('error', 'Durum Değişimi için en az bir işlem girilmesi gerekmektedir');
        }

        $product->service_status_id = $request->statusId;
        $product->save();

        return back()->with('status', 'Başarıyla Kaydedilmiştir');
    }

    public function snoNeeded($id){

        return OperationType::find($id)->serialneed;

    }

    public function addOperation(Request $request){
        $sno = "";

        if(isset($request->sno)){
            $sno = $request->sno;
        }

        ServiceProductDetail::create([
            'service_product_id'=>$request->id,
            'user_id'=>Auth::user()->id,
            'operation_type_id'=>$request->operationId,
            'sno'=>$sno,
            'operation_description'=>$request->description
        ]);
        return back()->with('status', 'Başarıyla Kaydedilmiştir');
    }

    public function deleteOperation(Request $request){
        ServiceProductDetail::find($request->id)->delete();
        return back()->with('status', 'Başarıyla Silinmiştir');
    }

    public function deleteProduct(Request $request){
        ServiceProductDetail::where('service_product_id', $request->id)->delete();
        ServiceProduct::find($request->id)->delete();
        return back()->with('status', 'Başarıyla Silinmiştir');
    }

    public function product($id){
        $product = ServiceProduct::find($id);

        return view('service_technic_product')->with(['product'=>$product]);
    }
    
    public function handover(){
        $finishedProducts = ServiceStatus::where('name','Bitti')->get()->first()->products()->get();

        return view('service_handover')->with([
            'finishedProducts'=>$finishedProducts,
        ]);
    }

    public function handoverProduct($id){
        $product = Product::find($id);
        $product->service_status_id = ServiceStatus::where('name','Teslim Edildi')->get()->first();

        $product->save();
        return back()->with('status', 'Başarıyla Teslim Edilmiştir');
    }

}
