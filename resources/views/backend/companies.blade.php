@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Şirkətlər</h3>
                    <span style="float: right;" class="btn btn-success btn-add-new-company" onclick="show_company_add_form();"><i class="fa fa-plus"></i></span>
                    <span type="button" onclick="remove_company_add_form();" class="btn btn-success btn-remove-new-company" style="float: right; display: none;"><i class="fa fa-minus"></i></span>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="table-responsive">
                                <div>
                                    {!! $companies->links(); !!}
                                </div>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="type" value="add">
                                    {{csrf_field()}}
                                <table class="table table-bordered">
                                    <thead>
                                    <tr class="jsgrid-filter-row" style="display: none;" id="company-add-form">
                                        <td id="add-btn-td"><center><button type="submit" id="add-btn" class="btn btn-success btn-xs"><i class="fa fa-save"></i></button></center></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="name" placeholder="Şirkət adı *"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="address" placeholder="Ünvan *"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="zip_code" placeholder="Zip kod *"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="phone" placeholder="Telefon *"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="fax" placeholder="Faks *"></td>
                                        <td id="orders-add-inputs" colspan="3">
                                            <select name="local" class="form-control input-sm">
                                                <option value="0">Yerli</option>
                                                <option value="1">Xarici</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title">Şirkət adı</th>
                                        <th class="column-title">Ünvan</th>
                                        <th class="column-title">Zip kod</th>
                                        <th class="column-title">Telefon</th>
                                        <th class="column-title">Faks</th>
                                        <th class="column-title">Yerli/Xarici</th>
                                        <th class="column-title">Yaradılma tarixi</th>
                                        <th class="column-title">#Əməliyyatlar</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @php
                                        $row = 1;
                                    @endphp
                                    @foreach($companies as $company)
                                        <?php $company_date = date('d.m.Y', strtotime($company->created_at)); ?>
                                        <tr class="even pointer" id="row_{{$row}}">
                                            <td>{{$row}}</td>
                                            <td><input style="border: none;" type="text" class="form-control input-sm" id="name_edit_{{$company->id}}" value="{{$company->name}}"></td>
                                            <td><input style="border: none;" type="text" class="form-control input-sm" id="address_edit_{{$company->id}}" value="{{$company->address}}"></td>
                                            <td><input style="border: none;" type="text" class="form-control input-sm" id="zip_code_edit_{{$company->id}}" value="{{$company->zip_code}}"></td>
                                            <td><input style="border: none;" type="text" class="form-control input-sm" id="phone_edit_{{$company->id}}" value="{{$company->phone}}"></td>
                                            <td><input style="border: none;" type="text" class="form-control input-sm" id="fax_edit_{{$company->id}}" value="{{$company->fax}}"></td>
                                            <td>
                                                <select style="border: none;" type="text" class="form-control input-sm" id="local_edit_{{$company->id}}">
                                                    @if($company->local == 0)
                                                        <option selected value="0">Yerli</option>
                                                        <option value="1">Xarici</option>
                                                    @else
                                                        <option value="0">Yerli</option>
                                                        <option selected value="1">Xarici</option>
                                                    @endif
                                                </select>
                                            </td>
                                            <td>{{$company_date}}</td>
                                            <td>
                                                <span title="Düzəliş et" class="btn btn-warning btn-xs" onclick="update(this, '{{$company->id}}');"><i class="fa fa-edit"></i></span>
                                                <span title="Sil" class="btn btn-danger btn-xs" onclick="del(this, '{{$company->id}}', '{{$row}}');"><i class="fa fa-trash-o"></i></span>
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
                                    {!! $companies->links(); !!}
                                </div>
                            </div>
                        </div>
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

    <script>
        //show new compnay form
        function show_company_add_form() {
            $('#company-add-form').css('display', 'table-row');
            $('.btn-add-new-company').css('display', 'none');
            $('.btn-remove-new-company').css('display', 'block');
        }

        //remove new company form
        function remove_company_add_form() {
            $('#company-add-form').css('display', 'none');
            $('.btn-add-new-company').css('display', 'block');
            $('.btn-remove-new-company').css('display', 'none');
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

                    var name = $('#name_edit_'+id).val();
                    var address = $('#address_edit_'+id).val();
                    var zip_code = $('#zip_code_edit_'+id).val();
                    var phone = $('#phone_edit_'+id).val();
                    var fax = $('#fax_edit_'+id).val();
                    var local = $('#local_edit_'+id).val();

                    $.ajax({
                        type: "Post",
                        url: '',
                        data: {
                            'id': id,
                            'name': name,
                            'address': address,
                            'zip_code': zip_code,
                            'phone': phone,
                            'fax': fax,
                            'local': local,
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

        $(document).ready(function () {
            $('form').validate();
            $('form').ajaxForm({
                beforeSubmit: function () {
                    //loading
                    swal({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Gözləyin...</span>',
                        text: 'Gözləyin, əməliyyat aparılır...',
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
                        if (response.type === 'add_company') {
                            location.reload();
                        }
                    }
                }
            });
        });
    </script>
@endsection