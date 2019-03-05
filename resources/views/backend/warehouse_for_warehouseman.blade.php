@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Anbardakı sifarişlər</h3>
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
                                <table class="table table-bordered">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title">Anbardar</th>
                                        <th class="column-title" style="min-width: 100px;">Sifarişçi </th>
                                        <th class="column-title">Status </th>
                                        <th class="column-title" style="min-width: 100px;">Malın adı </th>
                                        <th class="column-title" style="min-width: 150px;">Marka </th>
                                        <th class="column-title" style="min-width: 100px;">Model </th>
                                        <th class="column-title">Miqdar </th>
                                        <th class="column-title">Ölçü vahidi </th>
                                        <th class="column-title">Qiymət </th>
                                        <th class="column-title">Ümumi qiymət </th>
                                        <th class="column-title">Yaradılma tarixi </th>
                                        <th class="column-title">Satıcı </th>
                                        <th class="column-title">Hesab </th>
                                        <th class="column-title">Qaime </th>
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
                                        <tr class="even pointer" id="row_{{$purchase->order_id}}">
                                            <td>{{$purchase->order_id}}</td>
                                            <td>
                                                <center><span class="btn btn-primary btn-xs" onclick="delivery_order({{$purchase->order_id}});"><i class="fa fa-check"></i></span></center>
                                            </td>
                                            <td title="{{$purchase->Department}}">{{substr($purchase->name, 0, 1)}}. {{$purchase->surname}}</td>
                                            <td title="{{$purchase->last_status['status_date']}}"><span onclick="show_status({{$purchase->order_id}}, '{{$purchase->Product}}');" style="background-color: {{$purchase->last_status['status_color']}}; border-color: {{$purchase->last_status['status_color']}};" class="btn btn-primary btn-xs">{{$purchase->last_status['status']}}</span></td>
                                            <td>{{$purchase->Product}}</td>
                                            <td>{{$purchase->Brend}}</td>
                                            <td>{{$purchase->Model}}</td>
                                            <td>{{$purchase->pcs}}</td>
                                            <td>{{$purchase->Unit}}</td>
                                            <td>{{$purchase->cost}}</td>
                                            <td>{{$purchase->total_cost}}</td>
                                            <td>{{$date}}</td>
                                            <td>{{$purchase->seller_name}}</td>
                                            <td>
                                                @if(isset($purchase->account_id))
                                                    <a title="{{$purchase->account_date}}" class="btn btn-success btn-xs" title="{{$purchase->account_date}}" target="_blank" href="/supply/accounts/print?a={{$purchase->account_id}}"><i class="fa fa-file-pdf-o"></i> {{$purchase->account_no}}</a>
                                                @else
                                                    <span title="Heç bir hesaba əlavə edilməyib" disabled="true" class="btn btn-success btn-xs" style="background-color: #b6a338; border-color: #b6a338;"><i class="fa fa-file-pdf-o"></i></span>
                                                @endif
                                            </td>
                                            <td style="min-width: 150px;">
                                                @if(isset($purchase->qaime_doc))
                                                    <a href="{{$purchase->qaime_doc}}" title="{{$purchase->qaime_date}}" class="btn btn-success btn-xs" style="background-color: #1b6d85; border-color: #1b6d85;"><i class="fa fa-download"></i> {{$purchase->qaime_no}}</a>
                                                @else
                                                    <span title="Qaiməni yoxdur" disabled="true" class="btn btn-success btn-xs" style="background-color: #b6a338; border-color: #b6a338;"><i class="fa fa-download"></i></span>
                                                @endif
                                            </td>
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
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script type="text/javascript">
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

        //delivery order
        function delivery_order(id) {
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
                    'id': id,
                    '_token': CSRF_TOKEN,
                    'type': 'delivery_order'
                },
                success: function (response) {
                    if (response.case === 'success') {
                        swal.close();
                        var elem = document.getElementById('row_' + response.row_id);
                        elem.parentNode.removeChild(elem);
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
    </script>
@endsection
