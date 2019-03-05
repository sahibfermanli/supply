@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Purchases</h3>
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
                                        <th class="column-title">Təslim alan</th>
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
                                            //deadline
                                            $dead_line = $purchase->deadline;
                                            $difference = intval(abs(strtotime($current_date)-strtotime($dead_line))/86400);
                                            $color = 'white';

                                            foreach ($deadlines as $deadline) {
                                              if ($difference <= $deadline->deadline) {
                                                $color = $deadline->color;
                                                break;
                                              }
                                            }
                                        ?>
                                        <tr class="even pointer" id="row_{{$row}}">
                                            <td style="background-color: {{$color}}; color: white;">{{$purchase->order_id}}</td>
                                            <td>
                                                <select class="form-control input-sm" onchange="select_delivered_person(this);" order_id="{{$purchase->order_id}}">
                                                    <option value="">Boş</option>
                                                    @foreach($delivered_persons as $delivered_person)
                                                        <option value="{{$delivered_person->id}}">{{$delivered_person->name}} {{$delivered_person->surname}}</option>
                                                    @endforeach
                                                    <option value="{{$purchase->MainPerson}}">{{$purchase->name}} {{$purchase->surname}}</option>
                                                </select>
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

                                                <span title="Qaimə yüklə" onclick="upload_qaime({{$purchase->id}});" class="btn btn-success btn-xs add-qaime"><i class="fa fa-upload"></i></span>
                                            </td>
                                            <td title="{{$purchase->supply_date}}">{{substr($purchase->supply_name, 0, 1)}}. {{$purchase->supply_surname}}</td>
                                            <td title="{{$purchase->lawyer_date}}">{{substr($purchase->lawyer_name, 0, 1)}}. {{$purchase->lawyer_surname}}</td>
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

    {{--start add qaime modal--}}
    <div class="modal fade" id="add-qaime" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Qaiməni yüklə</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="add_qaime">
                        <div id="purchase_id_div"></div>
                        {{csrf_field()}}
                        <input type="file" name="file" class="form-control" style="width: 30%; display: inline-block;" required>
                        <input type="text" name="qaime_no" class="form-control" style="width: 30%; display: inline-block;" required placeholder="qaimənin nömrəsi">
                        <button type="submit" class="btn btn-success" style="display: inline-block;"><i class="fa fa-save"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--finish add qaime modal--}}

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

    {{--delivered form--}}
    <div class="modal fade" id="delivered-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Təhvil verilmənin təsdiqi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="type" value="order_delivered">
                        <div id="delivered_order_id"></div>
                        <div id="delivered_user_id"></div>
                        <label>Miqdar:</label>
                        <div id="delivered_count"></div>
                        <br>
                        <button type="submit" class="btn btn-success">Təsdiqlə</button>
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

    <script type="text/javascript">
        function select_delivered_person(elem) {
            var delivered_person_id = $(elem).val();

            if (delivered_person_id === 0 || delivered_person_id === '') {
                swal(
                    'Xəta',
                    'Təhvil alacaq şəxsi seçin',
                    'error'
                );
            }
            else {
                var order_id = $(elem).attr('order_id');

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
                        'type': 'get_order_for_delivery'
                    },
                    success: function (response) {
                        if (response.case === 'success') {
                            swal.close();

                            var order_count = response.order['count'];
                            var count_input = '<input style="max-width: 50%;" name="count" class="form-control" type="number" value="' + order_count + '">';
                            var order_id = '<input type="hidden" name="order_id" value="' + response.order['id'] + '">';
                            var user_id = '<input type="hidden" name="user_id" value="' + delivered_person_id +'">';

                            $('#delivered_count').html(count_input);
                            $('#delivered_order_id').html(order_id);
                            $('#delivered_user_id').html(user_id);

                            $("#delivered-modal").modal('show');
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
        }

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

        //upload qaime
        function upload_qaime(purchase_id) {
            $('#purchase_id_div').html('<input type="hidden" name="purchase_id" value="' + purchase_id + '">');

            $('#add-qaime').modal('show');
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
