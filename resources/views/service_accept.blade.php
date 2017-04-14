@extends('layouts.service')

@section('content')

    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('error') }}
            </div>
        @endif

            @if (session('status'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
                </div>
            @endif

        <h3 style="text-align: center">Arıza Kabul</h3>
            <div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Yeni Müşteri Kaydı</h4>
                        </div>
                        <div class="modal-body">
                            <form action="/customer/register" method="post">
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <label for="name">İsim</label>
                                    <input required class="form-control" id="name" name="name">
                                    <label for="email">E-Mail</label>
                                    <input required class="form-control" id="email" name="email">
                                    <label for="address">Adres</label>
                                    <input required class="form-control" id="address" name="address">

                                </div>
                                <button type="submit" class="btn btn-primary">Gönder</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <form method="post" action="/service/register">
            <div class="form-group">
                <label for="model">Model No</label>
                <input name="model" type="text" class="form-control" id="model">
            </div>
            <div class="form-group">
                <label for="sno">Seri Numarası</label>
                <input name="sno" type="text" class="form-control" id="sno">
            </div>

            <div class="form-group">
                <label for="customer"><a onclick=" $('#addCustomer').modal('show');">Müşteri</a></label>
                <input name="customer" type="text" class="form-control" id="customer">
            </div>

            <div class="form-group">
                <label for="fault">Arıza Tanımı</label>
                <textarea name="fault" class="form-control" rows="4" id="fault"></textarea>
            </div>

            <div class="form-group">
                <label for="person">Getiren Kişi</label>
                <input name="person" type="text" class="form-control" id="person">
            </div>

            <div class="checkbox">
                <label><input name="priority" type="checkbox">Öncelik</label>
            </div>
            <div class="row">
            <input style="width: 100%" type="submit" class="btn btn-primary" value="Gönder">
            </div>
            <br>
            <script>

                $(function() {

                    $("#customer").autocomplete({
                        appendMethod:'replace',
                        source:[
                            function( q,add ){

                                $.getJSON("/customer/search/"+encodeURIComponent(q),function(resp){
                                    console.log(resp);
                                    add(resp);
                                })
                            }
                        ]
                    });
                });
            </script>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>

@endsection