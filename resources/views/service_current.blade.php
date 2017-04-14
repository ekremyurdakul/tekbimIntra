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
        @php $counter = 0; @endphp
        @foreach($statuses as $status)

                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title text-center">
                                <a data-toggle="collapse" href="@php echo '#collapse' . $counter @endphp">@php echo $status->name @endphp</a>
                            </h4>
                        </div>
                        <div id="@php echo 'collapse' . $counter @endphp" class="panel-collapse collapse">
                            <div class="panel-body">
                                @foreach($status->products()->get() as $product)
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
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

        @php $counter = $counter + 1; @endphp

        @endforeach
    </div>

@endsection