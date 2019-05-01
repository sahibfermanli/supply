@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Alternativlərin siyahısı</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="table-responsive" style="overflow-y: hidden;">
                                <div>
                                    {!! $alternatives->links(); !!}
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title">ID</th>
                                        <th class="column-title">Sifariş id</th>
                                        <th class="column-title">Malın adı</th>
                                        <th class="column-title">Marka</th>
                                        <th class="column-title">Model</th>
                                        <th class="column-title">Part No</th>
                                        <th class="column-title">Miqdar</th>
                                        <th class="column-title">Ölçü vahidi</th>
                                        <th class="column-title">Qiymət</th>
                                        <th class="column-title">Valyuta</th>
                                        <th class="column-title">Qiymət tarixi</th>
                                        <th class="column-title">Ümumi qiymət</th>
                                        <th class="column-title">Bazar tipi</th>
                                        <th class="column-title">Firma</th>
                                        <th class="column-title">Ölkə</th>
                                        <th class="column-title">Qeyd</th>
                                        <th class="column-title">Yaradılma vaxtı</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($alternatives as $alternative)
                                        <tr class="rows" id="row_{{$alternative->id}}" onclick="select_row({{$alternative->id}});">
                                            <td>
                                                <span onclick="del_alt({{$alternative->id}});" title="Sil" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></span>
                                                <span onclick="update({{$alternative->id}});" title="Düzəliş et" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></span>
                                            </td>
                                            <td>{{$alternative->id}}</td>
                                            <td>{{$alternative->OrderID}}</td>
                                            <td><input class="form-control input-sm" title="{{$alternative->Product}}" type="text" id="{{$alternative->id}}_Product" value="{{$alternative->Product}}"></td>
                                            <td><input class="form-control input-sm" title="{{$alternative->Brend}}" type="text" id="{{$alternative->id}}_Brend" value="{{$alternative->Brend}}"></td>
                                            <td><input class="form-control input-sm" title="{{$alternative->Model}}" type="text" id="{{$alternative->id}}_Model" value="{{$alternative->Model}}"></td>
                                            <td><input class="form-control input-sm" title="{{$alternative->PartSerialNo}}" type="text" id="{{$alternative->id}}_PartSerialNo" value="{{$alternative->PartSerialNo}}"></td>
                                            <td><input class="form-control input-sm" title="{{$alternative->pcs}}" type="number" id="{{$alternative->id}}_pcs" value="{{$alternative->pcs}}"></td>
                                            <td id="orders-add-inputs" style="width: 150px;">
                                                <select class="form-control input-sm" id="{{$alternative->id}}_unit_id" required>
                                                    @foreach($units as $unit)
                                                        @if($unit->id == $alternative->unit_id)
                                                            <option selected
                                                                    value="{{$unit->id}}">{{$unit->Unit}}</option>
                                                        @else
                                                            <option value="{{$unit->id}}">{{$unit->Unit}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input class="form-control input-sm" title="{{$alternative->cost}}" type="number" id="{{$alternative->id}}_cost" value="{{$alternative->cost}}"></td>
                                            <td id="orders-add-inputs" style="width: 150px;">
                                                <select class="form-control input-sm" id="{{$alternative->id}}_currency_id" required>
                                                    @foreach($currencies as $currency)
                                                        @if($currency->id == $alternative->currency_id)
                                                            <option selected
                                                                    value="{{$currency->id}}">{{$currency->cur_name}}</option>
                                                        @else
                                                            <option value="{{$currency->id}}">{{$currency->cur_name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input class="form-control input-sm" title="{{$alternative->date}}" type="date" id="{{$alternative->id}}_date" value="{{$alternative->date}}"></td>
                                            <td>{{$alternative->total_cost}}</td>
                                            <td>{{$alternative->store_type}}</td>
                                            <td id="orders-add-inputs" style="width: 150px;">
                                                <select class="form-control input-sm" id="{{$alternative->id}}_company_id" required>
                                                    @foreach($companies as $company)
                                                        @if($company->id == $alternative->company_id)
                                                            <option selected value="{{$company->id}}">{{$company->name}}</option>
                                                        @else
                                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td id="orders-add-inputs" style="width: 150px;">
                                                <select class="form-control input-sm" id="{{$alternative->id}}_country_id" required>
                                                    @foreach($countries as $country)
                                                        @if($country->id == $alternative->country_id)
                                                            <option selected
                                                                    value="{{$country->id}}">{{$country->country_name}}</option>
                                                        @else
                                                            <option value="{{$country->id}}">{{$country->country_name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input class="form-control" title="{{$alternative->Remark}}" type="text" id="{{$alternative->id}}_Remark" value="{{$alternative->Remark}}"></td>
                                            <td>{{$alternative->created_at}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div>
                                    {!! $alternatives->links(); !!}
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

    {{--alert--}}
    <script>
        function select_row(row) {
            $('.rows').css('background-color', 'white');
            $('#row_'+row).css('background-color', '#acecff');
        }

        function del_alt(id) {
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
                            'type': 'delete'
                        },
                        success: function (response) {
                            swal.close();
                            if (response.case === 'success') {
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
                } else {
                    return false;
                }
            });
        }

        function update(id) {
            swal({
                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Gözləyin...</span>',
                text: 'Gözləyin, əməliyyat aparılır..',
                showConfirmButton: false
            });

            var Product = $("#" + id + "_Product").val();
            var Brend = $("#" + id + "_Brend").val();
            var Model = $("#" + id + "_Model").val();
            var PartSerialNo = $("#" + id + "_PartSerialNo").val();
            var pcs = $("#" + id + "_pcs").val();
            var unit_id = $("#" + id + "_unit_id").val();
            var cost = $("#" + id + "_cost").val();
            var currency_id = $("#" + id + "_currency_id").val();
            var date = $("#" + id + "_date").val();
            var company_id = $("#" + id + "_company_id").val();
            var country_id = $("#" + id + "_country_id").val();
            var Remark = $("#" + id + "_Remark").val();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'id': id,
                    'Product': Product,
                    'Brend': Brend,
                    'Model': Model,
                    'PartSerialNo': PartSerialNo,
                    'pcs': pcs,
                    'unit_id': unit_id,
                    'cost': cost,
                    'currency_id': currency_id,
                    'date': date,
                    'company_id': company_id,
                    'country_id': country_id,
                    'Remark': Remark,
                    '_token': CSRF_TOKEN,
                    'type': 'update'
                },
                success: function (response) {
                    swal.close();
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
        }
    </script>
@endsection