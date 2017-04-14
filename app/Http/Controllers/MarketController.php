<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarketController extends Controller
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
        return view('market');
    }

    public function lookupPrice($id){

        //PENTA

        $pentaXML = simplexml_load_file('D:\FurtherSoftData\penta.xml');

        $pentaCurrency = '';
        $pentaPrice = 0.0;
        $pentaStock = '';
        $pentaOverall = [];

        foreach($pentaXML->Stok as $product) {
            $temp = (string) $product['UreticiKod'];
            if($temp == (string)$id){
                $pentaPrice = $product['Fiyat_Ozel'];
                $pentaCurrency = $product['Doviz'];
                $pentaStock = $product['Miktar'];
                $pentaOverall = [$pentaPrice,$pentaCurrency,$pentaStock];
            }
        }

        if($pentaOverall == []){
            $pentaOverall = null;
        }

        //ARENA

        $arenaXML = simplexml_load_file('D:\FurtherSoftData\pricelist.xml');
        $arenaStockXML = simplexml_load_file('D:\FurtherSoftData\productstock.xml');

        $arenaCurrency = '';
        $arenaPrice = 0.0;
        $arenaStock = '';

        $arenaOverall = [];

        foreach($arenaStockXML->PR as $stock) {
            $temp = (string) $stock->ID;
            if($temp == (string)$id){
                $arenaStock = $stock->ATP;
            }
        }

        foreach($arenaXML->PRODUCT as $product) {
            $temp = (string) $product->ID;
            if($temp == (string)$id){
                $arenaPrice = $product->PP;
                $arenaCurrency = $product->CU;
                $arenaOverall = [$arenaPrice,$arenaCurrency,$arenaStock];
            }
        }

        if($arenaOverall == []){
            $arenaOverall = null;
        }

        if($pentaOverall == []){
            $pentaOverall = null;
        }

        return json_encode([$arenaOverall,$pentaOverall]);

    }

}
