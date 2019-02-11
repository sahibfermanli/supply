@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h5>Düymələrin mənaları</h5>
                    <ul>
                        <li>
                            <span disabled="true" title="Çap et"
                                  class="btn btn-primary btn-xs"><i
                                        class="fa fa-print"></i>
                            </span>
                            <span>Hesabı çap et</span>
                        </li>
                        <li>
                            <span disabled="true" title="Alımları göstər"
                                  class="btn btn-success btn-xs"><i
                                        class="fa fa-eye"></i>
                            </span>
                            <span>Sifarişləri göstər, yeni sifariş əlavə et, mövcud sifarişi çıxar</span>
                        </li>
                        <li>
                            <span disabled="true" style="background-color: #0b97c4;"
                                  title="Hüquqa göndər"
                                  class="btn btn-success btn-xs"><i
                                        class="fa fa-share-square"></i></span>
                            <span>Hüquqa göndər</span>
                        </li>
                        <li>
                            <span disabled="true" title="Düzəliş et"
                                  class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></span>
                            <span>Edilən dəyişiklikləri təsdiqlə</span>
                        </li>
                        <li>
                            <span disabled="true" title="Sil"
                                  class="btn btn-danger btn-xs"><i
                                        class="fa fa-trash-o"></i></span>
                            <span>Hesabı sil</span>
                        </li>
                    </ul>
                    <h3 style="display: inline-block;"> Hesablar</h3>
                    <span style="float: right;" class="btn btn-success btn-add-new-account"
                          onclick="show_account_add_form();"><i class="fa fa-plus"></i></span>
                    <span type="button" onclick="remove_account_add_form();"
                          class="btn btn-success btn-remove-new-account" style="float: right; display: none;"><i
                                class="fa fa-minus"></i></span>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="table-responsive">
                                <div>
                                    {!! $accounts->links(); !!}
                                </div>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="type" value="add">
                                    {{csrf_field()}}
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr class="jsgrid-filter-row" style="display: none;" id="account-add-form">
                                            <td id="add-btn-td">
                                                <center>
                                                    <button type="submit" id="add-btn" class="btn btn-success btn-xs"><i
                                                                class="fa fa-save"></i></button>
                                                </center>
                                            </td>
                                            <td id="orders-add-inputs"><input type="text" class="form-control input-sm"
                                                                              name="account_no"
                                                                              placeholder="Hesab No *"></td>
                                            <td id="orders-add-inputs" colspan="2">
                                                <select class="form-control input-sm" name="company_id">
                                                    @foreach($companies as $company)
                                                        <option value="{{$company->id}}">{{$company->seller_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="headings">
                                            <th class="column-title">#</th>
                                            <th class="column-title">Hesab No</th>
                                            <th class="column-title">Satıcı</th>
                                            <th class="column-title">Yaradan istifadəçi</th>
                                            <th class="column-title">Yaradılma tarixi</th>
                                            <th class="column-title">Qeydlər</th>
                                            <th class="column-title">#Əməliyyatlar</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @php
                                            $row = 1;
                                        @endphp
                                        @foreach($accounts as $account)
                                            <?php
                                                $account_date = date('d.m.Y', strtotime($account->created_at));
                                                if($account->send == 1) {
                                                    $disabled = 'disabled';
                                                }
                                                else {
                                                    $disabled = '';
                                                }
                                            ?>
                                            <tr class="even pointer" id="row_{{$row}}">
                                                <td>{{$account->id}}</td>
                                                <td><input style="border: none;" type="text" {{$disabled}}
                                                           class="form-control input-sm"
                                                           id="account_no_edit_{{$account->id}}"
                                                           value="{{$account->account_no}}"></td>
                                                <td>
                                                    <select style="border: none;" class="form-control input-sm" {{$disabled}}
                                                            id="company_edit_{{$account->id}}">
                                                        @foreach($companies as $company)
                                                            @if($company->id == $account->company_id)
                                                                <option selected
                                                                        value="{{$company->id}}">{{$company->seller_name}}</option>
                                                            @else
                                                                <option value="{{$company->id}}">{{$company->seller_name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>{{$account->edited_name}} {{$account->edited_surname}}</td>
                                                <td>{{$account_date}}</td>
                                                <td id="lawyer_remark_{{$account->id}}">
                                                    @if(!empty($account->lawyer_remark))
                                                        <span class="btn btn-success btn-xs" onclick="show_remark({{$account->id}});">Qeydi göstər</span>
                                                        <span class="btn btn-danger btn-xs" onclick="clear_remark({{$account->id}});">Qeydi sıfırla</span>
                                                    @else
                                                        <span title="Qeyd yoxdur" disabled="true" class="btn btn-warning btn-xs">Qeydi göstər</span>
                                                        <span title="Qeyd yoxdur" disabled="true" class="btn btn-warning btn-xs">Qeydi sıfırla</span>
                                                    @endif
                                                </td>
                                                @if($account->send == 0)
                                                    <td id="btns_{{$account->id}}">
                                                        <a href="/supply/accounts/print?a={{$account->id}}" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-print"></i></a>
                                                        <span title="Alımları göstər"
                                                              class="btn btn-success btn-xs show-purchases-modal"
                                                              onclick="show_purchases(this, '{{$account->id}}', '{{$account->company_id}}');"><i
                                                                    class="fa fa-eye"></i></span>
                                                        @if(Auth::user()->chief() == 1)
                                                            <span style="background-color: #0b97c4;"
                                                                  title="Hüquqa göndər" class="btn btn-success btn-xs"
                                                                  onclick="send_lawyer(this, '{{$account->id}}');"><i
                                                                        class="fa fa-share-square"></i></span>
                                                        @endif
                                                        <span title="Düzəliş et" class="btn btn-warning btn-xs"
                                                              onclick="update(this, '{{$account->id}}');"><i
                                                                    class="fa fa-edit"></i></span>
                                                        <span title="Sil" class="btn btn-danger btn-xs"
                                                              onclick="del(this, '{{$account->id}}', '{{$row}}');"><i
                                                                    class="fa fa-trash-o"></i></span>
                                                    </td>
                                                @else
                                                    <td>
                                                        <a href="/supply/accounts/print?a={{$account->id}}" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-print"></i></a>
                                                        <span title="Sifarişləri gör" onclick="show_purchases(this, '{{$account->id}}', 0, 1);"
                                                              class="btn btn-success btn-xs show-purchases-modal"><i
                                                                    class="fa fa-eye"></i></span>
                                                        @if(Auth::user()->chief() == 1)
                                                            <span disabled="true" style="background-color: #0b97c4;"
                                                                  title="Düymə deaktivdir"
                                                                  class="btn btn-success btn-xs"><i
                                                                        class="fa fa-share-square"></i></span>
                                                        @endif
                                                        <span disabled="true" title="Düymə deaktivdir"
                                                              class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></span>
                                                        <span disabled="true" title="Düymə deaktivdir"
                                                              class="btn btn-danger btn-xs"><i
                                                                    class="fa fa-trash-o"></i></span>
                                                    </td>
                                                @endif
                                            </tr>
                                            @php
                                                $row++;
                                            @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </form>
                                <div>
                                    {!! $accounts->links(); !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- start select purchases modal-->
    <div class="modal fade" id="show-purchases-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6" id="free_purchases_table_div">
                            <h5 style="margin-bottom: 22px;">Gözləmədə olan sifarişlər</h5>
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="table-responsive" style="max-height: 300px !important;">
                                        <div id="account_id_div"></div>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr class="headings">
                                                <th class="column-title">#</th>
                                                <th class="column-title">Əlavə et</th>
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
                                                    <td>{{$purchase->id}}</td>
                                                    <td>
                                                        <span id="add_purchase_to_account_span_{{$purchase->company_id}}" onclick="add_purchase_to_selected_account('{{$purchase->id}}', '{{$purchase->company_id}}');"
                                                              class="add_purchase_to_account_span btn btn-success btn-xs"><i class="fa fa-plus"></i></span>
                                                    </td>
                                                    <td>{{$purchase->Product}}</td>
                                                    <td>{{$purchase->Brend}}</td>
                                                    <td>{{$purchase->Model}}</td>
                                                    <td>{{$purchase->pcs}}</td>
                                                    <td>{{$purchase->Unit}}</td>
                                                    <td>{{$purchase->cost}}</td>
                                                    <td>{{$purchase->total_cost}}</td>
                                                    <td>{{$purchase->company}}</td>
                                                    <td><span style="color: {{$purchase->color}}">{{$purchase->status}}</span></td>
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
                            <h5>Cari hesaba aid sifarişlər <span id="print-page-link"></span></h5>
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="table-responsive" style="max-height: 300px !important;">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr class="headings">
                                                <th class="column-title">#</th>
                                                <th class="column-title">Sil</th>
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

    {{--update document modal start--}}
    <div class="modal fade" id="update-doc-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Faylı dəyişdir</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body-data">
                        <form action="" id="form" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="type" value="update_doc">
                            {{csrf_field()}}
                            <div id="document-form-modal"></div>
                            <input type="file" class="form-control input-sm" name="file"
                                   style="width: 400px; margin-bottom: 10px;">
                            <button type="submit" class="btn btn-success">Faylı dəyişdir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--update document modal finish--}}

    {{--show remark modal start--}}
    <div class="modal fade" id="show-remark-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <span id="show-remark"></span>
                </div>
            </div>
        </div>
    </div>
    {{--show remark modal finish--}}
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script>
        function show_remark(account_id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'id': account_id,
                    '_token': CSRF_TOKEN,
                    'type': 'show_remark'
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
                        swal.close();

                        $('#show-remark').html(response.data);

                        $('#show-remark-modal').modal('show');
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

        function clear_remark(account_id) {
            swal({
                title: 'Qeydi sıfırlamaq istədiyinizdən əminsiniz?',
                text: 'Bu əməliyyatın geri dönüşü yoxdur...',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Geri',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sıfırla!'
            }).then(function (result) {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "Post",
                        url: '',
                        data: {
                            'id': account_id,
                            '_token': CSRF_TOKEN,
                            'type': 'clear_remark'
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
                                var show = '<span title="Qeyd yoxdur" disabled="true" class="btn btn-warning btn-xs">Qeydi göstər</span>';
                                var clear = '<span title="Qeyd yoxdur" disabled="true" class="btn btn-warning btn-xs">Qeydi sıfırla</span>';

                                var spans = show + clear;

                                $('#lawyer_remark_'+account_id).html(spans);
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

        function update(e, id) {
            swal({
                title: 'Dəyişiklik etmək istədiyinizdən əminsiniz?',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Geri',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Dəyişdir!'
            }).then(function (result) {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    var account_no = $('#account_no_edit_' + id).val();
                    var company_id = $('#company_edit_' + id).val();

                    $.ajax({
                        type: "Post",
                        url: '',
                        data: {
                            'id': id,
                            'account_no': account_no,
                            'company_id': company_id,
                            '_token': CSRF_TOKEN,
                            'type': 'update'
                        },
                        beforeSubmit: function () {
                            //loading
                            swal({
                                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Zəhmət olmasa gözləyin...</span>',
                                text: 'Loading, please wait..',
                                showConfirmButton: false
                            });
                        },
                        success: function (response) {
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
                } else {
                    return false;
                }
            });
        }

        //show new account form
        function show_account_add_form() {
            $('#account-add-form').css('display', 'table-row');
            $('.btn-add-new-account').css('display', 'none');
            $('.btn-remove-new-account').css('display', 'block');
        }

        //remove new account form
        function remove_account_add_form() {
            $('#account-add-form').css('display', 'none');
            $('.btn-add-new-account').css('display', 'block');
            $('.btn-remove-new-account').css('display', 'none');
        }

        //show selected purchases when clicked account
        function show_purchases(e, account_id, company_id, disabled=0) {
            if (disabled === 0) {
                $('#account_id_div').html('<input type="hidden" id="account_id" value="' + account_id + '">');
            }

            $('#print-page-link').html('<a href="/supply/accounts/print?a=' + account_id + '" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-print"></i></a>');

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'account_id': account_id,
                    '_token': CSRF_TOKEN,
                    'type': 'show_purchases'
                },
                success: function (response) {
                    swal(
                        response.title,
                        response.content,
                        response.case
                    );
                    if (response.case === 'success') {
                        swal.close();

                        $('.add_purchase_to_account_span').removeClass('btn-warning').addClass('btn-success').attr( "disabled", false).attr('title', 'Hesaba əlavə et');
                        $('.add_purchase_to_account_span').not('#add_purchase_to_account_span_'+company_id).removeClass('btn-success').addClass('btn-warning').attr( "disabled", true).attr('title', 'Şirkətlər uyğun deyil');

                        var table = '';
                        var purchases = response.selected_purchases;
                        var i = 0;
                        var count = 0;
                        var remove = '';

                        for (i = 0; i < purchases.length; i++) {
                            count++;
                            var purchase = purchases[i];

                            if(disabled === 0) {
                                remove = '<td><span onclick="remove_purchase_from_selected_account(' + purchase['id'] + ');" class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></span></td>';
                            }
                            else {
                                remove = '<td><span disabled="true" title="Düymə deaktivdir" class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></span></td>';
                            }

                            var product = '<td>' + purchase['Product'] + '</td>';
                            var brend = '<td>' + purchase['Brend'] + '</td>';
                            var model = '<td>' + purchase['Model'] + '</td>';
                            var pcs = '<td>' + purchase['pcs'] + '</td>';
                            var unit = '<td>' + purchase['Unit'] + '</td>';
                            var cost = '<td>' + purchase['cost'] + '</td>';
                            var total_cost = '<td>' + purchase['total_cost'] + '</td>';
                            var company = '<td>' + purchase['company'] + '</td>';
                            var status = '<td><span style="color: ' + purchase['color'] + '">' + purchase['status'] + '</span></td>';
                            var date = '<td>' + purchase['created_at'].substr(0, 10) + '</td>';

                            var tr = '<tr class="even pointer" id="remove_' + purchase['id'] + '">';
                            tr = tr + '<td>' + purchase['id'] + '</td>' + remove + product + brend + model + pcs + unit + cost + total_cost + company + status + date;
                            tr = tr + '</tr>';
                            table = table + tr;
                        }

                        if (disabled === 1) {
                            $('#free_purchases_table_div').css('display', 'none');
                            $('#selected_purchases_table_div').removeClass('col-md-6 col-sm-6 col-xs-6');
                            $('#selected_purchases_table_div').addClass('col-md-12 col-sm-12 col-xs-12');
                        }
                        else {
                            $('#free_purchases_table_div').css('display', 'block');
                            $('#selected_purchases_table_div').addClass('col-md-6 col-sm-6 col-xs-6');
                            $('#selected_purchases_table_div').removeClass('col-md-12 col-sm-12 col-xs-12');
                        }

                        $('#selected_purchases_table').html(table);

                        $('#show-purchases-modal').modal('show');
                    }
                }
            });
        }

        @if(Auth::user()->chief() == 1)
            function send_lawyer(e, account_id) {
            swal({
                title: 'Hesabı içərisindəki sifarişlərlə birlikdə hüquq şöbəsinə göndərmək istədiyinizə əminsiniz?',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Geri',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Göndər!'
            }).then(function (result) {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "Post",
                        url: '',
                        data: {
                            'account_id': account_id,
                            '_token': CSRF_TOKEN,
                            'type': 'send_lawyer'
                        },
                        success: function (response) {
                            swal(
                                response.title,
                                response.content,
                                response.case
                            );
                            if (response.case === 'success') {
                                swal.close();

                                var show = '<span onclick="show_purchases(this, ' + account_id + ', 0, 1)" title="Sifarişləri gör" class="btn btn-success btn-xs  show-purchases-modal"><i class="fa fa-eye"></i></span>';
                                var send = '<span disabled="true" style="background-color: #0b97c4;" title="Düymə deaktivdir" class="btn btn-success btn-xs"><i class="fa fa-share-square"></i></span>';
                                var edit = '<span disabled="true" title="Düymə deaktivdir" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></span>';
                                var del = '<span disabled="true" title="Düymə deaktivdir" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></span>';

                                var btns = show + send + edit + del;

                                $('#account_no_edit_'+account_id).prop('disabled', true);
                                $('#company_edit_'+account_id).prop('disabled', true);

                                $('#update_document_span_'+account_id).html('<span title="Düymə deaktivdir" disabled="ture" class="btn btn-warning btn-xs"><i class="fa fa-upload"></i></span>');

                                $('#btns_' + account_id).html(btns);
                            }
                        }
                    });
                } else {
                    return false;
                }
            });
        }
        @endif

        function add_purchase_to_selected_account(purchase_id, company_id) {
            var account_id = $('#account_id').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'account_id': account_id,
                    'purchase_id': purchase_id,
                    'company_id': company_id,
                    '_token': CSRF_TOKEN,
                    'type': 'add_purchase_to_selected_account'
                },
                success: function (response) {
                    if (response.case === 'success') {
                        swal.close();
                        var table = '';
                        var purchase = response.purchase;

                        var remove = '<td><span onclick="remove_purchase_from_selected_account(' + purchase['id'] + ');" class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></span></td>';
                        var product = '<td>' + purchase['Product'] + '</td>';
                        var brend = '<td>' + purchase['Brend'] + '</td>';
                        var model = '<td>' + purchase['Model'] + '</td>';
                        var pcs = '<td>' + purchase['pcs'] + '</td>';
                        var unit = '<td>' + purchase['Unit'] + '</td>';
                        var cost = '<td>' + purchase['cost'] + '</td>';
                        var total_cost = '<td>' + purchase['total_cost'] + '</td>';
                        var company = '<td>' + purchase['company'] + '</td>';
                        var status = '<td><span style="color: ' + purchase['color'] + '">' + purchase['status'] + '</span></td>';
                        var date = '<td>' + purchase['created_at'].substr(0, 10) + '</td>';

                        var tr = '<tr class="even pointer" id="remove_' + purchase['id'] + '">';
                        tr = tr + '<td>' + '<span style="color: green;">new</span>' + '</td>' + remove + product + brend + model + pcs + unit + cost + total_cost + company + status + date;
                        tr = tr + '</tr>';
                        table = table + tr;

                        $('#move_' + purchase['id']).remove();
                        $('#selected_purchases_table').append(table);
                    }
                    else if (response.type === 'company_false') {
                        swal.close();
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

        function remove_purchase_from_selected_account(purchase_id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'purchase_id': purchase_id,
                    '_token': CSRF_TOKEN,
                    'type': 'remove_purchase_from_selected_account'
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

                        var move_btn = '<td><span id="add_purchase_to_account_span_' + purchase['company_id'] + '" onclick="add_purchase_to_selected_account(' + purchase['id'] + ',' + purchase['company_id'] + ');" class="add_purchase_to_account_span btn btn-success btn-xs"><i class="fa fa-plus"></i></span></td>';
                        var product = '<td>' + purchase['Product'] + '</td>';
                        var brend = '<td>' + purchase['Brend'] + '</td>';
                        var model = '<td>' + purchase['Model'] + '</td>';
                        var pcs = '<td>' + purchase['pcs'] + '</td>';
                        var unit = '<td>' + purchase['Unit'] + '</td>';
                        var cost = '<td>' + purchase['cost'] + '</td>';
                        var total_cost = '<td>' + purchase['total_cost'] + '</td>';
                        var company = '<td>' + purchase['company'] + '</td>';
                        var status = '<td><span style="color: ' + purchase['color'] + '">' + purchase['status'] + '</span></td>';
                        var date = '<td>' + purchase['created_at'].substr(0, 10) + '</td>';

                        var tr = '<tr class="even pointer" id="move_' + purchase['id'] + '">';
                        tr = tr + '<td>' + '<span style="color: green;">new</span>' + '</td>' + move_btn + product + brend + model + pcs + unit + cost + total_cost + company + status + date;
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
                        if (response.type === 'add_account') {
                            location.reload();
                        }
                    }
                }
            });
        });
    </script>
@endsection