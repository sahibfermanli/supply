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
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="seller_name" placeholder="Satıcı adı *"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="seller_director" placeholder="Satıcı direktor *"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="seller_voen" placeholder="Satıcı VÖEN *"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="seller_account_no" placeholder="Satıcı hesab № *"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="bank_name" placeholder="Bank adı *"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="bank_voen" placeholder="Bank VÖEN *"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="bank_code" placeholder="Bank kodu *"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="bank_m_n" placeholder="Bank M/Hesab № *"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="bank_swift" placeholder="Bank SWIFT *"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="contract_no" placeholder="Müqavilə № *"></td>
                                        <td id="orders-add-inputs" ><input type="date" class="form-control input-sm" name="contract_date"></td>
                                    </tr>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title">Satıcı</th>
                                        <th class="column-title">Direktor</th>
                                        <th class="column-title">Satıcı VÖEN</th>
                                        <th class="column-title">Satıcı Hesab №</th>
                                        <th class="column-title">Bank</th>
                                        <th class="column-title">Bank VÖEN</th>
                                        <th class="column-title">Bank KOD</th>
                                        <th class="column-title">Bank M/Hesab №</th>
                                        <th class="column-title">Bank SWIFT</th>
                                        <th class="column-title">Müqavilə №</th>
                                        <th class="column-title">Müqavilə tarixi</th>
                                        <th class="column-title">Yaradılma tarixi</th>
                                        <th class="column-title">Əlavə edən</th>
                                        <th class="column-title">#Əməliyyatlar</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @php
                                        $row = 1;
                                    @endphp
                                    @foreach($companies as $company)
                                        <tr class="even pointer" id="row_{{$row}}">
                                            <td>{{$row}}</td>
                                            <td>{{$company->seller_name}}</td>
                                            <td>{{$company->seller_director}}</td>
                                            <td>{{$company->seller_voen}}</td>
                                            <td>{{$company->seller_account_no}}</td>
                                            <td>{{$company->bank_name}}</td>
                                            <td>{{$company->bank_voen}}</td>
                                            <td>{{$company->bank_code}}</td>
                                            <td>{{$company->bank_m_n}}</td>
                                            <td>{{$company->bank_swift}}</td>
                                            <td>{{$company->contract_no}}</td>
                                            <td>{{$company->contract_date}}</td>
                                            <td>{{$company->created_at}}</td>
                                            <td>{{$company->edited_ip}}</td>

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