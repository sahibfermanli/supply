@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Sifarişlər</h3>
                    <span class="btn btn-success btn-mobile" style="display: none;">Kategoriyalar</span>
                    <button type="button" onclick="show_add_form();" class="btn btn-success btn-add-new-order" style="float: right; display: none;"><i class="fa fa-plus"></i></button>
                    <button type="button" onclick="remove_add_form();" class="btn btn-success btn-remove-new-order" style="float: right; display: none;"><i class="fa fa-minus"></i></button>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div id="message" class="message-mobile">
                            <h1>Zəhmət olmasa kategoriya seçin...</h1>
                            <p>Seçim sehifenin sol kenarında, menyudadır...</p>
                        </div>
                        <div class="cats-mobile">
                            <ul class="nav child_menu show-categories-for-alts-supply">
                                @foreach($categories as $category)
                                    <li class="cat-li"><a style="color: black;" class="cat-select" href="#" cat_id="{{$category->id}}">{{$category->process}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="x_content" id="table_display">
                            <div class="table-responsive">
                                <form action="" method="post">
                                    <input type="hidden" name="type" value="7">
                                    <div id="add_to_form_category_id"></div>
                                    {{csrf_field()}}
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr class="jsgrid-filter-row add-new-order-form" id="orders_input">

                                        </tr>
                                        <tr class="headings">
                                            <th class="column-title">#</th>
                                            @if(Auth::user()->chief() == 1)
                                                @php($product_input_length = 1)
                                                <th class="column-title">Təchizatçı</th>
                                            @else
                                                @php($product_input_length = 1)
                                            @endif
                                            <th class="column-title">Emeliyyatlar</th>
                                            <th class="column-title" id="Product_th">Malın adı</th>
                                            <th class="column-title" id="Translation_Brand_th">Tərcümə/Təyinat</th>
                                            <th class="column-title" id="Part_th">Part No</th>
                                            <th class="column-title" id="WEB_link_th">WEB link</th>
                                            <th class="column-title" id="Pcs_th">Miqdar</th>
                                            <th class="column-title" id="unit_th">Ölçü vahidi</th>
                                            <th class="column-title" id="vehicle_th">Qaraj No</th>
                                            <th class="column-title" id="position_th">Vəzifə</th>
                                            <th class="column-title">Sifarişçi</th>
                                            <th class="column-title" id="Status_th">Status</th>
                                            <th class="column-title" id="Remark_th">Sifariş səbəbi</th>
                                            <th class="column-title" id="Image_th">Şəkil</th>
                                            <th class="column-title" id="Defect_th">Qüsur aktı</th>
                                        </tr>
                                        </thead>

                                        <tbody id="orders_table">

                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--show alternative & add alternative--}}
    <div class="modal fade" id="show-alternative-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div style="width: 80% !important;" class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span style="color: green;" id="order_details"></span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="table-responsive">
                                        <form action="" method="post" enctype="multipart/form-data" id="alt-form">
                                            {{csrf_field()}}
                                            <div id="order_id_for_alternative"></div>
                                            <input type="hidden" name="type" value="5">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr class="jsgrid-filter-row">
                                                    <td id="add-btn-td" colspan="3">
                                                        <button type="submit" id="add-btn"
                                                                class="btn btn-success btn-xs"><i
                                                                    class="fa fa-plus"></i></button>
                                                    </td>
                                                    <td id="orders-add-inputs" style="width: 150px;"><input type="text"
                                                                                                            id="brend_input"
                                                                                                            class="form-control input-sm"
                                                                                                            name="Brend"
                                                                                                            placeholder="Marka *"
                                                                                                            required>
                                                    </td>
                                                    <td id="orders-add-inputs" style="width: 150px;"><input type="text"
                                                                                                            id="model_input"
                                                                                                            class="form-control input-sm"
                                                                                                            name="Model"
                                                                                                            placeholder="Model *"
                                                                                                            required>
                                                    </td>
                                                    <td id="orders-add-inputs" style="width: 150px;"><input type="text"
                                                                                                            id="part_input"
                                                                                                            class="form-control input-sm"
                                                                                                            name="PartSerialNo"
                                                                                                            placeholder="Part NO *"
                                                                                                            required>
                                                    </td>
                                                    <td id="orders-add-inputs" style="width: 150px;"><input type="number"
                                                                                                            class="form-control input-sm"
                                                                                                            name="pcs"
                                                                                                            id="pcs_cost_input"
                                                                                                            onchange="total_cost()"
                                                                                                            placeholder="Miqdar *"
                                                                                                            required>
                                                    </td>
                                                    <td id="orders-add-inputs" style="width: 150px;">
                                                        <select class="form-control input-sm" name="unit_id" required id="unit_input">
                                                            @foreach($units as $unit)
                                                                @if($unit->id == 10)
                                                                    <option selected
                                                                            value="{{$unit->id}}">{{$unit->Unit}}</option>
                                                                @else
                                                                    <option value="{{$unit->id}}">{{$unit->Unit}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td id="orders-add-inputs" style="width: 150px;"><input type="number"
                                                                                                            class="form-control input-sm"
                                                                                                            name="cost"
                                                                                                            id="cost_input"
                                                                                                            placeholder="Qiymət *"
                                                                                                            onchange="total_cost()"
                                                                                                            required>
                                                    </td>
                                                    <td id="orders-add-inputs" style="width: 150px;">
                                                        <select class="form-control input-sm" name="currency_id" id="currency_input"
                                                                required>
                                                            @foreach($currencies as $currency)
                                                                @if($currency->id == 1)
                                                                    <option selected value="{{$currency->id}}">{{$currency->cur_name}}</option>
                                                                @else
                                                                    <option value="{{$currency->id}}">{{$currency->cur_name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td id="orders-add-inputs" style="width: 150px;"><input type="date" id="date_input"
                                                                                                            class="form-control input-sm"
                                                                                                            name="date"
                                                                                                            placeholder="Qiymət tarixi  *"
                                                                                                            required>
                                                    </td>
                                                    <td id="orders-add-inputs" style="width: 150px;"><input type="text"
                                                                                                            class="form-control input-sm"
                                                                                                            disabled="disabled"
                                                                                                            id="total_cost_input"
                                                                                                            placeholder="Ümumi qiymət">
                                                    </td>
                                                    <td id="orders-add-inputs" style="width: 150px;">
                                                        <select class="form-control input-sm" name="store_type" id="store_input"
                                                                required>
                                                            <option value="Yerli">Yerli</option>
                                                            <option value="Xarici">Xarici</option>
                                                            <option value="Bazar">Bazar</option>
                                                        </select>
                                                    </td>
                                                    <td id="orders-add-inputs" style="width: 150px;">
                                                        <select class="form-control input-sm" name="company_id" id="company_input"
                                                                required>
                                                            <option selected value="">Seçin</option>
                                                            @foreach($companies as $company)
                                                                <option value="{{$company->id}}">{{$company->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td id="orders-add-inputs" style="width: 150px;">
                                                        <select class="form-control input-sm" name="country_id" id="country_input"
                                                                required>
                                                            @foreach($countries as $country)
                                                                @if($country->id == 15)
                                                                    <option selected
                                                                            value="{{$country->id}}">{{$country->country_name}}</option>
                                                                @else
                                                                    <option value="{{$country->id}}">{{$country->country_name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td id="orders-add-inputs" style="width: 150px;"><input type="file"
                                                                                                            id="image_input"
                                                                                                            class="form-control input-sm"
                                                                                                            name="picture">
                                                    </td>
                                                    <td colspan="2" id="orders-add-inputs" style="width: 150px;"><input
                                                                id="remark_input"
                                                                type="text" class="form-control input-sm" name="Remark"
                                                                placeholder="Qeyd *" required></td>
                                                </tr>
                                                <tr class="headings">
                                                    <th class="column-title">#</th>
                                                    <th class="column-title">#</th>
                                                    <th class="column-title">Sil</th>
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
                                                    <th class="column-title">Şəkil</th>
                                                    <th class="column-title">Qeyd</th>
                                                    <th class="column-title">Direktorun qeydi</th>
                                                </tr>
                                                </thead>

                                                <tbody id="alts_table">

                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--show alternative & add alternative--}}

    <!-- start add modal (qeyd ve sekil)-->
    <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <div class="modal-body-data">
                        <div class="remark-modal"></div>
                        <form action="" id="form" method="post" enctype="multipart/form-data" class="image-form-modal">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.end add modal-->

    <!-- start select supply for order-->
    @if(Auth::user()->chief() == 1)
        <div class="modal fade" id="select-supply-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <form id="form" action="" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="type" value="9">
                            <div id="order_id_for_select_supply"></div>
                            <div id="category_id_for_select_supply"></div>
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="supply_id">Təchizatçı</label>
                                    <select class="form-control col-md-7 col-xs-12" name="supply_id" id="supply_id">
                                        @foreach($supplies as $supply)
                                            <option value="{{$supply->id}}">{{$supply->name}} {{$supply->surname}}</option>
                                        @endforeach
                                    </select>
                                    <button style="margin-top: 10px;" type="submit" class="btn btn-success">Təsdiqlə</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- /.end select supply for order-->

    {{--start alt image modal--}}
    <div class="modal fade" id="alt-image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alt-image">

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--finish alt image modal--}}

@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">

    <style>
        #table_display {
            display: none;
        }
    </style>
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.show-categories-for-alts-supply').css('display', 'block');
        });
    </script>

    {{--change category--}}
    <script>
        $('.cat-select').on('click', function (e) {
            e.preventDefault();

            $('.btn-add-new-order').css('display', 'block');
            $('.btn-remove-new-order').css('display', 'none');
            $('.add-new-order-form').css('display', 'none');

            $('#message').css('display', 'none');

            $('.cat-select').removeClass('active');
            $('.cat-li').removeClass('active');
            $(this).addClass('active');

            var cat_id = $(this).attr('cat_id');

            change_category(cat_id);
        });
    </script>

    {{--change category--}}
    <script>
        function change_category(elem) {
            var cat_id = elem;

            $('#add_to_form_category_id').html('<input type="hidden" name="category_id" value="' + cat_id + '">');
            $('#category_id_for_select_supply').html('<input type="hidden" id="cat_id_for_select_suplly" name="cat_id" value="' + cat_id + '">');

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'cat_id': cat_id,
                    '_token': CSRF_TOKEN,
                    'type': 6
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
                    if (response.case === 'success') {
                        swal.close();

                        var category_id = response.category_id;

                        if (category_id === '') {
                            $('#table_display').css('display', 'none');
                            alert('Kateqoriya seçin...');
                            return false;
                        }

                        $('#Product_th').css('display', 'table-cell');
                        $('#Translation_Brand_th').css('display', 'table-cell');
                        $('#Part_th').css('display', 'table-cell');
                        $('#WEB_link_th').css('display', 'table-cell');
                        $('#Pcs_th').css('display', 'table-cell');
                        $('#unit_th').css('display', 'table-cell');
                        $('#vehicle_th').css('display', 'table-cell');
                        $('#Defect_th').css('display', 'none');
                        $('#position_th').css('display', 'none');

                        switch (category_id) {
                            case '1': {
                                //xususi texnika
                                $('#Product_th').html('Malın adı');
                                $('#Translation_Brand_th').html('Tərcümə/Təyinat');
                                $('#Part_th').html('Part No');
                                $('#Defect_th').css('display', 'table-cell');
                            }
                                break;

                            case '2': {
                                //xidmeti
                                $('#Product_th').html('Malın adı');
                                $('#Translation_Brand_th').html('Tərcümə/Təyinat');
                                $('#Part_th').html('Part No');
                                $('#Defect_th').css('display', 'table-cell');
                            }
                                break;

                            case '3': {
                                //servis
                                $('#Product_th').html('Görülən işin adı');
                                $('#Translation_Brand_th').css('display', 'none');
                                $('#Part_th').css('display', 'none');
                                $('#Defect_th').css('display', 'table-cell');
                            }
                                break;

                            case '4': {
                                //mesref
                                $('#Product_th').html('Malın adı');
                                $('#Translation_Brand_th').html('Əlavə məlumat');
                                $('#Part_th').html('Markası');
                                $('#vehicle_th').css('display', 'none');
                            }
                                break;

                            case '5': {
                                //inventar
                                $('#Product_th').html('Malın adı');
                                $('#Translation_Brand_th').html('Əlavə məlumat');
                                $('#Part_th').html('Markası');
                                $('#vehicle_th').css('display', 'none');
                            }
                                break;

                            case '6': {
                                //akkumlyator
                                $('#Product_th').html('Malın adı');
                                $('#Translation_Brand_th').html('Əlavə məlumat');
                                $('#Part_th').html('Model');
                                $('#Defect_th').css('display', 'table-cell');
                            }
                                break;

                            case '7': {
                                //forma
                                $('#Product_th').html('Malın adı');
                                $('#Translation_Brand_th').html('Razmer');
                                $('#Part_th').html('Tip/Marka');
                                $('#position_th').css('display', 'table-cell');
                                $('#vehicle_th').css('display', 'none');
                            }
                                break;

                            case '8': {
                                //defterxana
                                $('#Product_th').html('Adı');
                                $('#Translation_Brand_th').css('display', 'none');
                                $('#Part_th').html('Tipi');
                                $('#vehicle_th').css('display', 'none');
                            }
                                break;

                            case '9': {
                                //blank
                                $('#Product_th').html('Adı');
                                $('#Translation_Brand_th').css('display', 'none');
                                $('#Part_th').html('Tipi');
                                $('#vehicle_th').css('display', 'none');
                            }
                                break;

                            case '10': {
                                //teker
                                $('#Product_th').html('Təkərin ölçüsü');
                                $('#Translation_Brand_th').html('Əlavə məlumat');
                                $('#Part_th').html('Markası');
                                $('#Defect_th').css('display', 'table-cell');
                            }
                                break;

                            ////////////////////////////////
                            default: {
                                alert('Kateqoriya tapılmadı!');
                            }
                        }

                        var purchases = response.purchases;

                        var table = '';
                        var orders = response.orders;
                        var i = 0;
                        var count = 0;
                        var position = '';
                        var select_supply = '';
                        var edit = '';
                        var cancel = '';
                        var check = '';

                        for (i = 0; i < orders.length; i++) {
                            count++;
                            var order = orders[i];
                            var id = order['id'];
                            var user_detail = '<td style="min-width: 150px;">' + order['user_name'] + ' ' + order['user_surname'] + ' , ' + order['user_department'] + '</td>';
                            var product = '<td title="' + order['Product'] + '" style="min-width: 150px;">' + '<input id="product_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" value="' + order['Product'] + '">' + '</td>';
                            var translation_brand = '<td style="min-width: 150px;" title="' + order['Translation_Brand'] + '">' + '<input id="translation_brand_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" value="' + order['Translation_Brand'] + '">' + '</td>';
                            var part = '<td title="' + order['Part'] + '" style="min-width: 100px;">' + '<input id="part_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" value="' + order['Part'] + '">' + '</td>';
                            var first_pcs = order['Pcs'];
                            if ((first_pcs - parseInt(first_pcs)) > 0) {
                                var last_pcs = first_pcs;
                            }
                            else {
                                var last_pcs = parseInt(first_pcs);
                            }
                            var pcs = '<td>' + '<input id="pcs_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" value="' + last_pcs + '">' + '</td>';

                            var unit_id = order['unit_id'];
                            var units = response.units;
                            var unit = '';
                            var j = 0;
                            unit = unit + '<td title="' + order['Unit'] + '" style="min-width: 110px;"><select id="unit_id_edit_' + id + '" class="form-control input-sm">';
                            for(j=0; j<units.length; j++) {
                                if (units[j]['id'] == unit_id) {
                                    unit = unit+ '<option selected value="' + units[j]['id'] + '">' + units[j]['Unit'] + '</option>';
                                }
                                else {
                                    unit = unit+ '<option value="' + units[j]['id'] + '">' + units[j]['Unit'] + '</option>';
                                }
                            }
                            unit = unit + '</select></td>';

                            var vehicle_id = order['vehicle_id'];
                            var vehicles = response.vehicles;
                            var vehicle = '';
                            var j = 0;
                            vehicle = vehicle + '<td title="' + order['vehicle'] + ' , ' + order['QN'] + ' , ' + order['Tipi'] + '" style="min-width: 170px;"><select id="vehicle_id_edit_' + id + '" class="form-control input-sm">';
                            for(j=0; j<vehicles.length; j++) {
                                if (vehicles[j]['id'] == vehicle_id) {
                                    vehicle = vehicle+ '<option selected value="' + vehicles[j]['id'] + '">' + vehicles[j]['Marka'] + '</option>';
                                }
                                else {
                                    vehicle = vehicle+ '<option value="' + vehicles[j]['id'] + '">' + vehicles[j]['Marka'] + '</option>';
                                }
                            }
                            vehicle = vehicle + '</select></td>';
                            var marka = vehicle;

                            if (order['WEB_link'] == null) {
                                var web_link = '<td title="' + order['WEB_link'] + '" style="min-width: 100px;">' + '<input id="WEB_link_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" value="' + order['WEB_link'] + '">' + '</td>';
                                // var web_link = '<td title="Link yoxdur"><span disabled="true"><i class="fa fa-link"></i></span></td>';
                            }
                            else {
                                var web_link = '<td title="' + order['WEB_link'] + '" style="min-width: 100px;">' + '<input id="WEB_link_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" value="' + order['WEB_link'] + '">' + '</td>';
                                // var web_link = '<td title="' + order['WEB_Link'] + '"><a target="_blank" href="' + order['WEB_link'] + '"><i class="fa fa-link"></i></a></td>';
                            }

                            if (order['Remark'] == null) {
                                var remark = '<td><center><span style="background-color: yellowgreen; border-color: yellowgreen;" disabled="true" title="Qeydi göstər" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></span></center></td>';
                            }
                            else {
                                var remark = '<td><center><span title="Qeydi göstər" onclick="get_data(' + id + ', 3);" class="btn btn-success btn-xs add-modal"><i class="fa fa-eye"></i></span></center></td>';
                            }

                            if (order['image'] == null) {
                                var picture = '<td><center><span style="background-color: yellowgreen; border-color: yellowgreen;" disabled="true" title="Şəkli göstər" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></span></center></td>';
                            }
                            else {
                                var picture = '<td><center><span title="Şəkli göstər" onclick="get_data(' + id + ', 4);" class="btn btn-success btn-xs add-modal"><i class="fa fa-eye"></i></span></center></td>';
                            }

                            if (order['deffect_doc'] == null) {
                                var defect = '<td><center><span style="background-color: yellowgreen; border-color: yellowgreen;" disabled="true" title="Xəta sənədini endir" class="btn btn-success btn-xs"><i class="fa fa-download"></i></span></center></td>';
                            }
                            else {
                                var defect = '<td><center><a title="Xəta sənədini endir" href="' + order['deffect_doc'] + '" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-download"></i></a></center></td>';
                            }

                            var status = '<td><span id="status_' + id + '" class="btn btn-xs" style="color: ' + order['color'] + ';">' + order['status'] + '</span></td>';

                            if(order['confirmed'] === 1 && order['SupplyID'] !== null) {
                                var send_director = '<span onclick="show_alternative(' + id + ',' + last_pcs + ',' + unit_id + ');" class="btn btn-success btn-xs show-alternative-modal"><i class="fa fa-eye"></i></span>';
                            }
                            else {
                                var send_director = '<span style="background-color: red; border-color: red;" disabled="true" title="Sifariş təsdiqlənməyib" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></span>';
                            }

                            @if(Auth::user()->chief() == 1)
                            if (order['confirmed'] == 1) {
                                if (order['SupplyID'] == null) {
                                    select_supply = '<td><span onclick="select_supply(' + id + ');" class="btn btn-success btn-xs select-supply-modal">Seç</span></td>';
                                }
                                else {
                                    select_supply = '<td><span class="btn btn-warning btn-xs">' + order['supply_name'] + ' ' + order['supply_surname'] + '</span></td>';
                                }
                            }
                            else {
                                select_supply = '<td><span disabled="true" style="background-color: red; border-color: red;" title="Sifariş təsdiqlənməyib" class="btn btn-success btn-xs">Seç</span></td>';
                            }


                            if (order['status_id'] == 9 || order['confirmed'] == 1) {
                                edit = '<span disabled title="Düymə deaktivdir" class="btn btn-warning btn-xs"><i class="fa fa-exclamation-circle"></i></span>';
                                cancel = '<span disabled title="Düymə deaktivdir" class="btn btn-danger btn-xs"><i class="fa fa-exclamation-circle"></i></span>';
                                check = '<i style="color: red;" class="fa fa-check"></i>';
                            }
                            else {
                                edit = '<span onclick="update_order(' + id + ');" title="Düzəliş et" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></span>';
                                cancel = '<span id="cancel_btn_' + id + '" onclick="del(this, ' + id + ');" title="Geri çevir" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></span>';
                                check = '<span id="check_' + id + '" class="btn btn-success btn-xs" onclick="confirm_order(' + id + ');"><i class="fa fa-check"></i></span>';
                            }
                            @else
                            if (order['status_id'] == 9 || order['confirmed'] == 1) {
                                edit = '<span disabled title="Düymə deaktivdir" class="btn btn-warning btn-xs"><i class="fa fa-exclamation-circle"></i></span>';
                            }
                            else {
                                edit = '<span onclick="update_order(' + id + ');" title="Düzəliş et" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></span>';
                            }
                            @endif

                                switch (category_id) {
                                case '3': {
                                    //servis
                                    translation_brand = '';
                                    part = '';
                                }
                                    break;

                                case '4': {
                                    //mesref
                                    marka = '';
                                    defect = '';

                                }
                                    break;

                                case '5': {
                                    //inventar
                                    marka = '';
                                    defect = '';
                                }
                                    break;


                                case '7': {
                                    //forma
                                    var position_id = order['position_id'];
                                    var positions = response.positions;
                                    // var position = '';
                                    var k = 0;
                                    position = position + '<td><select id="position_id_edit_' + id + '" class="form-control input-sm">';
                                    for(k=0; k<positions.length; k++) {
                                        if (positions[k]['id'] == position_id) {
                                            position = position+ '<option selected value="' + positions[k]['id'] + '">' + positions[k]['position'] + '</option>';
                                        }
                                        else {
                                            position = position+ '<option value="' + positions[k]['id'] + '">' + positions[k]['position'] + '</option>';
                                        }
                                    }
                                    position = position + '</select></td>';

                                    marka = '';
                                    defect = '';
                                }
                                    break;

                                case '8': {
                                    //defterxana
                                    translation_brand = '';
                                    marka = '';
                                    defect = '';
                                }
                                    break;

                                case '9': {
                                    //blank
                                    translation_brand = '';
                                    marka = '';
                                    defect = '';
                                }
                                    break;
                            }

                            var color_style = 'style="background-color: #ECFBFB;"';
                            for (var k = 0; k<purchases.length; k++) {
                                if (id == purchases[k]['OrderID']) {
                                    color_style = '';
                                    send_director = '<span title="Düymə deaktivdir" class="btn btn-success btn-xs" style="background-color: red; border-color: red;"><i class="fa fa-eye"></i></span>';
                                    break;
                                }
                            }

                            if (order['status_id'] == 7) {
                                color_style = 'style="background-color: #F5A6A1;"';
                            }

                            var tr = '<tr ' + color_style + ' class="even pointer" id="row_' + order['id'] + '">';
                            tr = tr + '<td>' + count + '</td>'+ select_supply + '<td style="min-width: 130px;">' + send_director + check + '<span id="actions_' + id + '">' + edit + cancel + '</span>' + '</td>' + product + translation_brand + part + web_link + pcs + unit + marka + position + user_detail + status + remark + picture + defect;
                            tr = tr + '</tr>';
                            table = table + tr;
                        }

                        $('#orders_table').html(table);

                        $('#table_display').css('display', 'block');
                    }
                }
            });

            //add-form
            var category_id = cat_id;

            if (category_id === '') {
                $('#inputs').css('display', 'none');
                alert('Kateqoriya seçin...');
                return false;
            }

            var Product = '';
            var Translation_Brand = '';
            var Part = '';
            var WEB_link = '';
            var Pcs = '';
            var unit_id = '';
            var position_id = '';
            var vehicle_id = '';
            var Remark = '';
            var image = '';
            var deffect_doc = '';

                <?php
                if (Auth::user()->chief() == 1) {
                    $save_btn_colspan = 3;
                }
                else {
                    $save_btn_colspan = 2;
                }
                ?>

            var inputs = '<td colspan="{{$save_btn_colspan}}" id="add-btn-td"><center><button type="submit" id="add-btn" class="btn btn-success btn-xs"><i class="fa fa-save"></i></button></center></td>';

            switch (category_id) {
                case '1': {
                    //xususi texnika
                    Product = '<td colspan="{{$product_input_length}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
                    Translation_Brand = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Translation_Brand" placeholder="Tərcümə/Təyinat"></td>';
                    Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Part No"></td>';
                    WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                    Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                    unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                    @foreach($units as $unit)
                            @if($unit->id == 10)
                        unit_id = unit_id + '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @else
                        unit_id = unit_id + '<option value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @endif
                            @endforeach
                        unit_id = unit_id + '</select></td>';

                    vehicle_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    vehicle_id = vehicle_id + '<select class="form-control input-sm" name="vehicle_id">';
                    @foreach($vehicles as $vehicle)
                        vehicle_id = vehicle_id + '<option value="{{$vehicle->id}}">{{$vehicle->QN}} - {{$vehicle->Marka}} - {{$vehicle->Tipi}}</option>';
                    @endforeach
                        vehicle_id = vehicle_id + '</select></td>';

                    Remark = '<td id="orders-add-inputs" colspan="3" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                    deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                case '2': {
                    //xidmeti
                    Product = '<td colspan="{{$product_input_length}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
                    Translation_Brand = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Translation_Brand" placeholder="Tərcümə/Təyinat"></td>';
                    Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Part No"></td>';
                    WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                    Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                    unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                    @foreach($units as $unit)
                            @if($unit->id == 10)
                        unit_id = unit_id + '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @else
                        unit_id = unit_id + '<option value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @endif
                            @endforeach
                        unit_id = unit_id + '</select></td>';

                    vehicle_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    vehicle_id = vehicle_id + '<select class="form-control input-sm" name="vehicle_id">';
                    @foreach($vehicles as $vehicle)
                        vehicle_id = vehicle_id + '<option value="{{$vehicle->id}}">{{$vehicle->QN}} - {{$vehicle->Marka}} - {{$vehicle->Tipi}}</option>';
                    @endforeach
                        vehicle_id = vehicle_id + '</select></td>';

                    Remark = '<td id="orders-add-inputs" colspan="3" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                    deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                case '3': {
                    //servis
                    Product = '<td colspan="{{$product_input_length}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Görülən işin adı"></td>';
                    WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                    Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                    unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                    @foreach($units as $unit)
                            @if($unit->id == 10)
                        unit_id = unit_id + '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @else
                        unit_id = unit_id + '<option value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @endif
                            @endforeach
                        unit_id = unit_id + '</select></td>';

                    vehicle_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    vehicle_id = vehicle_id + '<select class="form-control input-sm" name="vehicle_id">';
                    @foreach($vehicles as $vehicle)
                        vehicle_id = vehicle_id + '<option value="{{$vehicle->id}}">{{$vehicle->QN}} - {{$vehicle->Marka}} - {{$vehicle->Tipi}}</option>';
                    @endforeach
                        vehicle_id = vehicle_id + '</select></td>';

                    Remark = '<td id="orders-add-inputs" colspan="3" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                    deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                case '4': {
                    //mesref
                    Product = '<td colspan="{{$product_input_length}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
                    Translation_Brand = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Translation_Brand" placeholder="Əlavə məlumat"></td>';
                    Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Markası"></td>';
                    WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                    Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                    unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                    @foreach($units as $unit)
                            @if($unit->id == 10)
                        unit_id = unit_id + '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @else
                        unit_id = unit_id + '<option value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @endif
                            @endforeach
                        unit_id = unit_id + '</select></td>';

                    Remark = '<td id="orders-add-inputs" colspan="3" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;

                }
                    break;

                case '5': {
                    //inventar
                    Product = '<td colspan="{{$product_input_length}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
                    Translation_Brand = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Translation_Brand" placeholder="Əlavə məlumat"></td>';
                    Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Markası"></td>';
                    WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                    Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                    unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                    @foreach($units as $unit)
                            @if($unit->id == 10)
                        unit_id = unit_id + '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @else
                        unit_id = unit_id + '<option value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @endif
                            @endforeach
                        unit_id = unit_id + '</select></td>';

                    Remark = '<td id="orders-add-inputs" colspan="3" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                case '6': {
                    //akkumlyator
                    Product = '<td colspan="{{$product_input_length}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
                    Translation_Brand = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Translation_Brand" placeholder="Əlavə məlumat"></td>';
                    Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Model"></td>';
                    WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                    Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                    unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                    @foreach($units as $unit)
                            @if($unit->id == 10)
                        unit_id = unit_id + '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @else
                        unit_id = unit_id + '<option value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @endif
                            @endforeach
                        unit_id = unit_id + '</select></td>';

                    vehicle_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    vehicle_id = vehicle_id + '<select class="form-control input-sm" name="vehicle_id">';
                    @foreach($vehicles as $vehicle)
                        vehicle_id = vehicle_id + '<option value="{{$vehicle->id}}">{{$vehicle->QN}} - {{$vehicle->Marka}} - {{$vehicle->Tipi}}</option>';
                    @endforeach
                        vehicle_id = vehicle_id + '</select></td>';

                    Remark = '<td id="orders-add-inputs" colspan="3" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                    deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                case '7': {
                    //forma
                    Product = '<td colspan="{{$product_input_length}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
                    Translation_Brand = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Translation_Brand" placeholder="Razmer"></td>';
                    Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Tip/Marka"></td>';
                    WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                    Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                    unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                    @foreach($units as $unit)
                            @if($unit->id == 10)
                        unit_id = unit_id + '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @else
                        unit_id = unit_id + '<option value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @endif
                            @endforeach
                        unit_id = unit_id + '</select></td>';

                    position_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    position_id = position_id + '<select class="form-control input-sm" name="position_id">';
                    @foreach($positions as $position)
                        position_id = position_id + '<option value="{{$position->id}}">{{$position->position}}</option>';
                    @endforeach
                        position_id = position_id + '</select></td>';

                    Remark = '<td id="orders-add-inputs" colspan="3" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + position_id + Remark + image + deffect_doc;
                }
                    break;

                case '8': {
                    //defterxana
                    Product = '<td colspan="{{$product_input_length}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Adı"></td>';
                    Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Tipi"></td>';
                    WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                    Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                    unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                    @foreach($units as $unit)
                            @if($unit->id == 10)
                        unit_id = unit_id + '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @else
                        unit_id = unit_id + '<option value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @endif
                            @endforeach
                        unit_id = unit_id + '</select></td>';

                    Remark = '<td id="orders-add-inputs" colspan="3" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                case '9': {
                    //blank
                    Product = '<td colspan="{{$product_input_length}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Adı"></td>';
                    Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Tipi"></td>';
                    WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                    Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                    unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                    @foreach($units as $unit)
                            @if($unit->id == 10)
                        unit_id = unit_id + '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @else
                        unit_id = unit_id + '<option value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @endif
                            @endforeach
                        unit_id = unit_id + '</select></td>';

                    Remark = '<td id="orders-add-inputs" colspan="3" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                case '10': {
                    //teker
                    Product = '<td colspan="{{$product_input_length}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Təkərin ölçüsü"></td>';
                    Translation_Brand = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Translation_Brand" placeholder="Əlavə məlumat"></td>';
                    Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Markası"></td>';
                    WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                    Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                    unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                    @foreach($units as $unit)
                            @if($unit->id == 10)
                        unit_id = unit_id + '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @else
                        unit_id = unit_id + '<option value="{{$unit->id}}">{{$unit->Unit}}</option>';
                    @endif
                            @endforeach
                        unit_id = unit_id + '</select></td>';

                    vehicle_id = '<td id="orders-add-inputs" style="width: 150px;">';
                    vehicle_id = vehicle_id + '<select class="form-control input-sm" name="vehicle_id">';
                    @foreach($vehicles as $vehicle)
                        vehicle_id = vehicle_id + '<option value="{{$vehicle->id}}">{{$vehicle->QN}} - {{$vehicle->Marka}} - {{$vehicle->Tipi}}</option>';
                    @endforeach
                        vehicle_id = vehicle_id + '</select></td>';

                    Remark = '<td id="orders-add-inputs" colspan="3" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                    deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                ////////////////////////////////
                default: {
                    alert('Kateqoriya tapılmadı!');
                }
            }

            $('#orders_input').html(inputs);
        };
    </script>

    <script>
        //add new order form
        function show_add_form() {
            $('.add-new-order-form').css('display', 'table-row');
            $('.btn-add-new-order').css('display', 'none');
            $('.btn-remove-new-order').css('display', 'block');
        }

        //remove new order form
        function remove_add_form() {
            $('.add-new-order-form').css('display', 'none');
            $('.btn-add-new-order').css('display', 'block');
            $('.btn-remove-new-order').css('display', 'none');
        }
    </script>

    <script>
        //remove order form
        function remove_order_form() {
            $('.add-new-order-form').css('display', 'none');
            $('.btn-add-new-order').css('display', 'block');
            $('.btn-remove-new-order').css('display', 'none');
        }
    </script>

    <script>
        function get_data(id, type) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'id': id,
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

                    if(type === 3) {
                        $('.image-form-modal').html('');
                        var remark = '';
                        remark = '<textarea class="form-control" id="Remark_edit_' + id + '" name="Remark">' + response.data + '</textarea>'
                        $('.remark-modal').html(remark);
                    }
                    else {
                        $('.remark-modal').html('');
                        var image = '';
                        image = image + response.data;
                        image = image + '{{csrf_field()}}';
                        image = image + '<input type="hidden" name="type" value="13">';
                        image = image + '<input type="hidden" name="id" value="' + id + '">';
                        image = image + '<input style="margin: 10px 0; width: 400px;" type="file" name="picture" class="form-control input-sm" placeholder="Image">';
                        image = image + '<button type="submit" class="btn btn-success">Şəkli dəyiş</button>';
                        $('.image-form-modal').html(image);
                    }

                    $('#add-modal').modal('show');
                }
            });
        }
    </script>

    <script>
        //delete alternative
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
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "Post",
                        url: '',
                        data: {
                            'id': id,
                            '_token': CSRF_TOKEN,
                            'type': 15
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
                                var elem = document.getElementById('alt_row_' + response.id);
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
                        //add alternative
                        if (response.type === 'add_alternative') {
                            //add new alternative
                            var now = new Date();
                            var day = ("0" + now.getDate()).slice(-2);
                            var month = ("0" + (now.getMonth() + 1)).slice(-2);
                            var today = now.getFullYear()+"-"+(month)+"-"+(day);
                            $('#date_input').val(today);

                            $('#brend_input').val('');
                            $('#model_input').val('');
                            $('#part_input').val('');
                            $('#cost_input').val('');
                            $('#total_cost_input').val('');
                            $('#remark_input').val('');
                            $('#company_input').val('');
                            $('#unit_input').val(10);
                            $('#currency_input').val(1);
                            $('#store_input').val('Yerli');
                            $('#country_input').val(15);
                            //

                            add_order_id(response.order_id);
                            var  i = 0;
                            var request = response.alts;
                            var count = '<span style="color: green;">New</span>';

                            // var remark = alternative['Remark'];
                            var alt_id = request['id'];
                            var brend = '<td>' + request['Brend'] + '</td>';
                            var model = '<td>' + request['Model'] + '</td>';
                            var part = '<td>' + request['PartSerialNo'] + '</td>';
                            var pcs = '<td>' + request['pcs'] + '</td>';
                            var unit = '<td>' + request['Unit'] + '</td>';
                            var cost = '<td>' + request['cost'] + '</td>';
                            var currency = '<td>' + request['currency'] + '</td>';
                            var date = '<td>' + request['date'] + '</td>';
                            var total_cost = '<td>' + request['total_cost'] + '</td>';
                            var store_type = '<td>' + request['store_type'] + '</td>';
                            var company = '<td>' + request['company'] + '</td>';
                            var country = '<td>' + request['country'] + '</td>';
                            var remark = '<td>' + request['Remark'] + '</td>';
                            var director_remark = '<td>' + 'null' + '</td>';

                            var image = '';
                            if(request['image'] !== null) {
                                image = '<td><span title="Şəkli göstər" onclick="get_alt_image(' + alt_id + ');" class="btn btn-success btn-xs alt-image-modal"><i class="fa fa-image"></i></span></td>';
                            }
                            else {
                                image = '<td><span style="background-color: #ffac27; border-color: #ffac27;" title="Şəkil yoxdur" disabled="true" class="btn btn-success btn-xs"><i class="fa fa-image"></i></span></td>';
                            }

                            var del_btn = '';

                            if (request['confirm_chief'] === 0) {
                                del_btn = '<td id="del_alt_btn_' + alt_id + '"><span onclick="del_alt(' + alt_id + ');" title="Sil" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></span></td>';
                            }
                            else {
                                del_btn = '<td><span disabled="true" title="Düymə deaktivdir" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></span></td>';
                            }

                            var tr = '<tr class="even pointer" id="alt_row_' + alt_id + '">';
                            tr = tr + '<td>' + count + '</td><td></td>' +del_btn + brend + model + part + pcs + unit + cost + currency + date + total_cost + store_type + company + country + image + remark + director_remark;
                            tr = tr + '</tr>';

                            $('#alts_table').append(tr);

                            $('#status_'+response.order_id).html('Alternativ yaradılıb').css('color', 'green');
                        }

                        //add order
                        if (response.type == 'add_order') {
                            change_category(response.category_id);
                        }

                        //update order image
                        if(response.type === 'update_order_image') {
                            $('#add-modal').modal('hide');
                        }
                    }
                }
            });
        });
    </script>

    <script>
        function add_order_id(id) {
            $('#order_id_for_alternative').html("<input type='hidden' name='OrderID' value='" + id + "'>");
        }
    </script>

    {{--total-cost--}}
    <script>
        function total_cost() {
            var cost = $('#cost_input').val();
            var pcs = $('#pcs_cost_input').val();

            var total_cost = 0;
            total_cost = cost * pcs;

            $('#total_cost_input').val(total_cost);
        }
    </script>

    {{--show alternative--}}
    <script>
        function show_alternative(order_id, pcs, unit) {
            //update inputs value
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear()+"-"+(month)+"-"+(day);
            $('#date_input').val(today);
            $('#pcs_cost_input').val(pcs);
            $('#unit_input').val(unit);
            $('#brend_input').val('');
            $('#model_input').val('');
            $('#part_input').val('');
            $('#cost_input').val('');
            $('#total_cost_input').val('');
            $('#remark_input').val('');
            $('#company_input').val('');
            $('#image_input').val('');
            $('#currency_input').val(1);
            $('#store_input').val('Yerli');
            $('#country_input').val(15);

            $('#order_id_for_alternative').html("<input type='hidden' name='OrderID' value='" + order_id + "'>");

            $('#alt-brend').html('');
            $('#alt-model').html('');
            $('#alt-part').html('');
            $('#alt-date').html('');
            $('#alt-cost').html('');
            $('#alt-cur').html('');
            $('#alt-total-cost').html('');
            $('#alt-pcs').html('');
            $('#alt-unit').html('');
            $('#alt-firma').html('');
            $('#alt-remark').html('');
            $('#alt-director-remark').html('');
            $('#alt-country').html('');

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'order_id': order_id,
                    '_token': CSRF_TOKEN,
                    'type': 8
                },
                success: function (response) {
                    swal(
                        response.title,
                        response.content,
                        response.case
                    );
                    if (response.case === 'success') {
                        swal.close();

                        var order_details = '';
                        var order = response.order;
                        
                        if (order['Product'] !== null)  {
                            order_details += order['Product'] + ' , ';
                        }
                        if (order['Translation_Brand'] !== null)  {
                            order_details += order['Translation_Brand'] + ' , ';
                        }
                        if (order['Part'] !== null)  {
                            order_details += order['Part'] + ' , ';
                        }

                        order_details = order_details.substr(0, order_details.length-3);
                        
                        $('#order_details').html(order_details);

                        var alternatives = response.alternatives;
                        var table = '';
                        var i = 0;
                        var count = 0;
                        var confirm_btn = '';
                        var suggestion_btn = '';

                        for (i = 0; i < alternatives.length; i++) {
                            var alternative = alternatives[i];
                            count++;

                            // var remark = alternative['Remark'];
                            @if(Auth::user()->chief() == 1)
                                if (alternative['confirm_chief'] == 0) {
                                    confirm_btn = '<span onclick="confirm_alternative(' + alternative['id'] + ');" title="Təsdiqlə" class="btn btn-success btn-xs"><i class="fa fa-check"></i></span>';
                                }
                                else {
                                    confirm_btn = '<i title"Təsdiq edilib" style="color: green;" class="fa fa-check"></i>';
                                }

                                if (alternative['suggestion'] == 1) {
                                    suggestion_btn = '<span disabled="true" title="Tövsiyyə olunub" class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i></span>';
                                }
                                else {
                                    suggestion_btn = '<span onclick="suggestion_alternative(' + alternative['id'] + ');" title="Tövsiyyə et" class="btn btn-primary btn-xs"><i class="fa fa-check-circle"></i></span>';
                                }
                            @endif

                            var alt_id = alternative['id'];
                            var brend = '<td>' + alternative['Brend'] + '</td>';
                            var model = '<td>' + alternative['Model'] + '</td>';
                            var part = '<td>' + alternative['PartSerialNo'] + '</td>';
                            var pcs = '<td>' + alternative['pcs'] + '</td>';
                            var unit = '<td>' + alternative['Unit'] + '</td>';
                            var cost = '<td>' + alternative['cost'] + '</td>';
                            var currency = '<td>' + alternative['currency'] + '</td>';
                            var date = '<td>' + alternative['date'] + '</td>';
                            var total_cost = '<td>' + alternative['total_cost'] + '</td>';
                            var store_type = '<td>' + alternative['store_type'] + '</td>';
                            var company = '<td>' + alternative['company'] + '</td>';
                            var country = '<td>' + alternative['country'] + '</td>';
                            var remark = '<td>' + alternative['Remark'] + '</td>';
                            var director_remark = '<td>' + alternative['DirectorRemark'] + '</td>';
                            var image = '';

                            if(alternative['image'] !== null) {
                                image = '<td><span title="Şəkli göstər" onclick="get_alt_image(' + alt_id + ');" class="btn btn-success btn-xs alt-image-modal"><i class="fa fa-image"></i></span></td>';
                            }
                            else {
                                image = '<td><span style="background-color: #ffac27; border-color: #ffac27;" title="Şəkil yoxdur" disabled="true" class="btn btn-success btn-xs"><i class="fa fa-image"></i></span></td>';
                            }

                            var del_btn = '';
                            if (alternative['confirm_chief'] === 0) {
                                del_btn = '<td id="del_alt_btn_' + alt_id + '"><span onclick="del_alt(' + alt_id + ');" title="Sil" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></span></td>';
                            }
                            else {
                                del_btn = '<td><span disabled="true" title="Düymə deaktivdir" class="btn btn-warning btn-xs"><i class="fa fa-trash"></i></span></td>';
                            }

                            var tr = '<tr class="even pointer" id="alt_row_' + alt_id + '">';
                            tr = tr + '<td>' + count + '</td><td style="min-width: 80px;"><span id="confirm_alternative_tr_' + alternative['id'] + '">' + confirm_btn + '</span><span id="suggestion_alternative_tr_' + alternative['id'] + '">' + suggestion_btn + '</span></td>' + del_btn + brend + model + part + pcs + unit + cost + currency + date + total_cost + store_type + company + country + image + remark + director_remark;
                            tr = tr + '</tr>';
                            table = table + tr;
                        }

                        $('#alts_table').html(table);

                        $('#show-alternative-modal').modal('show');
                    }
                }
            });
        }

        function get_alt_image(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'id': id,
                    '_token': CSRF_TOKEN,
                    'type': 14
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

                    $('.alt-image').html(response.data);

                    $('#alt-image').modal('show');
                }
            });
        }

        // $(document).on('click', '.alt-image-modal', function() {
        //     $('#alt-image').modal('show');
        // });
    </script>

    @if(Auth::user()->chief() == 1)
        <script>
            //confirm alternative
            function confirm_alternative(alt_id) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "Post",
                    url: '',
                    data: {
                        'id': alt_id,
                        '_token': CSRF_TOKEN,
                        'type': 10
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
                        swal.close();

                        $('#confirm_alternative_tr_'+alt_id).html('<i title"Təsdiq edilib" style="color: green;" class="fa fa-check"></i>');
                        $('#del_alt_btn_'+alt_id).html('<span disabled="true" title="Düymə deaktivdir" class="btn btn-warning btn-xs"><i class="fa fa-trash"></i></span>');
                    }
                });
            }
        </script>

        {{--select supply for order--}}
        <script>
            function select_supply(order_id) {
                $('#order_id_for_select_supply').html('<input type="hidden" name="order_id" value="' + order_id + '">');
            }
        </script>

        <script type="text/javascript">
            //select-supply-modal
            $(document).on('click', '.select-supply-modal', function () {
                $('#select-supply-modal').modal('show');
            });
        </script>

        <script>
            //confirm order for chief
            function confirm_order(order_id) {
                console.log('func');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var cat_id = $('#cat_id_for_select_suplly').val();

                $.ajax({
                    type: "Post",
                    url: '',
                    data: {
                        '_token': CSRF_TOKEN,
                        'order_id': order_id,
                        'type': 11,
                        'cat_id': cat_id
                    },
                    beforeSubmit: function () {
                        //loading
                        swal({
                            title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Gözləyin...</span>',
                            text: 'Xahiş olunur gözləyin..',
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
                            change_category(response.cat_id);
                        }
                    }
                });
            }
        </script>
    @endif

    <script>
        function update_order(id) {
            //update order
            swal({
                title: 'Dəyişiklik etmək istədiyinizə əminsiniz?',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Geri',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Bəli!'
            }).then(function (result) {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    var product = $('#product_edit_'+id).val();
                    var translation_brand = $('#translation_brand_edit_'+id).val();
                    var part = $('#part_edit_'+id).val();
                    var pcs = $('#pcs_edit_'+id).val();
                    var unit_id = $('#unit_id_edit_'+id).val();
                    var WEB_link = $('#WEB_link_edit_'+id).val();
                    var Remark = $('#Remark_edit_'+id).val();
                    // var picture = $('#picture_edit_'+id).val();

                    $.ajax({
                        type: "Post",
                        url: '',
                        data: {
                            'id': id,
                            '_token': CSRF_TOKEN,
                            'type': 12,
                            'Product': product,
                            'Translation_Brand': translation_brand,
                            'Part': part,
                            'Pcs': pcs,
                            'unit_id': unit_id,
                            'WEB_link': WEB_link,
                            'Remark': Remark,
                            // 'picture': picture
                        },
                        beforeSubmit: function () {
                            //loading
                            swal({
                                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                                text: 'Xahiş olunur gözləyin..',
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
                                //success
                            }
                        }
                    });
                } else {
                    return false;
                }
            });
        }
    </script>

    <script>
        function suggestion_alternative(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'id': id,
                    '_token': CSRF_TOKEN,
                    'type': 16
                },
                beforeSubmit: function () {
                    //loading
                    swal({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Gözləyin...</span>',
                        text: 'Yüklənir, lütfən gözləyin..',
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
                        $('#suggestion_alternative_tr_'+response.id).html('<span disabled="true" title="Tövsiyyə olunub" class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i></span>');
                    }
                }
            });
        }
    </script>

    <script>
        function del(e, id) {
            //cancel order
            swal({
                title: 'Sifarişi geri göndərmək istədiyinizdən əminsiniz?',
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
                            'id': id,
                            '_token': CSRF_TOKEN,
                            'type': 1
                        },
                        beforeSubmit: function () {
                            //loading
                            swal({
                                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Gözləyin...</span>',
                                text: 'Yüklənir, lütfən gözləyin..',
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
                                $('#status_'+response.id).html('İstifadəçiyə geri göndərildi');
                                $('#status_'+response.id).css('color', 'red');
                                $('#cancel_btn_'+response.id).remove();
                            }
                        }
                    });
                } else {
                    return false;
                }
            });
        }
    </script>

    {{--<script type="text/javascript">--}}
        {{--//add modal--}}
        {{--$(document).on('click', '.add-modal', function () {--}}
            {{--$('#add-modal').modal('show');--}}
        {{--});--}}
    {{--</script>--}}

    {{--<script type="text/javascript">--}}
        {{--//show-alternative-modal--}}
        {{--$(document).on('click', '.show-alternative-modal', function () {--}}
            {{--$('#show-alternative-modal').modal('show');--}}
        {{--});--}}
    {{--</script>--}}
@endsection