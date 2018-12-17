@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> hesablar</h3>
                    <span style="float: right;" class="btn btn-success btn-add-new-account" onclick="show_account_add_form();"><i class="fa fa-plus"></i></span>
                    <span type="button" onclick="remove_account_add_form();" class="btn btn-success btn-remove-new-account" style="float: right; display: none;"><i class="fa fa-minus"></i></span>
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
                                        <td id="add-btn-td"><center><button type="submit" id="add-btn" class="btn btn-success btn-xs"><i class="fa fa-save"></i></button></center></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="account_no" placeholder="Hesab No *"></td>
                                        <td id="orders-add-inputs" >
                                            <select class="form-control input-sm" name="company_id">
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}">{{$company->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td colspan="3" id="orders-add-inputs"><input type="file" class="form-control input-sm" name="file"></td>
                                    </tr>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title">Hesab No</th>
                                        <th class="column-title">Şirkət</th>
                                        <th class="column-title">Yaradılma tarixi</th>
                                        <th class="column-title">Fayl</th>
                                        <th class="column-title">#Əməliyyatlar</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @php
                                        $row = 1;
                                    @endphp
                                    @foreach($accounts as $account)
                                        <?php $account_date = date('d.m.Y', strtotime($account->created_at)); ?>
                                        <tr class="even pointer" id="row_{{$row}}">
                                            <td>{{$row}}</td>
                                            <td><input style="border: none;" type="text" class="form-control input-sm" id="account_no_edit_{{$account->id}}" value="{{$account->account_no}}"></td>
                                            <td>
                                                <select style="border: none;" class="form-control input-sm" id="company_edit_{{$account->id}}">
                                                    @foreach($companies as $company)
                                                        @if($company->id == $account->company_id)
                                                            <option selected value="{{$company->id}}">{{$company->name}}</option>
                                                        @else
                                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>{{$account_date}}</td>
                                            <td>
                                                <center>
                                                    <a title="Faylı endir" href="{{$account->account_doc}}" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-download"></i></a>
                                                    <span title="Faylı dəyişdir" onclick="get_update_document(this, '{{$account->id}}', '{{$account->account_no}}');" class="btn btn-warning btn-xs update-doc-modal"><i class="fa fa-upload" ></i></span>
                                                </center>
                                            </td>
                                            <td>
                                                <span title="Alımları göstər" class="btn btn-success btn-xs show-purchases-modal" onclick="show_purchases(this, '{{$account->id}}');"><i class="fa fa-eye"></i></span>
                                                <span title="Düzəliş et" class="btn btn-warning btn-xs" onclick="update(this, '{{$account->id}}');"><i class="fa fa-edit"></i></span>
                                                <span title="Sil" class="btn btn-danger btn-xs" onclick="del(this, '{{$account->id}}', '{{$row}}');"><i class="fa fa-trash-o"></i></span>
                                            </td>
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
    <div class="modal fade" id="show-purchases-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h5>Gözləmədə olan sifarişlər</h5>
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="table-responsive" style="max-height: 300px !important;">
                                        <div id="account_id_div"></div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="headings">
                                                    <th class="column-title">#</th>
                                                    <th class="column-title">Əlavə et</th>
                                                    <th class="column-title">Malın adı </th>
                                                    <th class="column-title">Marka </th>
                                                    <th class="column-title">Model </th>
                                                    <th class="column-title">Miqdar </th>
                                                    <th class="column-title">Ölçü vahidi </th>
                                                    <th class="column-title">Qiymət </th>
                                                    <th class="column-title">Ümumi qiymət </th>
                                                    <th class="column-title">Yaradılma tarixi </th>
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
                                                    <td>{{$row}}</td>
                                                    <td><span onclick="add_purchase_to_selected_account({{$purchase->id}});" class="btn btn-success btn-xs"><i class="fa fa-plus"></i></span></td>
                                                    <td>{{$purchase->Product}}</td>
                                                    <td>{{$purchase->Brend}}</td>
                                                    <td>{{$purchase->Model}}</td>
                                                    <td>{{$purchase->pcs}}</td>
                                                    <td>{{$purchase->Unit}}</td>
                                                    <td>{{$purchase->cost}}</td>
                                                    <td>{{$purchase->total_cost}}</td>
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

                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h5>Cari hesaba aid sifarişlər</h5>
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="table-responsive" style="max-height: 300px !important;">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr class="headings">
                                                <th class="column-title">#</th>
                                                <th class="column-title">Sil</th>
                                                <th class="column-title">Malın adı </th>
                                                <th class="column-title">Marka </th>
                                                <th class="column-title">Model </th>
                                                <th class="column-title">Miqdar </th>
                                                <th class="column-title">Ölçü vahidi </th>
                                                <th class="column-title">Qiymət </th>
                                                <th class="column-title">Ümumi qiymət </th>
                                                <th class="column-title">Yaradılma tarixi </th>
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
                            <input type="file" class="form-control input-sm" name="file" style="width: 400px; margin-bottom: 10px;">
                            <button type="submit" class="btn btn-success">Faylı dəyişdir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--update document modal finish--}}
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script type="text/javascript">
        //update-doc-modal
        $(document).on('click', '.update-doc-modal', function() {
            $('#update-doc-modal').modal('show');
        });
    </script>

    <script type="text/javascript">
        //show purchases modal
        $(document).on('click', '.show-purchases-modal', function() {
            $('#show-purchases-modal').modal('show');
        });
    </script>


    <script>
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
                                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Zəhmət olmasa gözləyin...</span>',
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

                    var account_no = $('#account_no_edit_'+id).val();
                    var company_id = $('#company_edit_'+id).val();

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
                            swal(
                                response.title,
                                response.content,
                                response.case
                            );
                        }
                    });
                } else {
                    return false;
                }
            });
        }

        function get_update_document(e, id ,no) {
            var id_input = '<input type="hidden" name="id" value="' + id + '">';
            var no_input = '<input type="hidden" name="account_no" value="' + no + '">';
            var inputs = id_input + no_input;

            $('#document-form-modal').html(inputs);
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
        function show_purchases(e, account_id) {
            $('#account_id_div').html('<input type="hidden" id="account_id" value="' + account_id + '">');

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
                        var table = '';
                        var purchases = response.selected_purchases;
                        var i = 0;
                        var count = 0;

                        for (i=0; i< purchases.length; i++) {
                            count++;
                            var purchase = purchases[i];

                            var remove = '<td><span onclick="remove_purchase_from_selected_account(' + purchase['id'] + ');" class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></span></td>';
                            var product = '<td>' + purchase['Product'] + '</td>';
                            var brend = '<td>' + purchase['Brend'] + '</td>';
                            var model = '<td>' + purchase['Model'] + '</td>';
                            var pcs = '<td>' + purchase['pcs'] + '</td>';
                            var unit = '<td>' + purchase['Unit'] + '</td>';
                            var cost = '<td>' + purchase['cost'] + '</td>';
                            var total_cost = '<td>' + purchase['total_cost'] + '</td>';
                            var date = '<td>' + purchase['created_at'].substr(0, 10) + '</td>';

                            var tr = '<tr class="even pointer" id="remove_' + purchase['id'] + '">';
                            tr = tr + '<td>' + count + '</td>' + remove + product + brend + model + pcs + unit + cost + total_cost + date;
                            tr = tr + '</tr>';
                            table = table + tr;
                        }

                        $('#selected_purchases_table').html(table);
                    }
                }
            });
        }

        function add_purchase_to_selected_account(purchase_id) {
            var account_id = $('#account_id').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'account_id': account_id,
                    'purchase_id': purchase_id,
                    '_token': CSRF_TOKEN,
                    'type': 'add_purchase_to_selected_account'
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

                        var remove = '<td><span onclick="remove_purchase_from_selected_account(' + purchase['id'] + ');" class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></span></td>';
                        var product = '<td>' + purchase['Product'] + '</td>';
                        var brend = '<td>' + purchase['Brend'] + '</td>';
                        var model = '<td>' + purchase['Model'] + '</td>';
                        var pcs = '<td>' + purchase['pcs'] + '</td>';
                        var unit = '<td>' + purchase['Unit'] + '</td>';
                        var cost = '<td>' + purchase['cost'] + '</td>';
                        var total_cost = '<td>' + purchase['total_cost'] + '</td>';
                        var date = '<td>' + purchase['created_at'].substr(0, 10) + '</td>';

                        var tr = '<tr class="even pointer" id="remove_' + purchase['id'] + '">';
                        tr = tr + '<td>' + '<span style="color: green;">new</span>' + '</td>' + remove + product + brend + model + pcs + unit + cost + total_cost + date;
                        tr = tr + '</tr>';
                        table = table + tr;

                        $('#move_'+purchase['id']).remove();
                        $('#selected_purchases_table').append(table);
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

                        var move_btn = '<td><span onclick="add_purchase_to_selected_account(' + purchase['id'] + ');" class="btn btn-success btn-xs"><i class="fa fa-plus"></i></span></td>';
                        var product = '<td>' + purchase['Product'] + '</td>';
                        var brend = '<td>' + purchase['Brend'] + '</td>';
                        var model = '<td>' + purchase['Model'] + '</td>';
                        var pcs = '<td>' + purchase['pcs'] + '</td>';
                        var unit = '<td>' + purchase['Unit'] + '</td>';
                        var cost = '<td>' + purchase['cost'] + '</td>';
                        var total_cost = '<td>' + purchase['total_cost'] + '</td>';
                        var date = '<td>' + purchase['created_at'].substr(0, 10) + '</td>';

                        var tr = '<tr class="even pointer" id="move_' + purchase['id'] + '">';
                        tr = tr + '<td>' + '<span style="color: green;">new</span>' + '</td>' + move_btn + product + brend + model + pcs + unit + cost + total_cost + date;
                        tr = tr + '</tr>';
                        table = table + tr;

                        $('#remove_'+purchase['id']).remove();
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
                        else if (response.type === 'update_doc') {
                            $('#update-doc-modal').modal('hide');
                        }
                    }
                }
            });
        });
    </script>
@endsection