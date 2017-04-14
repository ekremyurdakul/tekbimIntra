@extends('layouts.app')

@section('content')


    <div class="container">
        @if(sizeof($authorisation) == 0)

            Yetkiniz Bulunmamaktadır.

            @else

            @foreach($authorisation as $auth)

                <div style = "padding-top: 15px"  class="row">
                    <a href="@php echo $auth->module()->first()->link @endphp" style="width: 100%" class="btn btn-primary">@php echo $auth->module()->first()->name  @endphp</a>
                </div>

            @endforeach

        @endif

    </div>
@endsection
