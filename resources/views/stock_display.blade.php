@extends('layouts.stock_app')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-success">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<div class="container">
    <div class="row">
        <strong><h3 style="text-align: center">@php echo $group->name @endphp</h3></strong>
    </div>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h4 style="text-align: center;" >Urun Kodu</h4></div>
            <div class="panelform">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input id = "productCode" type="text" class="form-control" name="productCode" placeholder="Product Code">
                    <input id = "eanCode" type="text" class="form-control" name="eanCode" placeholder="EAN">
                    <button id="search" type="submit" class="form-control btn-primary" >Araştır <i class="fa fa-search" aria-hidden="true"></i></button>
               <script>
                   // A $( document ).ready() block.
                   $( document ).ready(function() {

                       function notfound(){
                           $( "#eanCode" ).css('border-color','red');
                       }

                       function found(){
                           $( "#eanCode" ).css('border-color','');
                           $( "#quantity" ).focus();
                       };

                       $( "#search" ).click(function() {

                           if ( !($( "#productCode" ).val() === '')){
                               $.post( "/stock/searchByProductCode", { _token: '{{csrf_token()}}', productCode: $( "#productCode" ).val()},function (data) {

                                   if(data['error'] === undefined){
                                       $( "#aciklama" ).val(data['description']);
                                       $( "#aciklama2" ).val(data['description2']);
                                       $( "#barkod" ).val(data['ean']);
                                       $( "#hiddenProductCode" ).val(data['productcode']);
                                       var image = data['img'].substring(data['img'].lastIndexOf('/') + 1, data['img'].length);
                                       $temp = 'http://resim.pencere.com/'
                                               +data['productcode'].toUpperCase()+'/'+image;

                                       $( "#productImage" ).attr('src',$temp);
                                       $( "#hiddenImagePath" ).val($temp);
                                        found();
                                   }else{
                                       alert('Urun Bulunamamıstır');
                                   }
                               } ) .fail(function(xhr, status, error) {
                                   alert(xhr.responseText);
                               });
                           }else if(!($( "#eanCode" ).val() === '')){
                               $.post( "/stock/searchByEanCode", { _token: '{{csrf_token()}}', eanCode: $( "#eanCode" ).val(), sessionId: @php echo $session->id @endphp },function (data) {
                                   console.log(data);
                                   //alert(typeof data['ean']);
                                   if(data['error'] === undefined){
                                       $( "#aciklama" ).val(data['description']);
                                       $( "#aciklama2" ).val(data['description2']);
                                       $( "#barkod" ).val(data['ean']);
                                       $( "#hiddenProductCode" ).val(data['productcode']);
                                       var image = data['img'].substring(data['img'].lastIndexOf('/') + 1, data['img'].length);
                                       if(data['productcode'] != '')
                                           $( "#productImage" ).attr('src','http://resim.pencere.com/'
                                                   +data['productcode'].toUpperCase()+'/'+image);
                                       $( "#quantitylbl" ).val(data['currentQuantity']);
                                       $( "#hiddenImagePath" ).val('http://resim.pencere.com/'
                                               +data['productcode'].toUpperCase()+'/'+image);

                                       found();

                                   }else{
                                       notfound();
                                   }
                               } );
                           }else{
                               notfound();
                           }
                       });


                       $( "#eanCode" ).focus();

                       jQuery('#eanCode').on("keypress", function (e) {

                           if (e.keyCode == 13) {


                               $( "#search" ).click();
                               $( "#eanCode" ).val('');
                           }
                       });
                   });



               </script>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading"><h4 style="text-align: center;" >Urun Fotograf</h4></div>
                <img id="productImage" src="http://resim.pencere.com/003R92152/003R92152.jpg" style="width: 100%;height: 100%">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading"><h4 style="text-align: center;" >Urun Bilgileri</h4></div>
                <form method="POST" action="/stock/saveProduct">
                <div class="panelform">

                    <div class="form-group">
                        <label for="aciklama">Açıklama</label>
                        <input required type="text" class="form-control" id="aciklama" name="description">
                    </div>
                    <div class="form-group">
                        <label for="aciklama 2">Açıklama 2</label>
                        <input type="text" class="form-control" id="aciklama2" name="description2">
                    </div>
                    <div class="form-group">
                        <label for="barkod">Barkod</label>
                        <input type="text" class="form-control" id="barkod" name="barcode">
                    </div>
                    <div class="form-group">
                        <label id="quantitylbl" for="adet">Adet</label>
                        <input id="quantity" required type="number" class="form-control" id="adet" name="quantity">
                    </div>
                    <div class="form-group">
                        <label id="quantitylbl" for="hiddenProductCode">Urun Kodu</label>
                    <input required name="productcode" class="form-control" id="hiddenProductCode">
                    </div>
                    <input required type="hidden" name="imagepath" id="hiddenImagePath">
                    <input required type="hidden" name="groupid" value="@php echo $group->id @endphp">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>


            </div>

        </div>

    </div>
    <div class="row">
        <div style="padding-bottom: 30px">
            <button  type="submit" class="form-control btn-primary" >Giriş <i class="fa fa-check" aria-hidden="true"></i></button>
        </div>
    </div>
    </form>

</div>


@endsection