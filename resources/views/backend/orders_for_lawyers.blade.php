@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div>
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Sifarişlər</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div style="display: {{$message_display}} !important;">
                            <div id="message" class="message-mobile">
                                <h1>Zəhmət olmasa hesab (şirkət) seçin...</h1>
                                <p>Seçim sehifenin sol kenarında, menyudadır...</p>
                            </div>
                        </div>
                        <div class="accounts-mobile">
                            <ul class="nav child_menu show-accounts">
                                @foreach($accounts as $account)
                                    <li class="account-li" title="{{$account->account_no}}"><a
                                                style="color: black !important;" class="account-select"
                                                href="/law/pending/orders?account_id={{$account->id}}">{{$account->company}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="x_content">
                            <div class="table-responsive">
                                <div style="display: {{$table_display}};">
                                    <div style="display: inline-block; float: left;">
                                        <button title="Sifarişləri təsdiqlə" onclick="confirm_account();" type="button"
                                                style="background-color: #0e90d2; border-color: #0e90d2; display: inline-block;"
                                                class="btn btn-success">Sifarişləri təsdiqlə
                                        </button>
                                    </div>
                                    <a style="display: inline-block; float: right;" class="btn btn-success"
                                       title="{{$orders[0]->account_date}}" target="_blank"
                                       href="{{$orders[0]->account_doc}}">Hesab: <i
                                                class="fa fa-download"></i> {{$orders[0]->account_no}}</a>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr class="headings">
                                            <th class="column-title">#</th>
                                            <th class="column-title">Sil</th>
                                            <th class="column-title">Sifarişçi</th>
                                            <th class="column-title">Malın adı</th>
                                            <th class="column-title">Marka</th>
                                            <th class="column-title">Model</th>
                                            <th class="column-title">Miqdar</th>
                                            <th class="column-title">Ölçü vahidi</th>
                                            <th class="column-title">Qiymət</th>
                                            <th class="column-title">Ümumi qiymət</th>
                                            <th class="column-title">Şirkət</th>
                                            {{--<th class="column-title">Hesab </th>--}}
                                            <th class="column-title">Qaimə</th>
                                            <th class="column-title">Fayllar</th>
                                            <th class="column-title">Qəbul edilmə tarixi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $row = 1;
                                        @endphp
                                        @foreach($orders as $order)
                                            <?php
                                            $date = date('d.m.Y', strtotime($order->account_date));
                                            ?>
                                            <tr class="even pointer" id="row_{{$row}}">
                                                <td>{{$row}}</td>
                                                <td id="cancel_{{$row}}">
                                                    {{--<span title="Sifarişi geri çevir" class="btn btn-danger btn-xs" onclick="cancel_order(this, '{{$order->order_id}}', '{{$order->id}}', '{{$row}}');"><i class="fa fa-times"></i></span>--}}
                                                    <span title="Sifarişi geri çevir" class="btn btn-danger btn-xs"
                                                          onclick="cancel_order_modal('{{$order->order_id}}', '{{$order->id}}', '{{$row}}');"><i
                                                                class="fa fa-times"></i></span>
                                                </td>
                                                <td style="min-width: 200px;">{{$order->name}} {{$order->surname}}
                                                    , {{$order->Department}}</td>
                                                <td>{{$order->Product}}</td>
                                                <td>{{$order->Brend}}</td>
                                                <td>{{$order->Model}}</td>
                                                <td>{{$order->pcs}}</td>
                                                <td>{{$order->Unit}}</td>
                                                <td>{{$order->cost}}</td>
                                                <td>{{$order->total_cost}}</td>
                                                <td title="{{$order->phone}} , {{$order->address}}">{{$order->company}}</td>
                                                {{--<td title="{{$order->account_date}}">--}}
                                                {{--<a class="btn btn-success btn-xs" title="{{$order->account_date}}" target="_blank" href="{{$order->account_doc}}"><i class="fa fa-download"></i> {{$order->account_no}}</a>--}}
                                                {{--</td>--}}
                                                <td>
                                                    @if(!empty($order->qaime_doc))
                                                        <a class="btn btn-success btn-xs" title="{{$order->qaime_date}}"
                                                           target="_blank" href="{{$order->qaime_doc}}"><i
                                                                    class="fa fa-download"></i> {{$order->qaime_no}}</a>
                                                    @else
                                                        <span title="Qaimə yoxdur" disabled="true"
                                                              class="btn btn-warning btn-xs"><i
                                                                    class="fa fa-download"></i></span>
                                                    @endif
                                                </td>
                                                <td style="min-width: 78px;">
                                                    <center>
                                                        @if(!empty($order->image))
                                                            <span title="Şəkli göstər"
                                                                  onclick="get_data('{{$order->order_id}}', 'show_image');"
                                                                  class="btn btn-success btn-xs data-modal"><i
                                                                        class="fa fa-image"></i></span>
                                                        @else
                                                            <span title="Şəkil yoxdur" disabled="true"
                                                                  class="btn btn-success"><i
                                                                        class="fa fa-image"></i></span>
                                                        @endif

                                                        @if(!empty($order->deffect_doc))
                                                            <a style="background-color: #0e90d2;"
                                                               title="Qüsur aktını endir endir"
                                                               href="{{$order->deffect_doc}}"
                                                               class="btn btn-success btn-xs" target="_blank"><i
                                                                        class="fa fa-file"></i></a>
                                                        @else
                                                            <span style="background-color: #0e90d2;"
                                                                  title="Qüsur aktı yoxdur" disabled="true"
                                                                  class="btn btn-success btn-xs"><i
                                                                        class="fa fa-file"></i></span>
                                                        @endif
                                                    </center>
                                                </td>
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
                </div>
            </div>
        </div>
    </div>

    {{--start data (image) modal--}}
    <div class="modal fade" id="data-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="get-data">

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--finish data (image) modal--}}

    {{--start cancel order modal--}}
    <div class="modal fade" id="cancel-order-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sifarişi geri çevir</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" id="cancel_remark" cols="10" rows="3"
                              placeholder="Sifarişi geri çevirmə səbəbinizi daxil edin (max: 1000 simvol)"></textarea>
                    <br>
                    <center id="cancel_btn"></center>
                </div>
            </div>
        </div>
    </div>
    {{--finish cancel order modal--}}
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.show-accounts').css('display', 'block');
        });

        //get data (show image)
        function get_data(id, type) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'id': id, //order_id
                    '_token': CSRF_TOKEN,
                    'type': type
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
                    swal.close();

                    $('.get-data').html(response.data);

                    $('#data-modal').modal('show');
                }
            });
        }

        //confirm account
        function confirm_account() {
            swal({
                title: 'Hesabı işərisindəki sifarişlərlə birlikdə təsdiqləmək istədiyinizə əminsiniz?',
                text: 'Bu əməliyyatın geri dönüşü yoxdur...',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Geri',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Təsdiqlə!'
            }).then(function (result) {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "Post",
                        url: '',
                        data: {
                            '_token': CSRF_TOKEN,
                            'type': 'confirm_account'
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
                            if (response.case === 'success') {
                                location.href = '/law/pending/orders';
                            } else {
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

        //cancel order modal
        function cancel_order_modal(order_id, purchase_id, row_id) {
            var cancel_btn = '<span onclick="cancel_order(' + order_id + ',' + purchase_id + ',' + row_id + ');" class="btn btn-success"><i class="fa fa-check"></i></span>';

            $('#cancel_btn').html(cancel_btn);

            $('#cancel-order-modal').modal('show');
        }

        //cancel order
        function cancel_order(order_id, purchase_id, row_id) {
            swal({
                title: 'Sifarişi geri çevirmək istədiyinizdən əminsiniz?',
                text: 'Bu əməliyyatın geri dönüşü yoxdur...',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Geri',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Bəli!'
            }).then(function (result) {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    var cancel_remark = $('#cancel_remark').val();

                    if (cancel_remark.length === 0) {
                        swal(
                            'Xəta',
                            'Qeyd boş ola bilməz',
                            'error'
                        );

                        return false;
                    }

                    $.ajax({
                        type: "Post",
                        url: '',
                        data: {
                            'order_id': order_id,
                            'purchase_id': purchase_id,
                            'remark': cancel_remark,
                            '_token': CSRF_TOKEN,
                            'row_id': row_id,
                            'type': 'cancel_order'
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
                                $('#cancel_' + response.row_id).html('<span disabled="true" title="Düymə deaktivdir" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></span>');
                            }
                        }
                    });
                } else {
                    return false;
                }
            });
        }
    </script>
@endsection
