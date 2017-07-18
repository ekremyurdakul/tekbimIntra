@extends('layouts.service')

@section('content')
    <style>
        .panel-danger{
            border-color: red;
        }
        .panel-primary{
            border-color: darkblue;
        }
    </style>
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
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div id="confirm-delete-header" class="modal-header">
                        ...
                    </div>
                    <div id = "confirm-delete-body" class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">

                        <form id="confirm-delete-form" method="post" action="">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="confirm-delete-id" value="">
                            <input type="submit" class="btn btn-danger btn-ok" value="Delete">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <div class="modal fade" id="editProductTechnician" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Sorumlu Teknisyenlik</h4>
                </div>
                <div class="modal-body">
                    <form action="/service/aedit/technic" method="post">
                        <div class="form-group">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input id="productId" type="hidden" name="id" value="">

                        </div>
                        <p>Bu ürün üzerinde "Sorumlu Teknisyenliği" kabul ediyor musunuz?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Gönder</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProductStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Durum Değişikliği</h4>
                </div>
                <div class="modal-body">
                    <form action="/service/aedit/technic/statusChange" method="post">
                        <div class="form-group">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input id="statusproductId" type="hidden" name="id" value="">

                        </div>
                        <p>Lütfen Durum Seçiniz</p>
                        <select name="statusId">
                            @foreach($statuses as $status)
                                @if($status->name != "Teslim Edildi")
                                <option value="@php echo $status->id @endphp">@php echo $status->name @endphp</option>
                                @endif
                            @endforeach
                        </select>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Gönder</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                </div>
                </form>
            </div>
        </div>
    </div>


        <div class="modal fade" id="addOperation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">İşlem Ekle</h4>
                    </div>
                    <div id = "operationBody" class="modal-body">

                        <form id="operationForm" action="/service/aedit/technic/addOperation" method="post">
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input id="operationproductId" type="hidden" name="id" value="">

                            </div>
                            <div class="form-group">
                                <label for="email">İşlem Türü: </label>
                                <select required id="operationSelect" name="operationId" class="form-control">
                                    @foreach($operations as $operation)
                                        <option value="@php echo $operation->id @endphp">@php echo $operation->name @endphp</option>
                                    @endforeach
                                </select>
                            </div>
                            <script>
                                $(document).on('change', '#operationSelect', function(e) {
                                    console.log('test');
                                    $.get( '/service/aedit/technic/serialneed/' + $('#operationSelect').val() , function( data ) {
                                        $('#temp').remove();
                                        if(eval(data)){

                                            $('#operationForm').append('<div id="temp" class="form-group"> <label for="serial">SNO </label> <input required id="serial" name="sno"  class="form-control"> </div>');
                                }
                                });
                                    console.log();
                                });
                            </script>
                            <div class="form-group">
                                <label for="operationDescription">İşlem Açıklaması </label>
                                <textarea required id="operationDescription" name="description"  class="form-control">

                            </textarea>

                            </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Gönder</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>



    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Teknik Eleman :</strong>  @php echo Auth::user()->name . ' ' . Auth::user()->surname @endphp
                <a></a>
            </div>

            <div id="exTab2">
                <ul class="nav nav-tabs">
                    @php $counter=0; @endphp
                    @foreach($statuses as $status)
                        @if($counter == 0)
                            <li class="active">
                                <a  href="#@php echo $counter @endphp" data-toggle="tab">@php echo $status->name @endphp</a>
                            </li>
                        @else
                            <li>
                                <a href="#@php echo $counter @endphp" data-toggle="tab">@php echo $status->name @endphp</a>
                            </li>
                        @endif
                        @php $counter++; @endphp
                    @endforeach
                </ul>

                <div class="tab-content ">
                    @php $counter = 0; @endphp
                    @foreach($statuses as $status)
                        @if($counter == 0)
                            <div class="tab-pane active" id="@php echo $counter @endphp">
                                <div class="panel-body">
                                    @foreach($status->products()->get() as $product)
                                        @php if($product->priority == 1){$panelType = 'panel-danger';}else{$panelType = 'panel-primary';} @endphp
                                        <div class="col-sm-4">
                                            <div  class="@php echo 'panel '. $panelType @endphp">
                                                <div class="panel title text-center">
                                                    <strong><a onclick="

                                                    $('#productId').val('@php echo $product->id @endphp');
                                                    $('#editProductTechnician').modal('show');

                                                    ">@php echo $product->model @endphp</a></strong>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>Müşteri : </strong> @php echo $product->customer()->first()->name @endphp</p>
                                                    <p><strong>SNO : </strong> @php echo $product->sno @endphp</p>
                                                    <p><strong>Getiren Kişi : </strong> @php echo $product->person @endphp</p>
                                                    <p><strong>Arızası : </strong> </p>
                                                    <textarea>@php echo $product->fault_description @endphp</textarea>
                                                    <p>
                                                        <a onclick="
                                                                $('#confirm-delete-id').val('@php echo $product->id @endphp');
                                                                $('#confirm-delete-header').html('Sil');
                                                                $('#confirm-delete-body').html('Bu kaydı silmek istediğinize emin misiniz?');
                                                                $('#confirm-delete-form').attr('action','/service/aedit/technic/deleteProduct');
                                                                $('#confirm-delete').modal('show');

                                                                " style="width: 100%" class="btn btn-danger">Sil</a>

                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="tab-pane" id="@php echo $counter @endphp">
                                <div class="panel-body">
                                    @foreach($status->products()->get() as $product)
                                        @php if($product->priority == 1){$panelType = 'panel-danger';}else{$panelType = 'panel-primary';} @endphp
                                        <div class="col-sm-4">
                                            <div  class="@php echo 'panel '. $panelType @endphp">
                                                <div class="panel title text-center">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" data-toggle="dropdown"><strong>@php echo $product->model @endphp</strong></a>
                                                        <ul class="dropdown-menu">
                                                            <li><a onclick="
                                                                        $('#operationproductId').val('@php echo $product->id @endphp');
                                                                        $('#addOperation').modal('show')
                                                                        ">İşlem Ekle</a></li>
                                                            <li><a onclick="
                                                                        $('#statusproductId').val('@php echo $product->id @endphp');
                                                                        $('#editProductStatus').modal('show');
                                                                        ">Durum Değişikliği</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <p><strong>Müşteri : </strong> @php echo $product->customer()->first()->name @endphp</p>
                                                    <p><strong>SNO : </strong> @php echo $product->sno @endphp</p>
                                                    <p><strong>Getiren Kişi : </strong> @php echo $product->person @endphp</p>
                                                    <p><strong>Arızası : </strong> </p>
                                                    <textarea>@php echo $product->fault_description @endphp</textarea>
                                                    <p><strong>Sorumlu Teknisyen : </strong> @php echo $product->technician()->get()->first()->name  . ' ' .  $product->technician()->get()->first()->surname @endphp</p>
                                                    <p> @if(count($product->details()->get()) > 0)
                                                            <a href="/service/aedit/technic/product/@php echo $product->id @endphp" id="btn1" style="width: 100%" class="btn btn-success">İşlemler</a>
                                                        @else
                                                            <a style="width: 100%" class="btn btn-primary disabled">İşlem Yok</a>
                                                        @endif
                                                    </p>
                                                    <p>
                                                        <a onclick="
                                                            $('#confirm-delete-id').val('@php echo $product->id @endphp');
                                                            $('#confirm-delete-header').html('Sil');
                                                            $('#confirm-delete-body').html('Bu kaydı silmek istediğinize emin misiniz?');
                                                            $('#confirm-delete-form').attr('action','/service/aedit/technic/deleteProduct');
                                                            $('#confirm-delete').modal('show');

                                                        " style="width: 100%" class="btn btn-danger">Sil</a>

                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @php $counter++; @endphp
                    @endforeach

                </div>
            </div>

        </div>
    </div>

</div>
@endsection