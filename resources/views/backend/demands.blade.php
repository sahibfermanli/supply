@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Tələbnamələr</h3>
                    <span style="float: right;" class="btn btn-success btn-add-new-demand"
                          onclick="add_demand();"><i class="fa fa-plus"></i></span>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="table-responsive">
                                <div>
                                    {!! $demands->links(); !!}
                                </div>
                                <table class="table table-bordered">
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title">Təlabnamə №</th>
                                        <th class="column-title">Yaradan istifadəçi</th>
                                        <th class="column-title">Yaradılma tarixi</th>
                                        <th class="column-title">#Əməliyyatlar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $row = 1;
                                    @endphp
                                    @foreach($demands as $demand)
                                        <?php
                                            $demand_date = date('d.m.Y', strtotime($demand->created_at));
                                        ?>
                                        <tr class="even pointer rows" id="row_{{$demand->id}}" onclick="select_row({{$demand->id}});">
                                            <td>{{$row}}</td>
                                            <td>{{$demand->id}}</td>
                                            <td>{{$demand->name}} {{$demand->surname}}</td>
                                            <td>{{$demand_date}}</td>
                                            <td>
                                                <span title="Alımları göstər"
                                                      class="btn btn-success btn-xs show-purchases-modal"
                                                      onclick="show_purchases(this, '{{$demand->id}}');"><i
                                                            class="fa fa-eye"></i></span>

                                                <a style="background-color: #99c2ff; border-color: #99c2ff;" href="/supply/demand/print?a={{$demand->id}}" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-money"></i></a>
                                                <span title="Sil" class="btn btn-danger btn-xs"
                                                      onclick="del(this, '{{$demand->id}}', '{{$row}}');"><i
                                                            class="fa fa-trash-o"></i></span>
                                            </td>
                                        </tr>
                                        @php
                                            $row++;
                                        @endphp
                                    @endforeach
                                    </tbody>
                            </table>
                                <div>
                                    {!! $demands->links(); !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- start select purchases modal-->
    <div class="modal fade " id="show-purchases-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog demand-modal-for-purchase" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6" id="free_purchases_table_div">
                            <h5 style="margin-bottom: 22px;">Gözləmədə olan sifarişlər</h5>
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="table-responsive" style="max-height: 300px !important;">
                                        <div id="demand_id_div"></div>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr class="headings">
                                                <th class="column-title">#</th>
                                                <th class="column-title">Əlavə et</th>
                                                <th class="column-title">Təhvil alan</th>
                                                <th class="column-title">Malın adı</th>
                                                <th class="column-title">Marka</th>
                                                <th class="column-title">Model</th>
                                                <th class="column-title">Miqdar</th>
                                                <th class="column-title">Ölçü vahidi</th>
                                                <th class="column-title">Qiymət</th>
                                                <th class="column-title">Ümumi qiymət</th>
                                                <th class="column-title">Şirkət</th>
                                                <th class="column-title">Status</th>
                                                <th class="column-title">Yaradılma tarixi</th>
                                            </tr>
                                            </thead>
                                            <tbody id="free_purchases_table">
                                            @php
                                                $row = 1;
                                            @endphp
                                            @foreach($free_purchases as $purchase)
                                                <?php
                                                $date = date('d.m.Y', strtotime($purchase->created_at));
                                                ?>
                                                <tr class="even pointer" id="move_{{$purchase->id}}">
                                                    <td>{{$purchase->order_id}}</td>
                                                    <td>
                                                        <span id="add_purchase_to_demand_span_{{$purchase->company_id}}" onclick="add_purchase_to_selected_demand({{$purchase->id}}, {{$purchase->OrderID}}, {{$purchase->delivered_person}}, {{$purchase->company_id}}, {{$purchase->MainPerson}});"
                                                              class="add_purchase_to_demand_span btn btn-success btn-xs"><i class="fa fa-plus"></i></span>
                                                    </td>
                                                    <td>{{substr($purchase->delivered_name, 0, 1)}}. {{$purchase->delivered_surname}}</td>
                                                    <td>{{$purchase->Product}}</td>
                                                    <td>{{$purchase->Brend}}</td>
                                                    <td>{{$purchase->Model}}</td>
                                                    <td>{{$purchase->pcs}}</td>
                                                    <td>{{$purchase->Unit}}</td>
                                                    <td>{{$purchase->cost}}</td>
                                                    <td>{{$purchase->total_cost}}</td>
                                                    <td>{{$purchase->company}}</td>
                                                    <td style="color: {{$purchase->status_color}};">{{$purchase->status}}</td>
                                                    <td>{{$date}}</td>
                                                </tr>
                                                @php
                                                    $row++;
                                                @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-6" id="selected_purchases_table_div">
                            <h5>Cari tələbnaməyə aid sifarişlər <span id="print-page-link"></span></h5>
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="table-responsive" style="max-height: 300px !important;">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr class="headings">
                                                <th class="column-title">#</th>
                                                <th class="column-title">Sil</th>
                                                <th class="column-title">Təhvil alan</th>
                                                <th class="column-title">Malın adı</th>
                                                <th class="column-title">Marka</th>
                                                <th class="column-title">Model</th>
                                                <th class="column-title">Miqdar</th>
                                                <th class="column-title">Ölçü vahidi</th>
                                                <th class="column-title">Qiymət</th>
                                                <th class="column-title">Ümumi qiymət</th>
                                                <th class="column-title">Şirkət</th>
                                                <th class="column-title">Status</th>
                                                <th class="column-title">Yaradılma tarixi</th>
                                            </tr>
                                            </thead>
                                            <tbody id="selected_purchases_table">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.end select-purchases-modal-->
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script>
        var demand_id = 0;

        //select row
        function select_row(row) {
            $('.rows').css('background-color', 'white');
            $('#row_'+row).css('background-color', '#acecff');

            demand_id = row;
        }

        $(document).ready(function(){
            var url = window.location.href;
            var url_arr = url.split('demandno');
            var where_url = 'demandno' + url_arr[1];

            if (url_arr.length > 1) {
                $('.pagination').each(function(){
                    $(this).find('a').each(function(){
                        var current = $(this);
                        var old_url = current.attr('href');
                        var new_url = old_url + '&' + where_url;
                        current.prop('href', new_url);
                    });
                });
            }
        });

        function search_data() {
            var demand = $('#demand_search').val();
            var edited = $('#edited_search').val();

            var link = '?demandno=' + demand + '&edited=' + edited;

            location.href = link;
        }

        function add_demand() {
            swal({
                title: 'Yeni tələbnamə yaratmaq istədiyinizdən əminsiniz?',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Geri',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Bəli!'
            }).then(function (result) {
                if (result.value) {
                    //loading
                    swal({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Gözləyin...</span>',
                        text: 'Gözləyin, əməliyyat aparılır..',
                        showConfirmButton: false
                    });
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "Post",
                        url: '',
                        data: {
                            '_token': CSRF_TOKEN,
                            'type': 'add'
                        },
                        success: function (response) {
                            swal.close();
                            if (response.case === 'success') {
                                location.reload();
                            }
                            else {
                                swal(
                                    response.title,
                                    response.content,
                                    response.case
                                );
                            }
                        }
                    });
                } else {
                    return false;
                }
            });
        }

        //show selected purchases when clicked demand
        function show_purchases(e, demand_id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            swal({
                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Gözləyin...</span>',
                text: 'Gözləyin, əməliyyat aparılır..',
                showConfirmButton: false
            });
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'demand_id': demand_id,
                    '_token': CSRF_TOKEN,
                    'type': 'show_purchases'
                },
                success: function (response) {
                    swal.close();
                    if (response.case === 'success') {
                        swal.close();

                        var table = '';
                        var purchases = response.selected_purchases;
                        var i = 0;
                        var count = 0;
                        var remove = '';

                        for (i = 0; i < purchases.length; i++) {
                            count++;
                            var purchase = purchases[i];

                            remove = '<td><span onclick="remove_purchase_from_selected_demand(' + purchase['id'] + ',' + purchase['OrderID'] + ');" class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></span></td>';

                            var person = '<td>' + purchase['delivered_name'].substr(0, 1) + '. ' + purchase['delivered_surname'] + '</td>';
                            var product = '<td>' + purchase['Product'] + '</td>';
                            var brend = '<td>' + purchase['Brend'] + '</td>';
                            var model = '<td>' + purchase['Model'] + '</td>';
                            var pcs = '<td>' + purchase['pcs'] + '</td>';
                            var unit = '<td>' + purchase['Unit'] + '</td>';
                            var cost = '<td>' + purchase['cost'] + '</td>';
                            var total_cost = '<td>' + purchase['total_cost'] + '</td>';
                            var company = '<td>' + purchase['company'] + '</td>';
                            var status = '<td><span style="color: ' + purchase['status_color'] + '">' + purchase['status'] + '</span></td>';
                            var date = '<td>' + purchase['created_at'].substr(0, 10) + '</td>';

                            var tr = '<tr class="even pointer" id="remove_' + purchase['id'] + '">';
                            tr = tr + '<td>' + purchase['OrderID'] + '</td>' + remove + person + product + brend + model + pcs + unit + cost + total_cost + company + status + date;
                            tr = tr + '</tr>';
                            table = table + tr;
                        }

                        // if (disabled === 1) {
                        //     $('#free_purchases_table_div').css('display', 'none');
                        //     $('#selected_purchases_table_div').removeClass('col-md-6 col-sm-6 col-xs-6');
                        //     $('#selected_purchases_table_div').addClass('col-md-12 col-sm-12 col-xs-12');
                        // }
                        // else {
                        //     $('#free_purchases_table_div').css('display', 'block');
                        //     $('#selected_purchases_table_div').addClass('col-md-6 col-sm-6 col-xs-6');
                        //     $('#selected_purchases_table_div').removeClass('col-md-12 col-sm-12 col-xs-12');
                        // }

                        $('#selected_purchases_table').html(table);

                        $('#show-purchases-modal').modal('show');
                    } else {
                        swal(
                            response.title,
                            response.content,
                            response.case
                        );
                    }
                }
            });
        }

        @if(Auth::user()->chief() == 1)
            function del(e, id, row_id) {
                swal({
                    title: 'Silmək istədiyinizdən əminsiniz?',
                    text: 'Bu əməliyyatın geri dönüşü yoxdur...',
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Geri',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sil!'
                }).then(function (result) {
                    if (result.value) {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            type: "Post",
                            url: '',
                            data: {
                                'id': id,
                                '_token': CSRF_TOKEN,
                                'row_id': row_id,
                                'type': 'delete'
                            },
                            beforeSubmit: function () {
                                //loading
                                swal({
                                    title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Gözləyin...</span>',
                                    text: 'Gözləyin, əməliyyat aparılır..',
                                    showConfirmButton: false
                                });
                            },
                            success: function (response) {
                                swal(
                                    response.title,
                                    response.content,
                                    response.case
                                );
                                if (response.case === 'success') {
                                    var elem = document.getElementById('row_' + response.row_id);
                                    elem.parentNode.removeChild(elem);
                                }
                            }
                        });
                    } else {
                        return false;
                    }
                });
            }
        @endif

        function add_purchase_to_selected_demand(purchase_id, order_id, person, company_id, MainPerson) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'demand_id': demand_id,
                    'purchase_id': purchase_id,
                    'order_id': order_id,
                    'delivered_person': person,
                    'MainPerson': MainPerson,
                    'company_id': company_id,
                    '_token': CSRF_TOKEN,
                    'type': 'add_purchase_to_selected_demand'
                },
                success: function (response) {
                    if (response.case === 'success') {
                        swal.close();
                        var table = '';
                        var purchase = response.purchase;

                        var remove = '<td><span onclick="remove_purchase_from_selected_demand(' + purchase['id'] + ',' + purchase['OrderID'] + ');" class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></span></td>';
                        var person = '<td>' + purchase['delivered_name'].substr(0,1) + ', ' + purchase['delivered_surname'] + '</td>';
                        var product = '<td>' + purchase['Product'] + '</td>';
                        var brend = '<td>' + purchase['Brend'] + '</td>';
                        var model = '<td>' + purchase['Model'] + '</td>';
                        var pcs = '<td>' + purchase['pcs'] + '</td>';
                        var unit = '<td>' + purchase['Unit'] + '</td>';
                        var cost = '<td>' + purchase['cost'] + '</td>';
                        var total_cost = '<td>' + purchase['total_cost'] + '</td>';
                        var company = '<td>' + purchase['company'] + '</td>';
                        var status = '<td><span style="color: ' + purchase['status_color'] + '">' + purchase['status'] + '</span></td>';
                        var date = '<td>' + purchase['created_at'].substr(0, 10) + '</td>';

                        var tr = '<tr class="even pointer" id="remove_' + purchase['id'] + '">';
                        tr = tr + '<td>' + '<span style="color: green;">' + purchase['OrderID'] + '</span>' + '</td>' + remove + person + product + brend + model + pcs + unit + cost + total_cost + company + status + date;
                        tr = tr + '</tr>';
                        table = table + tr;

                        $('#move_' + purchase['id']).remove();
                        $('#selected_purchases_table').append(table);
                    }
                    else {
                        swal(
                            response.title,
                            response.content,
                            response.case
                        );
                    }
                }
            });
        }

        function remove_purchase_from_selected_demand(purchase_id, order_id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'purchase_id': purchase_id,
                    'order_id': order_id,
                    '_token': CSRF_TOKEN,
                    'type': 'remove_purchase_from_selected_demand'
                },
                success: function (response) {
                    swal(
                        response.title,
                        response.content,
                        response.case
                    );
                    if (response.case === 'success') {
                        swal.close();
                        var table = '';
                        var purchase = response.purchase;

                        var move_btn = '<td><span id="add_purchase_to_demand_span_' + purchase['company_id'] + '" onclick="add_purchase_to_selected_demand(' + purchase['id'] + ',' + purchase['OrderID'] + ',' + purchase['delivered_person'] + ',' + purchase['company_id'] + ',' + purchase['MainPerson'] + ');" class="add_purchase_to_demand_span btn btn-success btn-xs"><i class="fa fa-plus"></i></span></td>';
                        var person = '<td>' + purchase['delivered_name'].substr(0,1) + '. ' + purchase['delivered_surname'] + '</td>';
                        var product = '<td>' + purchase['Product'] + '</td>';
                        var brend = '<td>' + purchase['Brend'] + '</td>';
                        var model = '<td>' + purchase['Model'] + '</td>';
                        var pcs = '<td>' + purchase['pcs'] + '</td>';
                        var unit = '<td>' + purchase['Unit'] + '</td>';
                        var cost = '<td>' + purchase['cost'] + '</td>';
                        var total_cost = '<td>' + purchase['total_cost'] + '</td>';
                        var company = '<td>' + purchase['company'] + '</td>';
                        var status = '<td><span style="color: ' + purchase['status_color'] + '">' + purchase['status'] + '</span></td>';
                        var date = '<td>' + purchase['created_at'].substr(0, 10) + '</td>';

                        var tr = '<tr class="even pointer" id="move_' + purchase['id'] + '">';
                        tr = tr + '<td>' + '<span style="color: green;">' + purchase['OrderID'] + '</span>' + '</td>' + move_btn + person + product + brend + model + pcs + unit + cost + total_cost + company + status + date;
                        tr = tr + '</tr>';
                        table = table + tr;

                        $('#remove_' + purchase['id']).remove();
                        $('#free_purchases_table').append(table);
                    }
                }
            });
        }

        $(document).ready(function () {
            $('form').validate();
            $('form').ajaxForm({
                beforeSubmit: function () {
                    //loading
                    swal({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                        text: 'Loading, please wait...',
                        showConfirmButton: false
                    });
                },
                success: function (response) {
                    swal(
                        response.title,
                        response.content,
                        response.case
                    );
                    if (response.case === 'success') {
                        // if (response.type === 'add_demand') {
                        //     location.reload();
                        // }
                        location.reload();
                    }
                }
            });
        });
    </script>
@endsection