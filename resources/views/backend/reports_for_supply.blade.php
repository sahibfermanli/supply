@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Reports</h3>
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
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title">Report No</th>
                                        <th class="column-title">Report date</th>
                                        <th class="column-title">Document</th>
                                        <th class="column-title">Department</th>
                                        <th class="column-title">Subject</th>
                                        <th class="column-title">Creation date</th>
                                        <th class="column-title">#Detail</th>
                                        <th class="column-title">#Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @php
                                        $row = 1;
                                    @endphp
                                    @foreach($reports as $report)
                                        <?php $date = date('d M Y', strtotime($report->created_at)); ?>
                                        <?php $report_date = date('d M Y', strtotime($report->ReportDate)); ?>
                                        <tr class="even pointer" id="row_{{$row}}">
                                            <td>{{$row}}</td>
                                            <td>{{$report->ReportNo}}</td>
                                            <td>{{$report_date}}</td>
                                            <td><a href="{{$report->ReportDocument}}" class="btn btn-success btn-xs">Download</a></td>
                                            <td>{{$report->Department}}</td>
                                            <td><a href="#popup{{$report->id}}"
                                                   class="btn btn-default btn-xs">{{$report->Subject}}</a></td>
                                            <td>{{$date}}</td>
                                            <td>
                                                <span onclick="get_orders(this, {{$report->id}});" class="btn btn-success btn-xs add-modal"><i class="fa fa-list-alt"></i> Show orders</span>
                                            </td>
                                            <td>
                                                <span class="btn btn-danger btn-xs" onclick="del(this, '{{$report->id}}', '{{$row}}');"><i class="fa fa-trash-o"></i> Delete </span>
                                            </td>
                                        </tr>

                                        <div id="popup{{$report->id}}" class="overlay">
                                            <div class="popup">
                                                <h2>{{$report->Subject}}</h2>
                                                <a class="close" href="#">&times;</a>
                                                <div class="content">
                                                    {!! $report->Remark !!}
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $row++;
                                        @endphp
                                    @endforeach
                                    </tbody>
                                </table>
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

    <!-- start add modal 1-->
    <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <th class="column-title">Product</th>
                                                <th class="column-title">Brend</th>
                                                <th class="column-title">Model</th>
                                                <th class="column-title">Part</th>
                                                <th class="column-title">Web link</th>
                                                <th class="column-title">Category</th>
                                                <th class="column-title">QTY</th>
                                                <th class="column-title">#Action</th>
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
    <!-- /.end add modal 1-->

    <div class="modal fade" id="add-modal-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form" data-parsley-validate class="form-horizontal form-label-left" method="post" action="">
                        {{csrf_field()}}
                        <div id="order_id"></div>
                        <div id="purchase-id"></div>
                        <div id="selected"><input type="hidden" name="selected" value="1"></div>
                        <input type="hidden" name="type" value="2">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Brend">Brend *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control col-md-7 col-xs-12" name="Brend" id="Brend" maxlength="255" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Model">Model *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control col-md-7 col-xs-12" name="Model" id="Model" maxlength="255" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Type">Type *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control col-md-7 col-xs-12" name="Type" id="Type" maxlength="255" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="PartSerialNo">Part or Serial NO*</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control col-md-7 col-xs-12" name="PartSerialNo" id="PartSerialNo" maxlength="255" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cost">Cost *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control col-md-7 col-xs-12" name="cost" id="cost" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Date *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="date" class="form-control col-md-7 col-xs-12" name="date" id="date" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pcs">Count *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control col-md-7 col-xs-12" name="pcs" id="pcs" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pcs_unit_id">Unit *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control col-md-7 col-xs-12" name="pcs_unit_id" id="pcs_unit_id" required>
                                    <option value="">Select</option>
                                    @foreach($units as $unit)
                                        <option value="{{$unit->id}}">{{$unit->Unit}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="country">Country *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control col-md-7 col-xs-12" name="country" id="country" maxlength="255" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Remark">Remark *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea class="form-control col-md-7 col-xs-12" name="Remark" id="Remark" required></textarea>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="reset" class="btn btn-primary">Clear</button>
                                <button type="submit" class="btn btn-success" id="form-submit"><span>Add</span></button>
                            </div>
                        </div>
                    </form>
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

    {{--alert--}}
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
                            var btn = '<span onclick="add_order_id(' + order['id'] + ')" class="btn btn-success btn-xs add-modal-2" >Purchase</span>';
                            var tr = '<tr class="even pointer" id="tr_order_' + order['id'] + '">';
                            tr = tr + '<td>' + count + '</td><td>' + order['Product'] + '</td><td>' + order['Brend'] + '</td><td>' + order['Model'] + '</td><td>' + order['Part'] + '</td><td>' + order['Web_link'] + '</td><td>' + order['Category'] + '</td><td>' + order['Pcs'] + ' ' + order['Pcs_unit'] + '</td><td>' + btn + '</td>';
                            tr = tr + '</tr>';
                            tr = tr + '<tr id="new_form_' + order['id'] + '"></tr>';
                            table = table + tr;
                        }

                        $('#orders_table').html(table);
                    }
                }
            });
        }

        function add_order_id(id) {
            $('#order_id').html("<input type='hidden' name='OrderID' value='" + id + "'>");
        }

        $(document).ready(function () {
            $('form').validate();
            $('form').ajaxForm({
                beforeSubmit:function () {
                    //loading
                    swal ({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                        text: 'Loading, please wait...',
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
                        //add alternative
                        if (response.type === 'add_purchase') {
                            $('#tr_order_'+response.order_id).remove();
                            $('#selected').html("<input type='hidden' name='selected' value='0'>");
                            $('#purchase-id').html("<input type='hidden' name='purchase_id' value='" + response.purchase_id + "'>");
                            $('#form-submit').html('<span>Add alternative</span>');
                        }
                    }
                }
            });
        });
    </script>

    <script type="text/javascript">
        //add modal - 1
        $(document).on('click', '.add-modal', function() {
            // $('.modal-title').text('Titlein burada');
            $('#add-modal').modal('show');
        });

    </script>

    <script type="text/javascript">
        //add modal - 2
        $(document).on('click', '.add-modal-2', function() {
            $('#add-modal-2').modal('show');
        });

    </script>
@endsection