@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Sifarişlər</h3>
                    <span class="btn btn-success btn-mobile" style="display: none;">Kategoriyalar</span>
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
                                <li class="cat-li"><a style="color: black;" class="cat-select" href="#" cat_id="{{$category->id}}">{{$category->process}}</a></li>
                            @endforeach
                        </ul>
                      </div>
                        <div class="x_content" id="table_display">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title">Alternativ</th>
                                        <th class="column-title">Sifarişçi</th>
                                        <th class="column-title">Tarix</th>
                                        <th class="column-title" id="Product_th">Malın adı</th>
                                        <th class="column-title" id="Translation_Brand_th">Tərcümə/Təyinat</th>
                                        <th class="column-title" id="Part_th">Part No</th>
                                        <th class="column-title" id="WEB_link_th">WEB link</th>
                                        <th class="column-title" id="Pcs_th">Miqdar</th>
                                        <th class="column-title" id="unit_th">Ölçü vahidi</th>
                                        <th class="column-title" id="vehicle_th">Qaraj No</th>
                                        <th class="column-title" id="position_th">Vəzifə</th>
                                        <th class="column-title" id="Status_th">Status</th>
                                        <th class="column-title" id="Remark_th">Sifariş səbəbi</th>
                                        <th class="column-title" id="Image_th">Şəkil</th>
                                        <th class="column-title" id="Defect_th">Qüsur aktı</th>
                                    </tr>
                                    </thead>

                                    <tbody id="orders_table">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- start get data modal-->
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
                    <div class="modal-body-for-data">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.end get data modal-->

    <!-- start add modal alternatives-->
    <div class="modal fade" id="add-modal-alternatives" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="table-responsive" style="max-height: 300px !important;">
                                        <form action="" method="post" id="form">
                                            {{csrf_field()}}
                                            <input type="hidden" name="type" value="7">
                                            <div id="OrderIdForCreatePurchase"></div>
                                            <table class="table table-striped jambo_table bulk_action">
                                                <thead>
                                                <tr class="headings">
                                                    <th class="column-title"></th>
                                                    <th class="column-title">#</th>
                                                    <th class="column-title">Marka</th>
                                                    <th class="column-title">Model</th>
                                                    <th class="column-title">Part No</th>
                                                    <th class="column-title">Miqdar</th>
                                                    <th class="column-title">Ölçü vahidi</th>
                                                    <th class="column-title">Ümumi qiymət</th>
                                                    <th class="column-title">Valyuta</th>
                                                    <th class="column-title">Qiymət vaxtı</th>
                                                    <th class="column-title">Ölkə</th>
                                                    <th class="column-title">Firma</th>
                                                    <th class="column-title">Mağaza tipi</th>
                                                    <th class="column-title">Yaradılma tarixi</th>
                                                </tr>
                                                </thead>
                                                <tbody id="alternatives_table">

                                                </tbody>
                                            </table>
                                            <div class="form-group">
                                                <div class="">
                                                    <button type="submit" class="btn btn-success">Seç</button>
                                                    <span class="btn btn-danger cancel-alternatives-form">Alternativləri geri çevir</span>
                                                </div>
                                            </div>
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
    <!-- /.end add modal alternatives-->

    <!-- start cancel alternatives form modal-->
    <div class="modal fade" id="cancel-alternatives-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 30% !important;">
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
                        <input type="hidden" name="type" value="8">
                        <div id="cancel_alternatives"></div>
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Qeyd</label>
                                <textarea autofocus class="form-control col-md-7 col-xs-12" name="Remark" id="" cols="30" rows="10" placeholder='Boş buraxsanız default olaraq "Qəbul edilmədi" göndəriləcəkdir'></textarea>
                                <button style="margin-top: 10px;" type="submit" class="btn btn-success">Təsdiqlə</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.end cancel alternatives form modal-->
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
                        // location.replace('/orders');
                        location.reload();
                    }
                }
            });
        });
    </script>

    {{--alert--}}
    <script>
        function del(e, id, row_id) {
            swal({
                title: 'Are you sure you want to delete?',
                text: 'This process has no return...',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete!'
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
                            'row_id': row_id,
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

            $('#add-order-btn').css('display', 'block');

            $('#message').css('display', 'none');

            $('.cat-select').removeClass('active');
            $('.cat-li').removeClass('active');
            $(this).addClass('active');

            var cat_id = $(this).attr('cat_id');

            $('#add_to_form_category_id').html('<input type="hidden" name="category_id" value="' + cat_id + '">');

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
                    'cat_id': cat_id,
                    '_token': CSRF_TOKEN,
                    'type': 2
                },
                success: function (response) {
                    swal.close();
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
                                //zemanet
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

                        for (i=0; i< orders.length; i++) {
                            count++;
                            var order = orders[i];
                            var id = order['id'];
                            var user_detail = '<td style="min-width: 150px;">' + order['user_name'] + ' ' + order['user_surname'] + ' , ' + order['user_department'] + '</td>';
                            var product = '<td>' + order['Product'] + '</td>';
                            var translation_brand = '<td>' + order['Translation_Brand'] + '</td>';
                            var part = '<td>' + order['Part'] + '</td>';
                            var pcs = '<td>' + order['Pcs'] + '</td>';
                            var unit = '<td>' + order['Unit'] + '</td>';
                            var marka = '<td>' + order['Marka'] + '</td>';
                            var raport_date = order['created_at'];

                            if(order['WEB_link'] == null) {
                                var web_link ='<td><span disabled="true"><i class="fa fa-link"></i></span></td>';
                            }
                            else {
                                var web_link ='<td><a target="_blank" href="' + order['WEB_link'] + '"><i class="fa fa-link"></i></a></td>';
                            }

                            if (order['Remark'] == null) {
                                var remark = '<td><center><span disabled="true" title="Qeyd yoxdur" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></span></center></td>';
                            }
                            else{
                                var remark = '<td><center><span title="Qeydi göstər" onclick="get_data(' + id + ', 3);" class="btn btn-success btn-xs add-modal"><i class="fa fa-eye"></i></span></center></td>';
                            }

                            if (order['image'] == null) {
                                var picture = '<td><center><span disabled="true" title="Şəkil yoxdur" class="btn btn-warning btn-xs"><i class="fa fa-image"></i></span></center></td>';
                            }
                            else{
                                var picture = '<td><center><span title="Şəkili göstər" onclick="get_data(' + id + ', 4);" class="btn btn-success btn-xs add-modal"><i class="fa fa-image"></i></span></center></td>';
                            }

                            if (order['deffect_doc'] == null) {
                                var defect = '<td><center><span disabled="true" title="Xəta sənədini endir" class="btn btn-success btn-xs"><i class="fa fa-download"></i></span></center></td>';
                            }
                            else{
                                var defect = '<td><center><a title="Xəta sənədini endir" href="' + order['deffect_doc'] + '" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-download"></i></a></center></td>';
                            }

                            var status = '<td><span class="btn btn-xs" style="color: ' + order['color'] + ';">' + order['status'] + '</span></td>';

                            var show_alt = '<td><span onclick="get_alternatives(this, ' + order['id'] + ');" class="btn btn-success btn-xs add-modal-alternatives"><i class="fa fa-eye"></i></span></td>';

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

                                case '11': {
                                    //zemanet
                                    marka = '';
                                    defect = '';
                                }
                                    break;
                            }

                            var date = '<td>' + order['created_at'].substr(0, 10) + '</td>';

                            var tr = '<tr class="even pointer" id="row_' + order['id'] + '">';
                            tr = tr + '<td>' + id + '</td>' + show_alt + user_detail + date + product + translation_brand + part + web_link + pcs + unit + marka + position + status + remark + picture + defect;
                            tr = tr + '</tr>';
                            table = table + tr;
                        }

                        $('#orders_table').html(table);

                        $('#table_display').css('display', 'block');
                    }
                }
            });
        });
    </script>

    {{--get alternatives--}}
    <script>
        function get_alternatives(e, order_id) {
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
                    'order_id': order_id,
                    '_token': CSRF_TOKEN,
                    'type': 6
                },
                success: function (response) {
                    swal.close();
                    swal(
                        response.title,
                        response.content,
                        response.case
                    );
                    if (response.case === 'success') {
                        swal.close();

                        var order_id = response.order_id;

                        var table = '';
                        var alternatives = response.alternatives;
                        var i = 0;
                        var count = 0;
                        var image = '';

                        for (i=0; i< alternatives.length; i++) {
                            count++;
                            var alternative = alternatives[i];

                            var brend = '<td>' + alternative['Brend'] + '</td>';
                            var model = '<td>' + alternative['Model'] + '</td>';
                            var part = '<td>' + alternative['PartSerialNo'] + '</td>';
                            var pcs = '<td>' + alternative['pcs'] + '</td>';
                            var unit = '<td>' + alternative['Unit'] + '</td>';
                            var total_cost = '<td>' + alternative['total_cost'] + '</td>';
                            var currency = '<td>' + alternative['currency'] + '</td>';
                            var date = '<td>' + alternative['date'] + '</td>';
                            var country = '<td>' + alternative['country'] + '</td>';
                            var company = '<td>' + alternative['company'] + '</td>';
                            var store_type = '<td>' + alternative['store_type'] + '</td>';
                            var remark = '<td>' + alternative['Remark'] + '</td>';

                            if(alternative['image'] !== null) {
                                image = '<td><span title="Şəkli göstər" onclick="get_alt_image(' + alt_id + ');" class="btn btn-success btn-xs alt-image-modal"><i class="fa fa-image"></i></span></td>';
                            }
                            else {
                                image = '<td><span style="background-color: #ffac27; border-color: #ffac27;" title="Şəkil yoxdur" disabled="true" class="btn btn-success btn-xs"><i class="fa fa-image"></i></span></td>';
                            }

                            var radio = '<input type="radio" value="' + alternative['alternative_id'] + '" name="AlternativeID">';

                            var created_date = '<td>' + alternative['created_at'].substr(0, 10) + '</td>';

                            var tr = '<tr class="even pointer">';
                            tr = tr + '<td>' + radio + '</td><td>' + alternative['id'] + brend + model + part + pcs + unit + total_cost + currency + date + country + company + store_type + remark + image + created_date;
                            tr = tr + '</tr>';
                            table = table + tr;
                        }

                        $('#cancel_alternatives').html('<input type="hidden" name="OrderID" value="' + order_id + '">');
                        $('#OrderIdForCreatePurchase').html('<input type="hidden" name="OrderID" value="' + order_id + '">');
                        $('#alternatives_table').html(table);

                        $('#add-modal-alternatives').modal('show');
                    }
                }
            });
        }

        function get_alt_image(id) {
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
                    'type': 9
                },
                success: function (response) {
                    swal.close();

                    $('.alt-image').html(response.data);

                    $('#alt-image').modal('show');
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

                    $('.modal-body-for-data').html(response.data);
                }
            });
        }
    </script>

    <script type="text/javascript">
        //add modal
        $(document).on('click', '.add-modal', function() {
            $('#add-modal').modal('show');
        });
    </script>

    <script type="text/javascript">
        //modal add order
        $(document).on('click', '.order-add-form-modal', function() {
            $('#order-add-form-modal').modal('show');
        });
    </script>

    <script type="text/javascript">
        //modal cancel alternatives form
        $(document).on('click', '.cancel-alternatives-form', function() {
            $('#cancel-alternatives-form').modal('show');
        });
    </script>
@endsection
