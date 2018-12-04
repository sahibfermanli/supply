@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Raportlar</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="table-responsive">
                                <div>
                                    {!! $reports->links(); !!}
                                </div>
                                <form action="" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <input type="hidden" name="type" value="5">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr class="jsgrid-filter-row">
                                        <td id="add-btn-td"><button type="submit" id="add-btn" class="btn btn-success btn-xs"><i class="fa fa-plus"></i></button></td>
                                        <td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Subject" placeholder="Başlıq *"></td>
                                        <td colspan="2" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Text" placeholder="Məzmun *"></td>
                                        <td colspan="3" id="orders-add-inputs" style="width: 150px;"><input type="file" class="form-control input-sm" name="file"></td>
                                    </tr>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title">Başlıq</th>
                                        <th class="column-title">Tarix</th>
                                        <th class="column-title">Raport No</th>
                                        <th class="column-title">Status</th>
                                        <th class="column-title">Raport</th>
                                        <th class="column-title">#Sifarişlər</th>
                                        {{--<th class="column-title">#Action</th>--}}
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @php
                                        $row = 1;
                                    @endphp
                                    @foreach($reports as $report)
                                        <?php $report_date = date('d.m.Y', strtotime($report->created_at)); ?>
                                        <?php
                                        if (isset($report->ReportNo)){
                                            $report_no = $report->ReportNo;
                                        }
                                        else {
                                            $report_no = '---';
                                        }
                                        ?>
                                        <tr class="even pointer" id="row_{{$row}}">
                                            <td>{{$row}}</td>
                                            <td><a title="Məzmunu göstər" href="#popup{{$report->id}}"
                                                   class="btn btn-default btn-xs">{{$report->Subject}}</a></td>
                                            <td>{{$report_date}}</td>
                                            <td>{{$report_no}}</td>
                                            <td><span class="btn btn-xs" style="color: {{$report->color}};">{{$report->status}}</span></td>
                                            <td><center><a title="Faylı endir" href="{{$report->ReportDocument}}" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-download"></i></a></center></td>
                                            <td><span class="btn btn-success btn-xs add-order-to-report" onclick="get_form({{$report->id}});"><i class="fa fa-plus"></i> Sifariş əlavə et</span>
                                                <span onclick="get_orders(this, {{$report->id}});" class="btn btn-success btn-xs select-orders-modal"><i class="fa fa-list-alt"></i> Sifarişləri göstər</span>
                                            </td>
                                            {{--<td>--}}
                                                {{--<a href="reports/update/{{$report->id}}" class="btn btn-info btn-xs"><i--}}
                                                            {{--class="fa fa-pencil"></i></a>--}}
                                                {{--<span class="btn btn-danger btn-xs"--}}
                                                      {{--onclick="del(this, '{{$report->id}}', '{{$row}}');"><i--}}
                                                            {{--class="fa fa-trash-o"></i></span>--}}
                                            {{--</td>--}}
                                        </tr>

                                        <div id="popup{{$report->id}}" class="overlay">
                                            <div class="popup">
                                                <h2>{{$report->Subject}}</h2>
                                                <a class="close" href="#">&times;</a>
                                                <div class="content">
                                                    {!! $report->Text !!}
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $row++;
                                        @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                                </form>
                                <div>
                                    {!! $reports->links(); !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- start select orders modal-->
    <div class="modal fade" id="select-orders-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="table-responsive" style="max-height: 300px !important;">
                                        <table class="table table-striped jambo_table bulk_action">
                                            <thead>
                                            <tr class="headings">
                                                <th class="column-title">#</th>
                                                <th class="column-title">Sifariş</th>
                                                <th class="column-title">Miqdar</th>
                                            </tr>
                                            </thead>
                                            <tbody id="orders_table">

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
    <!-- /.end select-orders-modal-->

    <!-- start add modal form-->
    <div class="modal fade" id="add-order-to-report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post"
                          class="form-horizontal form-label-left" id="form">
                        {{csrf_field()}}
                        <input type="hidden" name="type" value="2">
                        <span id="form_report_id"></span>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                   for="order_id">Sifariş(ləri) seç *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control col-md-7 col-xs-12" name="order_id[]" id="order_id" multiple required>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Əlavə et</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.end add modal form-->
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script>
        function get_form(id) {
            $('#form_report_id').html('<input type="hidden" name="report_id" value="' + id + '">');

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'report_id': id,
                    '_token': CSRF_TOKEN,
                    'type': 4
                },
                success: function (response) {
                    swal(
                        response.title,
                        response.content,
                        response.case
                    );
                    if (response.case === 'success') {
                        swal.close();
                        var options = '';
                        var orders = response.orders;
                        var i = 0;
                        var count = 0;

                        for (i=0; i< orders.length; i++) {
                            count++;
                            var order = orders[i];
                            var option = '<option id="order_' + order['id'] + '" value="' + order['id'] + '">' + order['Product'] + ' - ' + order['Pcs'] + ' ' + order['Unit'] + '</option>';
                            options = options + option;
                        }

                        console.log(options);

                        $('#order_id').html(options);
                    }
                }
            });
        }
    </script>

    <script type="text/javascript">
        //add modal-orders
        $(document).on('click', '.select-orders-modal', function() {
            $('#select-orders-modal').modal('show');
        });
    </script>

    <script>
        function del(e, id, row_id) {
            swal({
                title: 'Are you sure you want to delete?',
                text: 'This process has no return...',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete!'
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
                            'type': 1
                        },
                        beforeSubmit: function () {
                            //loading
                            swal({
                                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                                text: 'Loading, please wait..',
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

        function get_orders(e, report_id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'report_id': report_id,
                    '_token': CSRF_TOKEN,
                    'type': 3
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
                        var orders = response.orders;
                        var i = 0;
                        var count = 0;

                        for (i=0; i< orders.length; i++) {
                            count++;
                            var order = orders[i];
                            var tr = '<tr class="even pointer">';
                            tr = tr + '<td>' + count + '</td><td>' + order['Product'] + '</td><td>' + order['Pcs'] + ' ' + order['Unit'] + '</td>';
                            tr = tr + '</tr>';
                            table = table + tr;
                        }

                        $('#orders_table').html(table);
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
                        if (response.type === 'add_order')  {
                            var orders = response.orders;
                            for (var i=0; i<orders.length; i++)  {
                                $('#order_'+orders[i]).remove();
                            }
                        }
                        else {
                            location.reload();
                        }
                    }
                }
            });
        });
    </script>

    <script type="text/javascript">
        //add order to report
        $(document).on('click', '.add-order-to-report', function() {
            $('#add-order-to-report').modal('show');
        });
    </script>
@endsection