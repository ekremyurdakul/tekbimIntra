@extends('layouts.app')

@section('content')
    <div class="container">,
        <div class="row">

            <div class="panel panel-default">
                <div class="panel-heading"><h4 style="text-align: center; font-weight: bold;" >Genel Durum</h4>
                    <div class="row">
                        <hr>

                    </div>


                    <div class="row">
                        <hr>
                        <h4>Bakılması Gereken Ürünler</h4>
                        <input class="form-control" id="system-search" name="q" placeholder="Search for" required>
                        <table class="table table-list-search">
                            <thead>
                            <tr>
                                <th>URUN KODU</th>
                                <th>URUN ACIKLAMASI</th>
                                <th>STOK TARIHI</th>
                                <th>RAF NUMARASI</th>
                                <th>CIKIS TARIHI</th>
                                <th>KULLANILAN MUSTERI</th>
                                <th>KULLANAN YETKILISI</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Sample</td>
                                <td>Filter</td>
                                <td>12-11-2011 11:11</td>
                                <td>OK</td>
                                <td>123</td>
                                <td>Do some other</td>
                            </tr>
                            <tr>
                                <td>Try</td>
                                <td>It</td>
                                <td>11-20-2013 08:56</td>
                                <td>It</td>
                                <td>Works</td>
                                <td>Do some FILTERME</td>
                            </tr>
                            <tr>
                                <td>§</td>
                                <td>$</td>
                                <td>%</td>
                                <td>&</td>
                                <td>/</td>
                                <td>!</td>
                            </tr>
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
