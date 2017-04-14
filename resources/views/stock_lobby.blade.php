@extends('layouts.stock_app')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Modal -->
    <div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Yeni Grup</h4>
                </div>
                <div class="modal-body">
                    <form action="/stock/lobby/addGroup" method="post">
                        <div class="form-group">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="@php echo $sessionId @endphp">
                            <label for="exampleInputEmail1">İsim</label>
                            <input required class="form-control" id="exampleInputEmail1" name="stockGroupName" aria-describedby="emailHelp" placeholder="isim">

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

    <div class="container">

        @php
        $size = sizeof($groups);
        if($size == 0){

            echo '<div class="row">
            <div class="col-sm-4">
            <div class="panel panel-default">
            <div class="panel-heading" style="text-align: center; font-weight: bold;">
            <a onclick="' . " $('#addGroup').modal('show');" . '"><h2>+</h2></a></div></div></div></div>';

        }else{

        $counter = 0;
            echo '<div class="row">';

            foreach ($groups as $group){

                if($counter == 3){
                    echo '</div>';
                    echo '<div class="row">';
                    $counter = 0;

                }
                echo '<div class="col-sm-4">
                <div class="panel panel-default">
                <div class="panel-heading">
                <h4 style="text-align: center; font-weight: bold;" >'. $group->name .'</h4></div>
                ';
                foreach($group->users as $user){
                    echo '<div style="text-align: center; padding-bottom: 15px"><strong>' . $user->name . '</strong></div>';
                }
                if($group->memberOf(\Illuminate\Support\Facades\Auth::user())){
                    echo '<a href="/stock/lobby/display/'.$group->id.'" style="width: 100%" class="btn btn-info">Aç</a>';
                }else{
                    echo '<a href="/stock/lobby/join/'. $group->id .' " style="width: 100%" class="btn btn-primary">Katıl</a>';
                }

                if($group->user_id == \Illuminate\Support\Facades\Auth::user()->id){
                    echo '<a href="/stock/lobby/delete/'. $group->id .'" style="width: 100%" class="btn btn-danger">Sil</a>';
                }
                echo '</div></div>  ';
                $counter++;
            }

            if(($counter % 3) != 0){

            echo '
            <div class="col-sm-4">
            <div class="panel panel-default">
            <div class="panel-heading" style="text-align: center; font-weight: bold;">
            <a onclick="' . " $('#addGroup').modal('show');" . '"><h2>+</h2></a></div></div></div>';

            }else{
            echo '</div><div class="row">
            <div class="col-sm-4">
            <div class="panel panel-default">
            <div class="panel-heading" style="text-align: center; font-weight: bold;">
            <a onclick="' . " $('#addGroup').modal('show');" . '"><h2>+</h2></a></div></div></div></div>';

            }
        }
                @endphp
    </div>
@endsection
