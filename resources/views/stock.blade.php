@extends('layouts.stock_app')

@section('content')

<style>
    .custab{
        border: 1px solid #ccc;
        padding: 5px;
        margin: 5% 0;
        box-shadow: 3px 3px 2px #ccc;
        transition: 0.5s;
    }
    .custab:hover{
        box-shadow: 3px 3px 0px transparent;
        transition: 0.5s;
    }

</style>
<!-- Modal -->
<div class="modal fade" id="addStockCount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Yeni Stok Sayımı</h4>
            </div>
            <div class="modal-body">
                <form action="/stock/add" method="post">
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label for="exampleInputEmail1">İsim</label>
                        <input required class="form-control" id="exampleInputEmail1" name="stockCountName" aria-describedby="emailHelp" placeholder="isim">

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

<div class="modal fade" id="endStockCount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Stok Sayımı Bitirilsin mi?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                <form method="post" action="/stock/finish">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="endStockCount_id">
                    <button type="submit" class="btn btn-success btn-ok">Bitir</button>
                </form>

            </div>
        </div>
    </div>
</div>

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading"><h4 style="text-align: center; font-weight: bold;" >Stok Sayımları</h4></div>

                <table class="table table-striped custab">
                    <thead>

                    <tr>
                        <th>ID</th>
                        <th>Isim</th>
                        <th>Yaratan</th>
                        <th>Durum</th>
                        <th>Islemler</th>
                    </tr>
                    <br>

                    <button type="button"
                            data-toggle="modal"
                            data-target="#addStockCount"
                            href="#" class="btn btn-primary btn-xs pull-right"><b>+</b> Yeni Stok Sayımı</button>
                    </thead>


                        @foreach($sessions as $session)
                        <tr>
                            <td>@php echo $session->id @endphp</td>
                            <td>@php echo $session->name @endphp</td>
                            <td>@php echo \App\User::find($session->user_id)->name @endphp</td>
                            <td>
                                @if(!$session->isFinished)
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                @endif
                                </td>
                            <td>

                                @if($session->isFinished)
                                    <a href="/stock/data/@php echo $session->id @endphp" class="btn btn-info btn-xs">Data Al</a>
                                @else
                                        <a href="/stock/lobby/@php echo $session->id @endphp" class="btn btn-primary btn-xs">Lobby</a>
                                    @if (Auth::user()->id == $session->user_id)
                                        <button onclick="
                                                $('#endStockCount_id').attr('value', '@php echo $session->id @endphp');
                                                $('#endStockCount').modal('show');
                                                "        class="btn btn-success btn-xs">Bitir</button>
                                    @endif
                                @endif
                                </td>

                        </tr>
                        @endforeach

                </table>
            <br>


    </div>
    </div>
@endsection
