@extends('layouts.employee')

@section('content')
<div class="container">
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading"><h4 style="text-align: center; font-weight: bold;" >Genel Personel Durumu</h4>
                <div class="row">
                    <hr>

                </div>
                <div class="modal fade" id="EmployeePrivs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                Personel Yetkinlikleri
                            </div>
                            <div class="modal-body">
                                <form method="post" action="/employee/aedit">
                                @foreach($modules as $module)

                                    <div class="form-group">
                                        <label> @php echo $module->name @endphp</label>
                                        <select name="@php echo $module->id @endphp" >
                                            @foreach($authorisationtypes as $type)
                                                <option value="@php echo $type->id @endphp" >@php echo $type->name @endphp</option>
                                            @endforeach
                                                <option value="NAN">No Access</option>

                                        </select>
                                        </div>

                                @endforeach

                            </div>
                            <div class="modal-footer">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="id" id="employee_id">
                                    <button type="submit" class="btn btn-success btn-ok">Bitir</button>


                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <hr>
                    <h4>Personeller</h4>
                    <input class="form-control" id="system-search" name="q" placeholder="Arama" required>
                    <table class="table table-list-search">
                        <thead>
                        <tr>
                            <th>Personel Id</th>
                            <th>İsim</th>
                            <th>Soyisim</th>
                            <th>Email</th>
                            <th>Yetkinlikler</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($users as $user)

                            <tr>
                                <td id = 'table_employee_id'>@php echo $user->id; @endphp</td>
                                <td>@php echo $user->name; @endphp</td>
                                <td>@php echo $user->surname; @endphp</td>
                                <td>@php echo $user->email; @endphp</td>
                                <td>@php foreach ($user->authorisations()->get() as $auth){

                                echo $auth->module()->first()->name . '/';

                                } @endphp</td>
                                <td ><i title="Yetkinlik" class="fa fa-sign-in fa-2x" style="padding-right: 10px" aria-hidden="true" onclick="
                                $('#employee_id').attr('value', '@php echo $user->id @endphp');
                                $('#EmployeePrivs').modal('show');"></i>
                                    <i title="Kullanıcı Bilgileri" class="fa fa-pencil fa-2x" aria-hidden="true"></i></td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>

                    <script>
                        $(document).ready(function() {
                            var activeSystemClass = $('.list-group-item.active');

                            //something is entered in search form
                            $('#system-search').keyup( function() {
                                console.log('TEST');
                                var that = this;
                                // affect all table rows on in systems table
                                var tableBody = $('.table-list-search tbody');
                                var tableRowsClass = $('.table-list-search tbody tr');
                                $('.search-sf').remove();
                                tableRowsClass.each( function(i, val) {

                                    //Lower text for case insensitive
                                    var rowText = $(val).text().toLowerCase();
                                    var inputText = $(that).val().toLowerCase();
                                    if(inputText != '')
                                    {
                                        $('.search-query-sf').remove();
                                        tableBody.prepend('<tr class="search-query-sf"><td colspan="6"><strong>Searching for: "'
                                                + $(that).val()
                                                + '"</strong></td></tr>');
                                    }
                                    else
                                    {
                                        $('.search-query-sf').remove();
                                    }

                                    if( rowText.indexOf( inputText ) == -1 )
                                    {
                                        //hide rows
                                        tableRowsClass.eq(i).hide();

                                    }
                                    else
                                    {
                                        $('.search-sf').remove();
                                        tableRowsClass.eq(i).show();
                                    }
                                });
                                //all tr elements are hidden
                                if(tableRowsClass.children(':visible').length == 0)
                                {
                                    tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="6">No entries found.</td></tr>');
                                }
                            });
                        });

                    </script>
                </div>


            </div>
        </div>


    </div>
</div>

@endsection