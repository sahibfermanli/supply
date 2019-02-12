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
                          <ul class="nav child_menu show-categories">
                              @foreach($categories as $category)
                                  <li class="cat-li cat-li-mobile"><a style="color: black;" class="cat-select" href="#" cat_id="{{$category->id}}">{{$category->process}}</a></li>
                              @endforeach
                          </ul>
                        </div>
                        <div class="x_content tables-mobile" id="table_display">
                            <div class="table-responsive">
                                <form action="" method="post">
                                    <input type="hidden" name="type" value="5">
                                    <div id="add_to_form_category_id"></div>
                                    {{csrf_field()}}
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr class="jsgrid-filter-row add-new-order-form" id="orders_input" style="display: none;">

                                        </tr>
                                        <tr class="headings">
                                            <th class="column-title">#</th>
                                            <th class="column-title">Təsdiq</th>
                                            <th class="column-title" style="min-width: 80px;">Düzəliş</th>
                                            <th class="column-title">Sifarişçi</th>
                                            <th class="column-title">Tarix</th>
                                            <th class="column-title" id="Product_th">Malın adı</th>
                                            <th class="column-title" id="Translation_Brand_th">Tərcümə/Təyinat</th>
                                            <th class="column-title" id="Part_th">Part No</th>
                                            <th class="column-title" id="WEB_link_th">WEB link</th>
                                            <th class="column-title" id="Pcs_th">Miqdar</th>
                                            <th class="column-title" style="min-width: 100px;" id="unit_th">Ölçü vahidi</th>
                                            <th class="column-title" id="vehicle_th">Qaraj No</th>
                                            <th class="column-title" id="position_th">Vəzifə</th>
                                            <th class="column-title" id="Status_th">Status</th>
                                            <th class="column-title" id="Remark_th">Qeyd</th>
                                            <th class="column-title" id="Image_th">Şəkil</th>
                                            <th class="column-title" id="Defect_th">Qüsur aktı</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>
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

    <!-- start add modal-->
    <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    <!-- /.end add modal-->
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

    {{--form submit--}}
    <script>
        var remark_value = '';

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
                        if (response.type == 'add_order') {
                          //$('.add-new-order-form').css('display', 'none');
                          //$('.btn-add-new-order').css('display', 'block');

                          change_category(response.category_id);
                        }
                    }
                }
            });
        });
    </script>

    {{--alert--}}
    <script>
        function del(e, id) {
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

    <script>
        $(document).ready(function () {
            $('.show-categories').css('display', 'block');
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

    <script>
      //change category function
      function change_category(elem) {

        var cat_id = elem;

        $('#add_to_form_category_id').html('<input type="hidden" name="category_id" value="' + cat_id + '">');

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "Post",
            url: '',
            data: {
                'cat_id': cat_id,
                '_token': CSRF_TOKEN,
                'type': 2
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
                        alert('Please, select category...');
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
                            $('#Defect_th').css('display', 'table-cell');
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

                    var table = '';
                    var orders = response.orders;
                    var i = 0;
                    var count = 0;
                    var position = '';
                    var check = '';

                    for (i=0; i< orders.length; i++) {
                        count++;

                        var order = orders[i];
                        var id = order['id'];

                        var user = '<td style="text-transform: capitalize;">' + order['user_name'] + ' ' + order['user_surname'] + '</td>';
                        if (order['status_id'] == 9 || order['confirmed'] == 1) {
                          var edit = '<span disabled title="Düymə deaktivdir" class="btn btn-warning btn-xs"><i class="fa fa-exclamation-circle"></i></span>';
                          var cancel = '<span disabled title="Düymə deaktivdir" class="btn btn-danger btn-xs"><i class="fa fa-exclamation-circle"></i></span>';
                          if (order['status_id'] === 9) {
                              check = '<td title="' + order['confirmed_at'] + '"><center><i style="color: red;" class="fa fa-times"></i></center></td>';
                          }
                          else {
                              check = '<td title="' + order['confirmed_at'] + '"><span>' + order['chief_name'].substr(0,1) + '.' + order['chief_surname'] + '</span></td>';
                          }
                        }
                        else {
                          var edit = '<span onclick="update_order(' + id + ');" title="Düzəliş et" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></span>';
                          var cancel = '<span id="cancel_btn_' + id + '" onclick="del(this, ' + id + ');" title="Geri çevir" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></span>';
                          check = '<td id="check_' + id + '"><span class="btn btn-success btn-xs" onclick="confirm_order(' + id + ');"><i class="fa fa-check"></i></span></td>';
                        }
                        var product = '<td>' + '<input id="product_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" title="' + order['Product'] + '" value="' + order['Product'] + '">' + '</td>';
                        var translation_brand = '<td>' + '<input id="translation_brand_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" title="' + order['Translation_Brand'] + '" value="' + order['Translation_Brand'] + '">' + '</td>';
                        var part = '<td>' + '<input id="part_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" title="' + order['Part'] + '" value="' + order['Part'] + '">' + '</td>';
                        var first_pcs = order['Pcs'];
                        if ((first_pcs - parseInt(first_pcs)) > 0) {
                          var last_pcs = first_pcs;
                        }
                        else {
                          var last_pcs = parseInt(first_pcs);
                        }
                        var pcs = '<td>' + '<input id="pcs_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" value="' + last_pcs + '">' + '</td>';
                        // var unit = '<td>' + '<input id="unit_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" name="Unit" value="' + order['Unit'] + '">' + '</td>';

                        var unit_id = order['unit_id'];
                        var units = response.units;
                        var unit = '';
                        var j = 0;
                        unit = unit + '<td><select id="unit_id_edit_' + id + '" class="form-control input-sm">';
                        for(j=0; j<units.length; j++) {
                          if (units[j]['id'] == unit_id) {
                            unit = unit+ '<option selected value="' + units[j]['id'] + '">' + units[j]['Unit'] + '</option>';
                          }
                          else {
                            unit = unit+ '<option value="' + units[j]['id'] + '">' + units[j]['Unit'] + '</option>';
                          }
                        }
                        unit = unit + '</select></td>';

                        var marka = '<td>' + order['Marka'] + ' - ' + order['QN'] + ' - ' + order['Tipi'] + '</td>';

                        if(order['WEB_link'] == null) {
                            var web_link ='<td><span disabled="true"><i class="fa fa-link"></i></span></td>';
                        }
                        else {
                            var web_link ='<td><a target="_blank" href="' + order['WEB_link'] + '"><i class="fa fa-link"></i></a></td>';
                        }

                        var remark = '<td><center><span title="Qeydi göstər" onclick="get_data(' + id + ', 3);" class="btn btn-success btn-xs add-modal"><i class="fa fa-eye"></i></span></center></td>';

                        if (order['image'] == null) {
                            var picture = '<td><center><span disabled="true" title="Şəkli göstər" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></span></center></td>';
                        }
                        else{
                            var picture = '<td><center><span title="Şəkli göstər" onclick="get_data(' + id + ', 4);" class="btn btn-success btn-xs add-modal"><i class="fa fa-eye"></i></span></center></td>';
                        }

                        if (order['deffect_doc'] == null) {
                            var defect = '<td><center><span disabled="true" title="Xəta sənədini endir" class="btn btn-success btn-xs"><i class="fa fa-download"></i></span></center></td>';
                        }
                        else{
                            var defect = '<td><center><a title="Xəta sənədini endir" href="' + order['deffect_doc'] + '" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-download"></i></a></center></td>';
                        }

                        var status = '<td><span id="status_' + id + '" class="btn btn-xs" style="color: ' + order['color'] + ';">' + order['status'] + '</span></td>';

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
                                // defect = '';

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
                                position = '<td>' + order['position'] + '</td>';
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

                        var date = '<td>' + order['created_at'].substr(0, 10) + '</td>';

                        var tr = '<tr class="even pointer" id="row_' + order['id'] + '">';
                        tr = tr + '<td>' + id + '</td>' + check + '<td id="actions_' + id + '"><center>' + edit + cancel + '</center></td>' + user + date + product + translation_brand + part + web_link + pcs + unit + marka + position + status + remark + picture + defect;
                        tr = tr + '</tr>';
                        table = table + tr;
                    }

                    $('#orders_table').html(table);

                    $( "input" ).keypress(function() {
                        if (this.value.length < 20) {
                            this.style.width = 20 + "ch";
                        }
                        else {
                            this.style.width = this.value.length + "ch";
                        }
                    });

                    $('#table_display').css('display', 'block');
                }
            }
        });

        //add-form

        var category_id = cat_id;

        if (category_id === '') {
            $('#inputs').css('display', 'none');
            alert('Please, select category...');
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

        @php($product_colspan = 3)

        var inputs = '<td colspan="3" id="add-btn-td"><center><button type="submit" id="add-btn" class="btn btn-success btn-xs"><i class="fa fa-save"></i></button></center></td>';

        switch (category_id) {
            case '1': {
                //xususi texnika
                Product = '<td colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
                Translation_Brand = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Translation_Brand" placeholder="Tərcümə/Təyinat"></td>';
                Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Part No"></td>';
                WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                @foreach($units as $unit)
                        @if($unit->id == 10)
                    unit_id = unit_id+ '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
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

                Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Qeyd"></td>';
                image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
            }
                break;

            case '2': {
                //xidmeti
                Product = '<td colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
                Translation_Brand = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Translation_Brand" placeholder="Tərcümə/Təyinat"></td>';
                Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Part No"></td>';
                WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                @foreach($units as $unit)
                        @if($unit->id == 10)
                    unit_id = unit_id+ '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
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

                Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Qeyd"></td>';
                image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
            }
                break;

            case '3': {
                //servis
                Product = '<td colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Görülən işin adı"></td>';
                WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                @foreach($units as $unit)
                        @if($unit->id == 10)
                    unit_id = unit_id+ '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
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

                Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Qeyd"></td>';
                image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
            }
                break;

            case '4': {
                //mesref
                Product = '<td colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
                Translation_Brand = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Translation_Brand" placeholder="Əlavə məlumat"></td>';
                Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Markası"></td>';
                WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                @foreach($units as $unit)
                        @if($unit->id == 10)
                    unit_id = unit_id+ '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
                @else
                    unit_id = unit_id + '<option value="{{$unit->id}}">{{$unit->Unit}}</option>';
                @endif
                        @endforeach
                    unit_id = unit_id + '</select></td>';

                Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Qeyd"></td>';
                image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;

            }
                break;

            case '5': {
                //inventar
                Product = '<td colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
                Translation_Brand = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Translation_Brand" placeholder="Əlavə məlumat"></td>';
                Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Markası"></td>';
                WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                @foreach($units as $unit)
                        @if($unit->id == 10)
                    unit_id = unit_id+ '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
                @else
                    unit_id = unit_id + '<option value="{{$unit->id}}">{{$unit->Unit}}</option>';
                @endif
                        @endforeach
                    unit_id = unit_id + '</select></td>';

                Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Qeyd"></td>';
                image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';

                inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
            }
                break;

            case '6': {
                //akkumlyator
                Product = '<td colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
                Translation_Brand = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Translation_Brand" placeholder="Əlavə məlumat"></td>';
                Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Model"></td>';
                WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                @foreach($units as $unit)
                        @if($unit->id == 10)
                    unit_id = unit_id+ '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
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

                Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Qeyd"></td>';
                image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
            }
                break;

            case '7': {
                //forma
                Product = '<td colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
                Translation_Brand = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Translation_Brand" placeholder="Razmer"></td>';
                Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Tip/Marka"></td>';
                WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                @foreach($units as $unit)
                        @if($unit->id == 10)
                    unit_id = unit_id+ '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
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

                Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Qeyd"></td>';
                image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';

                inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + position_id + Remark + image + deffect_doc;
            }
                break;

            case '8': {
                //defterxana
                Product = '<td colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Adı"></td>';
                Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Tipi"></td>';
                WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                @foreach($units as $unit)
                        @if($unit->id == 10)
                    unit_id = unit_id+ '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
                @else
                    unit_id = unit_id + '<option value="{{$unit->id}}">{{$unit->Unit}}</option>';
                @endif
                        @endforeach
                    unit_id = unit_id + '</select></td>';

                Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Qeyd"></td>';
                image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';

                inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
            }
                break;

            case '9': {
                //blank
                Product = '<td colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Adı"></td>';
                Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Tipi"></td>';
                WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                @foreach($units as $unit)
                        @if($unit->id == 10)
                    unit_id = unit_id+ '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
                @else
                    unit_id = unit_id + '<option value="{{$unit->id}}">{{$unit->Unit}}</option>';
                @endif
                        @endforeach
                    unit_id = unit_id + '</select></td>';

                Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Qeyd"></td>';
                image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';

                inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
            }
                break;

            case '10': {
                //teker
                Product = '<td colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Təkərin ölçüsü"></td>';
                Translation_Brand = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Translation_Brand" placeholder="Əlavə məlumat"></td>';
                Part = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Part" placeholder="Markası"></td>';
                WEB_link = '<td id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="WEB_link" placeholder="WEB link"></td>';
                Pcs = '<td id="orders-add-inputs" style="width: 150px;"><input type="number" class="form-control input-sm" name="Pcs" placeholder="Miqdarı"></td>';

                unit_id = '<td id="orders-add-inputs" style="width: 150px;">';
                unit_id = unit_id + '<select class="form-control input-sm" name="unit_id">';
                @foreach($units as $unit)
                        @if($unit->id == 10)
                    unit_id = unit_id+ '<option selected value="{{$unit->id}}">{{$unit->Unit}}</option>';
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

                Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Qeyd"></td>';
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
      }
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
        //confirm order for chief
        function confirm_order(order_id) {
            console.log('func');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: "Post",
                url: '',
                data: {
                    '_token': CSRF_TOKEN,
                    'order_id': order_id,
                    'type': 7
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

                        $('#status_'+response.order_id).html('Təsdiqləndi');
                        $('#status_'+response.order_id).css('color', 'green');

                        var new_edit = '<span disabled title="Düymə deaktivdir" class="btn btn-warning btn-xs"><i class="fa fa-exclamation-circle"></i></span>';
                        var new_cancel = '<span disabled title="Düymə deaktivdir" class="btn btn-danger btn-xs"><i class="fa fa-exclamation-circle"></i></span>';

                        $('#actions_'+response.order_id).html('<center>' + new_edit + new_cancel + '</center>');

                        var chief_name = '{{Auth::user()->name}}';
                        var chief_surname = '{{Auth::user()->surname}}';
                        var new_check = chief_name.substr(0,1) + '.' + chief_surname;
                        $('#check_'+response.order_id).html(new_check);
                    }
                }
            });
        }
    </script>

    <script>
      function update_order(id) {
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

                $.ajax({
                    type: "Post",
                    url: '',
                    data: {
                        'id': id,
                        '_token': CSRF_TOKEN,
                        'type': 6,
                        'Product': product,
                        'Translation_Brand': translation_brand,
                        'Part': part,
                        'Pcs': pcs,
                        'unit_id': unit_id
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

                    remark_value = response.remark;

                    $('.get-data').html(response.data);

                    $('#add-modal').modal('show');
                }
            });
        }

        function edit_remark(id) {
            var input = '';
            var button = '';

            input = '<textarea style="resize: vertical;" class="form-control" id="remark-input">' + remark_value + '</textarea>';

            button = '<button class="btn btn-success" onclick="update_remark(' + id + ');">Təsdiq et</button>';

            $('#remark-span').html(input);
            $('#remark-btn').html(button);
        }

        function update_remark(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var remark = $('#remark-input').val();
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'id': id,
                    'remark': remark,
                    '_token': CSRF_TOKEN,
                    'type': 'update_remark'
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
                        $('#add-modal').modal('hide');
                        change_category(category_id);
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
