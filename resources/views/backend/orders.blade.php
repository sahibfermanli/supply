@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Sifarişlər</h3>
                    <span class="btn btn-success btn-mobile" style="display: none;">Kategoriyalar</span>
                    <button type="button" onclick="show_add_form();" class="btn btn-success btn-add-new-order"
                            style="float: right; display: none;"><i class="fa fa-plus"></i></button>
                    <button type="button" onclick="remove_add_form();" class="btn btn-success btn-remove-new-order"
                            style="float: right; display: none;"><i class="fa fa-minus"></i></button>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div id="search-inputs-area" class="search-areas">
                                <input type="text" class="form-control search-input" id="product_search"
                                       placeholder="Malın adı">
                                <select class="form-control search-input" id="vehicle_search">
                                    <option value="">Texnika</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{$vehicle->id}}">{{$vehicle->QN}} - {{$vehicle->Marka}}
                                            - {{$vehicle->Tipi}}</option>
                                    @endforeach
                                </select>
                                <select class="form-control search-input" id="status_search">
                                    <option value="">Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{$status->id}}">{{$status->status}}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-primary" onclick="search_data();">Axtar</button>
                            </div>
                            <div id="search-type-area" class="search-areas">
                                <label for="date_search">Tarix aralığı</label>
                                <input type="checkbox" id="date_search" placeholder="max" onclick="date_area();">
                            </div>
                            <div id="search-date-area" class="search-areas">
                                <label for="start_date">Hardan</label>
                                <input type="date" id="start_date_search" class="form-control search-input">
                                <label for="end_date">Hara</label>
                                <input type="date" id="end_date_search" class="form-control search-input">
                            </div>
                        </div>
                    </div>
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
                                    <li class="cat-li cat-li-mobile"><a style="color: black;" class="cat-select"
                                                                        href="#"
                                                                        cat_id="{{$category->id}}">{{$category->process}}</a>
                                    </li>
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
                                        <tr class="jsgrid-filter-row add-new-order-form" id="orders_input"
                                            style="display: none;">

                                        </tr>
                                        <tr class="headings">
                                            <th class="column-title">#</th>
                                            <th class="column-title" style="min-width: 80px;">Düzəliş</th>
                                            <th class="column-title">Sifarişçi</th>
                                            <th class="column-title">Tarix</th>
                                            <th class="column-title" id="Product_th">Malın adı</th>
                                            <th class="column-title" id="Translation_Brand_th">Tərcümə/Təyinat</th>
                                            <th class="column-title" id="Part_th">Part No</th>
                                            <th class="column-title" id="WEB_link_th">WEB link</th>
                                            <th class="column-title" id="Pcs_th">Miqdar</th>
                                            <th class="column-title" style="min-width: 100px;" id="unit_th">Ölçü
                                                vahidi
                                            </th>
                                            <th class="column-title" id="vehicle_th">Qaraj No</th>
                                            <th class="column-title" id="position_th">Vəzifə</th>
                                            <th class="column-title" id="Status_th">Status</th>
                                            <th class="column-title" id="Remark_th">Sifariş səbəbi</th>
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
                    <div class="get-data">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.end add modal-->

    {{--status modal--}}
    <div class="modal fade" id="status-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
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
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">

    <style>
        #table_display {
            display: none;
        }

        #vehicle_th {
            min-width: 150px;
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

        var cat_id = 0;
        var product_search = '';
        var vehicle_search = '';
        var status_search = '';
        var start_date_search = '';
        var end_date_search = '';

        //search start
        var show_date_area = false;

        function date_area() {
            if (show_date_area) {
                show_date_area = false;
                $('#search-date-area').css('display', 'none');
            } else {
                show_date_area = true;
                $('#search-date-area').css('display', 'block');
            }
        }

        function search_data() {
            product_search = $('#product_search').val();
            vehicle_search = $('#vehicle_search').val();
            status_search = $('#status_search').val();
            start_date_search = $('#start_date_search').val();
            end_date_search = $('#end_date_search').val();

            change_category(cat_id);
        }

        //search end

        //show status
        function show_status(order_id) {
            swal({
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
                        for (i = 0; i < statuses.length; i++) {
                            status_arr = statuses[i];

                            no = i + 1;
                            status = status_arr['status'];
                            color = status_arr['status_color'];
                            date = status_arr['status_date'];

                            tr = '<tr><td>' + no + '</td><td style="color: ' + color + ';">' + status + '</td><td>' + date + '</td></tr>';
                            table = table + tr;
                        }

                        $('#status_title').html('Statuslar');
                        $('#status_table').html(table);
                        $('#status-modal').modal('show');
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

        $(document).ready(function () {
            $('form').validate();
            $('form').ajaxForm({
                beforeSubmit: function () {
                    //loading
                    swal({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Əməliyyat aparılır...</span>',
                        text: 'Əməliyyat aparılır, xaiş olunur gözləyin...',
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
                        if (response.type == 'add_order') {
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
                title: 'Sifarişi silmək istədiyinizdən əminsiniz?',
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
                        text: 'Gözləyin, əməliyyat aparılır...',
                        showConfirmButton: false
                    });
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "Post",
                        url: '',
                        data: {
                            'id': id,
                            '_token': CSRF_TOKEN,
                            'type': 1
                        },
                        success: function (response) {
                            swal.close();
                            swal(
                                response.title,
                                response.content,
                                response.case
                            );
                            if (response.case === 'success') {
                                $('#row_' + response.id).remove();
                                //deyis cancel burda delete olacaq (rehber raportlasdirmiyibsa)
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

            cat_id = $(this).attr('cat_id');

            product_search = '';
            vehicle_search = '';
            status_search = '';
            start_date_search = '';
            end_date_search = '';

            $('#product_search').val('');
            $('#vehicle_search').val('');
            $('#status_search').val('');
            $('#start_date_search').val('');
            $('#end_date_search').val('');

            change_category(cat_id);
        });
    </script>

    <script>
        //change category function
        function change_category(elem) {

            cat_id = elem;

            $('#add_to_form_category_id').html('<input type="hidden" name="category_id" value="' + cat_id + '">');

            swal({
                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Əməliyyat aparılır...</span>',
                text: 'Əməliyyat aparılır, xaiş olunur gözləyin...',
                showConfirmButton: false
            });

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'cat_id': cat_id,
                    '_token': CSRF_TOKEN,
                    'type': 2,
                    //search data
                    'product': product_search,
                    'vehicle': vehicle_search,
                    'status': status_search,
                    'start_date': start_date_search,
                    'end_date': end_date_search
                },
                success: function (response) {
                    swal.close();
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

                            case '11': {
                                //zemanetler
                                $('#Product_th').html('Adı');
                                $('#Translation_Brand_th').html('Əlavə məlumat');
                                $('#Part_th').html('Markası');
                                $('#vehicle_th').css('display', 'none');
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

                        for (i = 0; i < orders.length; i++) {
                            count++;
                            var order = orders[i];
                            var id = order['id'];

                            if (order['confirmed'] == 1) {
                                var edit = '<span disabled title="Düymə deaktivdir" class="btn btn-warning btn-xs"><i class="fa fa-exclamation-circle"></i></span>';
                                var cancel = '<span disabled title="Düymə deaktivdir" class="btn btn-danger btn-xs"><i class="fa fa-exclamation-circle"></i></span>';
                            } else {
                                var edit = '<span onclick="update_order(' + id + ');" title="Düzəliş et" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></span>';
                                var cancel = '<span id="cancel_btn_' + id + '" onclick="del(this, ' + id + ');" title="Sil" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></span>';
                            }
                            var product = '<td>' + '<input id="product_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" title="' + order['Product'] + '" value="' + order['Product'] + '">' + '</td>';
                            var translation_brand = '<td>' + '<input id="translation_brand_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" title="' + order['Translation_Brand'] + '" value="' + order['Translation_Brand'] + '">' + '</td>';
                            var part = '<td>' + '<input id="part_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" title="' + order['Part'] + '" value="' + order['Part'] + '">' + '</td>';
                            var first_pcs = order['Pcs'];
                            if ((first_pcs - parseInt(first_pcs)) > 0) {
                                var last_pcs = first_pcs;
                            } else {
                                var last_pcs = parseInt(first_pcs);
                            }
                            var pcs = '<td>' + '<input id="pcs_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" value="' + last_pcs + '">' + '</td>';
                            // var unit = '<td>' + '<input id="unit_edit_' + id + '" style="border: none;" type="text" class="form-control input-sm" name="Unit" value="' + order['Unit'] + '">' + '</td>';

                            var unit_id = order['unit_id'];
                            var units = response.units;
                            var unit = '';
                            var j = 0;
                            unit = unit + '<td><select id="unit_id_edit_' + id + '" class="form-control input-sm">';
                            for (j = 0; j < units.length; j++) {
                                if (units[j]['id'] == unit_id) {
                                    unit = unit + '<option selected value="' + units[j]['id'] + '">' + units[j]['Unit'] + '</option>';
                                } else {
                                    unit = unit + '<option value="' + units[j]['id'] + '">' + units[j]['Unit'] + '</option>';
                                }
                            }
                            unit = unit + '</select></td>';

                            var vehicle_id = order['vehicle_id'];
                            var vehicles = response.vehicles;
                            var vehicle = '';
                            var j = 0;
                            vehicle = vehicle + '<td><select id="vehicle_id_edit_' + id + '" class="form-control input-sm">';
                            for (j = 0; j < vehicles.length; j++) {
                                if (vehicles[j]['id'] == vehicle_id) {
                                    vehicle = vehicle + '<option selected value="' + vehicles[j]['id'] + '">' + vehicles[j]['QN'] + '-' + vehicles[j]['Marka'] + '-' + vehicles[j]['Tipi'] + '</option>';
                                } else {
                                    vehicle = vehicle + '<option value="' + vehicles[j]['id'] + '">' + vehicles[j]['QN'] + '-' + vehicles[j]['Marka'] + '-' + vehicles[j]['Tipi'] + '</option>';
                                }
                            }
                            vehicle = vehicle + '</select></td>';
                            var marka = vehicle;

                            if (order['WEB_link'] == null) {
                                var web_link = '<td><span disabled="true"><i class="fa fa-link"></i></span></td>';
                            } else {
                                var web_link = '<td><a target="_blank" href="' + order['WEB_link'] + '"><i class="fa fa-link"></i></a></td>';
                            }

                            var remark = '<td><center><span title="Sifariş səbəbii göstər" onclick="get_data(' + id + ', 3);" class="btn btn-success btn-xs add-modal"><i class="fa fa-eye"></i></span></center></td>';

                            if (order['image'] == null) {
                                var picture = '<td><center><span disabled="true" title="Şəkli göstər" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></span></center></td>';
                            } else {
                                var picture = '<td><center><span title="Şəkli göstər" onclick="get_data(' + id + ', 4);" class="btn btn-success btn-xs add-modal"><i class="fa fa-eye"></i></span></center></td>';
                            }

                            if (order['deffect_doc'] == null) {
                                var defect = '<td><center><span disabled="true" title="Xəta sənədini endir" class="btn btn-success btn-xs"><i class="fa fa-download"></i></span></center></td>';
                            } else {
                                var defect = '<td><center><a title="Xəta sənədini endir" href="' + order['deffect_doc'] + '" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-download"></i></a></center></td>';
                            }

                            var user = '<td>' + order['user_name'] + ' ' + order['user_surname'] + '</td>';
                            var status = '<td><span onclick="show_status(' + order['id'] + ')" id="status_' + id + '" class="btn btn-xs" style="color: ' + order['status_color'] + '; border-color: ' + order['status_color'] + ';">' + order['status'] + '</span></td>';

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
                                    position = '';
                                    var k = 0;
                                    position = position + '<td><select id="position_id_edit_' + id + '" class="form-control input-sm">';
                                    for (k = 0; k < positions.length; k++) {
                                        if (positions[k]['id'] == position_id) {
                                            position = position + '<option selected value="' + positions[k]['id'] + '">' + positions[k]['position'] + '</option>';
                                        } else {
                                            position = position + '<option value="' + positions[k]['id'] + '">' + positions[k]['position'] + '</option>';
                                        }
                                    }
                                    position = position + '</select></td>';
                                    // position = '<td>null</td>';

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

                                case '11': {
                                    //zemanet
                                    marka = '';
                                    defect = '';
                                }
                                    break;
                            }

                            var date = '<td>' + order['created_at'].substr(0, 10) + '</td>';

                            var tr = '<tr class="even pointer" id="row_' + order['id'] + '">';
                            tr = tr + '<td>' + id + '</td>' + '<td><center>' + edit + cancel + '</center></td>' + user + date + product + translation_brand + part + web_link + pcs + unit + marka + position + status + remark + picture + defect;
                            tr = tr + '</tr>';
                            table = table + tr;
                        }

                        $('#orders_table').html(table);

                        $("input").keypress(function () {
                            if (this.value.length < 20) {
                                this.style.width = 20 + "ch";
                            } else {
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

                    @php($product_colspan = 2)

            var inputs = '<td colspan="2" id="add-btn-td"><center><button type="submit" id="add-btn" class="btn btn-success btn-xs"><i class="fa fa-save"></i></button></center></td>';

            switch (category_id) {
                case '1': {
                    //xususi texnika
                    Product = '<td colspan="{{$product_colspan}}"  id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
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

                    Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                    deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                case '2': {
                    //xidmeti
                    Product = '<td  colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
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

                    Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                    deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                case '3': {
                    //servis
                    Product = '<td  colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Görülən işin adı"></td>';
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

                    Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                    deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                case '4': {
                    //mesref
                    Product = '<td  colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
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

                    Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                    deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;

                }
                    break;

                case '5': {
                    //inventar
                    Product = '<td  colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
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

                    Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                case '6': {
                    //akkumlyator
                    Product = '<td  colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
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

                    Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                    deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                case '7': {
                    //forma
                    Product = '<td colspan="{{$product_colspan}}"  id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Malın adı"></td>';
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

                    Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + position_id + Remark + image + deffect_doc;
                }
                    break;

                case '8': {
                    //defterxana
                    Product = '<td  colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Adı"></td>';
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

                    Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                case '9': {
                    //blank
                    Product = '<td  colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Adı"></td>';
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

                    Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                case '10': {
                    //teker
                    Product = '<td  colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Təkərin ölçüsü"></td>';
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

                    Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';
                    deffect_doc = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="defect" placeholder="Doc"></td>';

                    inputs = inputs + Product + Translation_Brand + Part + WEB_link + Pcs + unit_id + vehicle_id + Remark + image + deffect_doc;
                }
                    break;

                case '11': {
                    //zemanet
                    Product = '<td  colspan="{{$product_colspan}}" id="orders-add-inputs" style="width: 150px;"><input type="text" class="form-control input-sm" name="Product" placeholder="Adı"></td>';
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

                    Remark = '<td id="orders-add-inputs" colspan="2" style="width: 150px;"><input type="text" class="form-control input-sm" name="Remark" placeholder="Sifariş səbəbi"></td>';
                    image = '<td id="orders-add-inputs" style="width: 300px;"><input type="file" class="form-control input-sm" name="picture" placeholder="Image"></td>';

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
                    swal({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Gözləyin...</span>',
                        text: 'Gözləyin, əməliyyat aparılır...',
                        showConfirmButton: false
                    });
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    var product = $('#product_edit_' + id).val();
                    var translation_brand = $('#translation_brand_edit_' + id).val();
                    var part = $('#part_edit_' + id).val();
                    var pcs = $('#pcs_edit_' + id).val();
                    var unit_id = $('#unit_id_edit_' + id).val();
                    var position_id = $('#position_id_edit_' + id).val();
                    var vehicle_id = $('#vehicle_id_edit_' + id).val();
                    console.log(vehicle_id);

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
                            'unit_id': unit_id,
                            'position_id': position_id,
                            'vehicle_id': vehicle_id
                        },
                        success: function (response) {
                            swal.close();
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
            swal({
                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Gözləyin...</span>',
                text: 'Gözləyin, əməliyyat aparılır...',
                showConfirmButton: false
            });
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'id': id,
                    '_token': CSRF_TOKEN,
                    'type': type
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
            swal({
                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Gözləyin...</span>',
                text: 'Gözləyin, əməliyyat aparılır...',
                showConfirmButton: false
            });
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
                success: function (response) {
                    swal.close();
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
