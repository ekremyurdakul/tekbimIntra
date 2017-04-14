@extends('layouts.stock_app')

@section('content')
    <div class="container">

        <h2 style="text-align: center">Stok Sayım Datası</h2>
        <input class="form-control" id="system-search" name="q" placeholder="Arama" required>
        <table class="table table-list-search">
            <thead>
            <tr>
                <th>Urun Kodu</th>
                <th>EAN</th>
                <th>ACIKLAMA 1</th>
                <th>ACIKLAMA 2</th>
                <th>RESIM URL</th>
                <th>MIKTAR</th>
            </tr>
            </thead>
            <tbody>

            @foreach($data as  $d)
                <tr>
                    <td>@php echo $d->productcode @endphp</td>
                    <td>@php echo $d->barcode @endphp</td>
                    <td>@php echo $d->description1 @endphp</td>
                    <td>@php echo $d->description2 @endphp</td>
                    <td>@php echo $d->imagepath @endphp</td>
                    <td>@php echo $d->totalquantity @endphp</td>
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

@endsection