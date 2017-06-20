@extends('layouts.service')
<style>
    .panel-danger{
        border-color: red;
    }
    .panel-primary{
        border-color: darkblue;
    }
</style>
@section('content')
<div class="container">
    <h3 style="text-align: center">Teslime Hazır Ürünler</h3>
    @if(count($finishedProducts ) == 0)
        <p style="text-align: center;padding-top: 40px">Teslime Hazır Ürün Bulunmamaktadır</p>
    @endif
    @foreach($finishedProducts as $product)
        @php if($product->priority == 1){$panelType = 'panel-danger';}else{$panelType = 'panel-primary';} @endphp
        <div class="col-sm-4">
            <div  class="@php echo 'panel '. $panelType @endphp">
                <div class="panel title text-center">
                    <strong>@php echo $product->model @endphp</strong>
                </div>
                <div class="panel-body">
                    <p><strong>Müşteri : </strong> @php echo $product->customer()->first()->name @endphp</p>
                    <p><strong>SNO : </strong> @php echo $product->sno @endphp</p>
                    <p><strong>Getiren Kişi : </strong> @php echo $product->person @endphp</p>
                    <p><strong>Arızası : </strong> </p>
                    <textarea>@php echo $product->fault_description @endphp</textarea>
                    <p style="padding-top: 10px">
                        <a style="width: 100%" class="btn btn-primary" href="/service/handover/@php echo $product->id @endphp">Teslim Et</a>

                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection