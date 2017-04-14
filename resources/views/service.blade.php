@extends('layouts.service')

@section('content')

    <div class="container">,
        <div class="row">

            <div class="panel panel-default">
                <div class="panel-heading"><h4 style="text-align: center; font-weight: bold;" >Opsiyonlar</h4>
                    <div class="row">
                        <hr>

                    </div>
                    <div class="row">

                        <div class="col-sm-4">
                            <a href="service/accept" class="btn-primary btn" style="height: 100px;width: 300px;">
                                <br>
                                Urun Kabul
                            </a>
                        </div>
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                            <a href="service/handover" class="btn-primary btn" style="height: 100px;width: 300px;">
                                <br>
                                Urun Teslim
                            </a>
                        </div>

                </div>
            </div>


        </div>
    </div>
    </div>
@endsection