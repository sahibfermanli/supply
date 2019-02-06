@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Texnikalar</h3>
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
                                    {!! $vehicles->links(); !!}
                                </div>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="type" value="add">
                                    {{csrf_field()}}
                                <table class="table table-bordered">
                                    <thead>
                                    <tr class="jsgrid-filter-row" style="display: none;" id="company-add-form">
                                        <td id="add-btn-td"><center><button type="submit" id="add-btn" class="btn btn-success btn-xs"><i class="fa fa-save"></i></button></center></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="Marka" placeholder="Marka *"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="QN" placeholder="QN"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="Tipi" placeholder="Tipi"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="SN" placeholder="SN"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="DNN" placeholder="DNN"></td>
                                        <td id="orders-add-inputs" ><input type="text" class="form-control input-sm" name="buraxilish_il" placeholder="Buraxılış ili"></td>
                                    </tr>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title">Marka</th>
                                        <th class="column-title">QN</th>
                                        <th class="column-title">Tipi</th>
                                        <th class="column-title">SN</th>
                                        <th class="column-title">DNN</th>
                                        <th class="column-title">Buraxılış ili</th>
                                        <th class="column-title">Yaradılma tarixi</th>
                                        <th class="column-title">Əlavə edən</th>
                                        <th class="column-title">#Əməliyyatlar</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @php
                                        $row = 1;
                                    @endphp
                                    @foreach($vehicles as $vehicle)
                                        <tr class="even pointer" id="row_{{$row}}">
                                            <td>{{$vehicle->id}}</td>
                                            <td>{{$vehicle->Marka}}</td>
                                            <td>{{$vehicle->QN}}</td>
                                            <td>{{$vehicle->Tipi}}</td>
                                            <td>{{$vehicle->SN}}</td>
                                            <td>{{$vehicle->DNN}}</td>
                                            <td>{{$vehicle->buraxilish_il}}</td>
                                            <td>{{$vehicle->created_at}}</td>
                                            <td>{{$vehicle->edited_by}}</td>
                                            <td>
                                                <span title="Sil" class="btn btn-danger btn-xs" onclick="del(this, '{{$vehicle->id}}', '{{$row}}');"><i class="fa fa-trash-o"></i></span>
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
                                    {!! $vehicles->links(); !!}
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
                        if (response.type === 'add') {
                            location.reload();
                        }
                    }
                }
            });
        });
    </script>
@endsection