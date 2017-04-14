@extends('layouts.market')

@section('content')
    <style>
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <div class="container">

        <div class="row text-center">
            <h3>Piyasa Arastirmasi</h3>
            <br>

            <div class="form-group">
                <label for="ProductCode">Urun Kodunu Giriniz</label>
                <input type="text" class="form-control" id="ProductCode" placeholder="Urun Kodu">
                <br>
                <button id="marketSubmit" class="btn btn-primary" style="width: 100%" onclick="lookupPrice()">Gonder</button>

                <script>
                    $( document ).ready(function() {
                        document.getElementById("loader1").style.display = "none";
                        document.getElementById("loader2").style.display = "none";
                    });

                    function lookupPrice(){
                        document.getElementById("arenaInfo").style.display = "none";
                        document.getElementById("pentaInfo").style.display = "none";
                        document.getElementById("loader1").style.display = "block";
                        document.getElementById("loader2").style.display = "block";

                        var productCode = $('#ProductCode').val();

                        $.get("/market/lookupPrice/"+productCode, function(data, status){
                            var temp = jQuery.parseJSON(data);
                            var pArena = temp[0];
                            var pPenta = temp[1];

                            if(pArena){
                                $('#priceArena').val(temp[0][0][0]);
                                $('#currencyArena').val(temp[0][1][0]);
                                $('#stockArena').val(temp[0][2][0]);
                            }else{
                                $('#priceArena').val('Bilgi Bulunamamistir');
                                $('#currencyArena').val('Bilgi Bulunamamistir');
                                $('#stockArena').val('Bilgi Bulunamamistir');
                            }

                            if(pPenta){
                                $('#pricePenta').val(temp[1][0][0]);
                                $('#currencyPenta').val(temp[1][1][0]);
                                $('#stockPenta').val(temp[1][2][0]);
                            }else{
                                $('#pricePenta').val('Bilgi Bulunamamistir');
                                $('#currencyPenta').val('Bilgi Bulunamamistir');
                                $('#stockPenta').val('Bilgi Bulunamamistir');
                            }

                            document.getElementById("loader1").style.display = "none";
                            document.getElementById("arenaInfo").style.display = "block";


                            document.getElementById("loader2").style.display = "none";
                            document.getElementById("pentaInfo").style.display = "block";

                        });
                    }

                </script>
            </div>
            <hr>
        </div>

        <div class="row" style="padding-top: 50px">
            <div class="col-md-4">
                <img src="/arena.png" alt="Arena Bilgisayar" style="width:75%;height: 75%">
            </div>
            <div class="col-md-8">
                <div id="loader1" class="loader"></div>
                <div style="display:none;" id="arenaInfo" class="animate-bottom">
                    <div  class="form-group">
                        <label for="priceArena">Ozel Fiyat</label>
                        <input type="text" class="form-control" id="priceArena" disabled>
                    </div>
                    <div class="form-group">
                        <label for="currencyArena">Doviz</label>
                        <input type="text" class="form-control" id="currencyArena" disabled>
                    </div>

                    <div class="form-group">
                        <label for="stockArena">Stok</label>
                        <input type="text" class="form-control" id="stockArena" disabled>
                    </div>

                </div>
            </div>
        </div>

        <div class="row" style="padding-top: 50px;padding-bottom: 150px">
            <div class="col-md-4">
                <img src="/penta.png" alt="Penta Bilgisayar" style="width:75%;height: 75%">

            </div>
            <div class="col-md-8">
                <div id="loader2" class="loader"></div>
                <div style="display:none;" id="pentaInfo" class="animate-bottom">
                    <div class="form-group">
                        <label for="pricePenta">Ozel Fiyat</label>
                        <input type="text" class="form-control" id="pricePenta" disabled>
                    </div>

                    <div class="form-group">
                        <label for="currencyPenta">Doviz</label>
                        <input type="text" class="form-control" id="currencyPenta" disabled>
                    </div>

                    <div class="form-group">
                        <label for="stockPenta">Stok</label>
                        <input type="text" class="form-control" id="stockPenta" disabled>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
