@extends('layouts.service')

@section('content')

    <div class="container" >
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
        <!-- Modal -->
        <div id="deleteOps" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Sil</h4>
                    </div>
                    <div class="modal-body">
                        <p>Silmek istediğinize emin misiniz?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="/service/aedit/technic/deleteOperation" method="POST" >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input id="opsId" type="hidden" name="id" value="">
                            <input type="submit" class="btn btn-danger" value="Gönder">
                        </form>

                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="panel panel-default" style="padding-right: 20px;padding-left: 20px;" >

            <div class="panel-heading"><h4 style="text-align: center; font-weight: bold;" >Model No : @php echo $product->model @endphp</h4></div>

            <div class="form-group">
                    <label for="sno">SNO</label>
                <input type="email" class="form-control" id="model" value="@php echo $product->sno @endphp">
            </div>
            <div class="form-group">
                <label for="customer">Müşteri</label>
                <input type="text" class="form-control" id="customer" value="@php echo $product->customer()->get()->first()->name @endphp">
            </div>
            <div class="form-group">
                <label for="description">Arıza</label>
                <textarea class="form-control" id="description" >@php echo $product->fault_description @endphp</textarea>
            </div>
            <div class="form-group">
                <label for="person">Getiren Kişi</label>
                <input class="form-control" id="person" value="@php echo $product->person @endphp">
            </div>
            <div class="form-group">
                <label for="person">Kaydı Alan</label>
                <input class="form-control" id="person" value="@php echo $product->user()->get()->first()->name . ' ' . $product->user()->get()->first()->surname @endphp">
            </div>
            <div class="form-group">
                <label for="priority">Öncelik</label>
                <input class="form-control" id="person" value="@php
                    if($product->priority){
                    echo 'Yüksek' ;
                    }else{
                    echo 'Düşük';
                    } @endphp">
            </div>
            <div class="form-group">
                <label for="technician">Sorumlu Teknisyen</label>
                <input class="form-control" id="technician" value="@php echo $product->technician()->get()->first()->name . ' ' . $product->technician()->get()->first()->surname @endphp">
            </div>
            <div class="form-group">
                <label for="status">Durumu</label>
                <input class="form-control" id="status" value="@php echo $product->status()->get()->first()->name @endphp">
            </div>
            <div class="form-group">
                <strong><h4 style="text-align: center">İşlemler</h4></strong>
                <hr>
                <table id="ops" class="table table-hover">
                    <thead>
                    <tr>
                        <th>İşlem Türü</th>
                        <th>Açıklaması</th>
                        <th>SNO</th>
                        <th>Teknisyen</th>
                        <th>Sil</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($product->details()->get() as $detail)

                        <tr>
                            <td>@php echo $detail->operation()->get()->first()->name @endphp</td>
                            <td>@php echo $detail->operation_description @endphp</td>
                            <td>@php echo $detail->sno @endphp</td>
                            <td>@php echo $detail->technician->get()->first()->name . ' ' .$detail->technician->get()->first()->surname @endphp</td>
                            <td><i onclick="
                                $('#opsId').val('@php echo $detail->id @endphp');
                                        $('#deleteOps').modal('show');
                            " class="fa fa-trash" aria-hidden="true"></i></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>


@endsection