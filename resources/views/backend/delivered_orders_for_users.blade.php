@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Təslim edilən sifarişlər</h3>
                    <input type="button" onclick="tableToExcel('table_excel', 'purchases')" value="Export to Excel" style="float: right;" class="btn btn-success">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div id="search-inputs-area" class="search-areas">
                                <input type="text" class="form-control search-input" id="product_search" placeholder="Malın adı" value="{{$search_arr['product']}}">
                                <input type="text" class="form-control search-input" id="brand_search" placeholder="Marka" value="{{$search_arr['brand']}}">
                                <input type="text" class="form-control search-input" id="model_search" placeholder="Model" value="{{$search_arr['model']}}">
                                <select class="form-control search-input" id="category_search">
                                    <option value="">Kateqoriya</option>
                                    @foreach($categories as $category)
                                        @if($category->id == $search_arr['category'])
                                            <option selected value="{{$category->id}}">{{$category->process}}</option>
                                        @else
                                            <option value="{{$category->id}}">{{$category->process}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if(Auth::user()->delivered_person() != 1)
                                    <select class="form-control search-input" id="warehouseman_search">
                                        <option value="">Anbardar</option>
                                        @foreach($warehousemen as $warehouseman)
                                            @if($warehouseman->id == $search_arr['warehouseman'])
                                                <option selected value="{{$warehouseman->id}}">{{$warehouseman->name}} {{$warehouseman->surname}}</option>
                                            @else
                                                <option value="{{$warehouseman->id}}">{{$warehouseman->name}} {{$warehouseman->surname}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @endif
                                @if(Auth::user()->authority() != 3)
                                    <select class="form-control search-input" id="department_search">
                                        <option value="">Departament</option>
                                        @foreach($departments as $department)
                                            @if($department->id == $search_arr['department'])
                                                <option selected value="{{$department->id}}">{{$department->Department}}</option>
                                            @else
                                                <option value="{{$department->id}}">{{$department->Department}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @endif
                                <select class="form-control search-input" id="vehicle_search">
                                    <option value="">Texnika</option>
                                    @foreach($vehicles as $vehicle)
                                        @if($vehicle->id == $search_arr['vehicle'])
                                            <option selected value="{{$vehicle->id}}">{{$vehicle->QN}} - {{$vehicle->Marka}}
                                                - {{$vehicle->Tipi}}</option>
                                        @else
                                            <option value="{{$vehicle->id}}">{{$vehicle->QN}} - {{$vehicle->Marka}}
                                                - {{$vehicle->Tipi}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <select class="form-control search-input" id="status_search">
                                    <option value="">Status</option>
                                    @foreach($statuses as $status)
                                        @if($status->id == $search_arr['status'])
                                            <option selected value="{{$status->id}}">{{$status->status}}</option>
                                        @else
                                            <option value="{{$status->id}}">{{$status->status}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-primary" onclick="search_data();">Axtar</button>
                            </div>
                            <div id="search-type-area" class="search-areas">
                                <label for="date_search">Tarix aralığı</label>
                                <input type="checkbox" id="date_search" placeholder="max" onclick="date_area();">
                            </div>
                            <div id="search-date-area" class="search-areas">
                                <label for="start_date">Hardan</label>
                                <input type="date" id="start_date_search" class="form-control search-input" value="{{$search_arr['start_date']}}">
                                <label for="end_date">Hara</label>
                                <input type="date" id="end_date_search" class="form-control search-input" value="{{$search_arr['end_date']}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="table-responsive">
                                <div>
                                    {!! $purchases->links(); !!}
                                </div>
                                <table class="table table-bordered" id="table_excel">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        @if(Auth::user()->delivered_person() == 0)
                                            <th class="column-title">#</th>
                                        @endif
                                        <th class="column-title" style="min-width: 100px;">Sifarişçi </th>
                                        <th class="column-title">Status </th>
                                        <th class="column-title">Malın adı </th>
                                        <th class="column-title">Marka </th>
                                        <th class="column-title">Model </th>
                                        <th class="column-title">Part No </th>
                                        <th class="column-title">Miqdar </th>
                                        <th class="column-title">Ölçü vahidi </th>
                                        <th class="column-title">## </th>
                                        <th class="column-title">Səbəb </th>
                                        <th class="column-title">Yaradılma tarixi </th>
                                        <th class="column-title">Qiymətləndirən </th>
                                        <th class="column-title">Qiyməti təsdiq edən </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @php
                                        $row = 1;
                                    @endphp
                                    @foreach($purchases as $purchase)
                                        <?php
                                            $date = date('d.m.Y', strtotime($purchase->created_at));
                                        ?>
                                        <tr class="even pointer rows" id="row_{{$row}}" onclick="select_row({{$row}})">
                                            <td>{{$purchase->order_id}}</td>
                                            @if(Auth::user()->delivered_person() == 0)
                                                <td><span onclick="undelivered_order({{$purchase->order_id}});" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></span></td>
                                            @endif
                                            <td title="{{$purchase->Department}}">{{mb_substr($purchase->name, 0, 1)}}. {{$purchase->surname}}</td>
                                            <td><span onclick="show_status({{$purchase->order_id}}, '{{$purchase->Product}}');" style="background-color: {{$purchase->status_color}}; border-color: {{$purchase->status_color}};" class="btn btn-primary btn-xs">{{$purchase->status}}</span></td>
                                            <td>{{$purchase->Product}}</td>
                                            <td>{{$purchase->Brend}}</td>
                                            <td>{{$purchase->Model}}</td>
                                            <td>{{$purchase->PartSerialNo}}</td>
                                            <td>{{$purchase->pcs}}</td>
                                            <td>{{$purchase->Unit}}</td>
                                            <td>
                                                @if(!empty($purchase->image))
                                                    <span title="Şəkli göstər" class="btn btn-success btn-xs" onclick="show_image('{{$purchase->image}}');"><i class="fa fa-image"></i></span>
                                                @else
                                                    <span title="Şəkil yoxdur" disabled class="btn btn-danger btn-xs"><i class="fa fa-image"></i></span>
                                                @endif

                                                @if(!empty($purchase->a_Remark))
                                                    <span title="Qeydi göstər" class="btn btn-warning btn-xs" onclick="show_remark('{{$purchase->a_Remark}}');"><i class="fa fa-eye"></i></span>
                                                @else
                                                    <span title="Qeyd yoxdur" disabled class="btn btn-danger btn-xs"><i class="fa fa-eye"></i></span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($purchase->order_remark))
                                                    <span title="Göstər" class="btn btn-success btn-xs" onclick="show_order_remark('{{$purchase->order_remark}}');"><i class="fa fa-eye"></i></span>
                                                @else
                                                    <span title="Yoxdur" disabled class="btn btn-danger btn-xs"><i class="fa fa-eye"></i></span>
                                                @endif
                                            </td>
                                            <td>{{$date}}</td>
                                            <td title="{{$purchase->supply_date}}">{{$purchase->supply_name}} {{$purchase->supply_surname}}</td>
                                            <td title="{{$purchase->lawyer_date}}">{{$purchase->lawyer_name}} {{$purchase->lawyer_surname}}</td>
                                        </tr>
                                        @php
                                            $row++;
                                        @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                                <div>
                                    {!! $purchases->links(); !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--status modal--}}
    <div class="modal fade" id="status-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="status_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="headings">
                            <th class="column-title">#</th>
                            <th class="column-title">Status</th>
                            <th class="column-title">Tarix</th>
                        </tr>
                        </thead>
                        <tbody id="status_table">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--show data (image or remark)--}}
    <div class="modal fade" id="data-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="show-data">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script type="text/javascript">
        var tableToExcel = (function() {
            var uri = 'data:application/vnd.ms-excel;base64,'
                , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
                , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
                , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
            return function(table, name) {
                if (!table.nodeType) table = document.getElementById(table)
                var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
                window.location.href = uri + base64(format(template, ctx))
            }
        })()
    </script>

    <script>
        // tell the embed parent frame the height of the content
        if (window.parent && window.parent.parent){
            window.parent.parent.postMessage(["resultsFrame", {
                height: document.body.getBoundingClientRect().height,
                slug: "cmewv"
            }], "*")
        }

        // always overwrite window.name, in case users try to set it manually
        window.name = "result"
    </script>

    <script type="text/javascript">
        //select row
        function select_row(row) {
            $('.rows').css('background-color', 'white');
            $('#row_'+row).css('background-color', '#acecff');
        }

        //search start
        var show_date_area = false;

        $(document).ready(function(){
            var url = window.location.href;
            var url_arr = url.split('product');
            var where_url = 'product' + url_arr[1];

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

        function date_area() {
            if (show_date_area) {
                show_date_area = false;
                $('#search-date-area').css('display', 'none');
            } else {
                show_date_area = true;
                $('#search-date-area').css('display', 'block');
            }
        }

        function search_data() {
            var product = $('#product_search').val();
            var brand = $('#brand_search').val();
            var model = $('#model_search').val();
            @if(Auth::user()->authority() != 3)
                var department = $('#department_search').val();
            @else
                var department = '';
            @endif
            @if(Auth::user()->delivered_person() != 1)
                var warehouseman = $('#warehouseman_search').val();
            @else
                var warehouseman = '';
            @endif
            var category = $('#category_search').val();
            var vehicle = $('#vehicle_search').val();
            var status = $('#status_search').val();
            var start_date = $('#start_date_search').val();
            var end_date = $('#end_date_search').val();

            var link = '?product=' + product + '&brand=' + brand + '&model=' + model + '&category=' + category + '&status=' + status + '&vehicle=' + vehicle + '&start_date=' + start_date + '&end_date=' + end_date;

            @if(Auth::user()->authority() != 3)
                link += '&department=' + department;
            @endif

            @if(Auth::user()->delivered_person() != 1)
                link += '&warehouseman=' + warehouseman;
            @endif
                location.href = link;
        }
        //search end

        $(document).ready(function () {
            $('form').validate();
            $('form').ajaxForm({
                beforeSubmit:function () {
                    //loading
                    swal ({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Əməliyyat aparılır...</span>',
                        text: 'Əməliyyat aparılır, xaiş olunur gözləyin...',
                        showConfirmButton: false
                    });
                },
                success:function (response) {
                    swal(
                        response.title,
                        response.content,
                        response.case
                    );
                    if (response.case === 'success') {
                        location.reload();
                    }
                }
            });
        });

        @if(Auth::user()->delivered_person() == 0)
        //undelivered order
        function undelivered_order(id) {
            swal({
                title: 'Sifariş sizə çatdırılmayıb?',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Geri',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Bəli!'
            }).then(function (result) {
                if (result.value) {
                    swal({
                        title: 'Qeyd',
                        input: 'text',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        cancelButtonText: 'Geri',
                        confirmButtonText: 'Təsdiq et',
                        showLoaderOnConfirm: true,
                        preConfirm: (remark) => {
                            swal({
                                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Gözləyin...</span>',
                                text: 'Gözləyin, əməliyyat aparılır...',
                                showConfirmButton: false
                            });
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            $.ajax({
                                type: "Post",
                                url: '',
                                data: {
                                    'id': id,
                                    '_token': CSRF_TOKEN,
                                    'type': 'undelivered_order',
                                    'remark': remark
                                },
                                success: function (response) {
                                    swal.close();
                                    if (response.case === 'success') {
                                        location.reload();
                                    } else {
                                        swal(
                                            response.title,
                                            response.content,
                                            response.case
                                        );
                                    }
                                }
                            });
                        },
                    });
                } else {
                    return false;
                }
            });
        }
        @endif

        //show status
        function show_status(order_id, order) {
            swal ({
                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Əməliyyat aparılır...</span>',
                text: 'Əməliyyat aparılır, xaiş olunur gözləyin...',
                showConfirmButton: false
            });
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'order_id': order_id,
                    '_token': CSRF_TOKEN,
                    'type': 'show_status'
                },
                success: function (response) {
                    if (response.case === 'success') {
                        swal.close();

                        var statuses = response.statuses;
                        var i = 0;
                        var status_arr = '';
                        var no = 0;
                        var status = '';
                        var color = '';
                        var date = '';
                        var tr = '';
                        var table = '';
                        for (i=0; i<statuses.length; i++) {
                            status_arr = statuses[i];

                            no = i + 1;
                            status = status_arr['status'];
                            color = status_arr['status_color'];
                            date = status_arr['status_date'];

                            tr = '<tr><td>' + no + '</td><td style="color: ' + color + ';">' + status + '</td><td>' + date + '</td></tr>';
                            table = table + tr;
                        }

                        $('#status_title').html(order);
                        $('#status_table').html(table);
                        $('#status-modal').modal('show');
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

        function  show_image(image) {
            $(".show-data").html('<img src="' + image + '" width="200" height="200"><br><br><a href="' + image + '" target="_blank" class="btn btn-primary">Şəkilə tam ölçüdə baxmaq<a/>');
            $("#data-modal").modal('show');
        }

        function  show_remark(remark) {
            $(".show-data").html(remark);
            $("#data-modal").modal('show');
        }

        function  show_order_remark(remark) {
            $(".show-data").html(remark);
            $("#data-modal").modal('show');
        }
    </script>
@endsection
