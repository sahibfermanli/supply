@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Add order</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <form id="form" data-parsley-validate class="form-horizontal form-label-left" method="post" action="" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_id">Category</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control col-md-7 col-xs-12" name="category_id" id="category_id">
                                            <option value="">Select</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->process}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div id="inputs">
                                    <div class="form-group" id="Product_div">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Product"  id="Product_lbl">Product</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control col-md-7 col-xs-12" name="Product" id="Product" maxlength="300" required>
                                        </div>
                                    </div>
                                    <div class="form-group" id="Translation_Brand_div">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Translation_Brand" id="Translation_Brand_lbl">Translation Brand</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control col-md-7 col-xs-12" name="Translation_Brand" id="Translation_Brand" maxlength="300" required>
                                        </div>
                                    </div>
                                    <div class="form-group" id="Part_div">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Part" id="Part_lbl">Part</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control col-md-7 col-xs-12" name="Part" id="Part" maxlength="100">
                                        </div>
                                    </div>
                                    <div class="form-group" id="WEB_link_div">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="WEB_link" id="WEB_link_lbl">WEB link</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control col-md-7 col-xs-12" name="WEB_link" id="WEB_link" maxlength="2000">
                                        </div>
                                    </div>
                                    <div class="form-group" id="Pcs_div">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Pcs" id="Pcs_lbl">QTY</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" class="form-control col-md-7 col-xs-12" name="Pcs" id="Pcs">
                                        </div>
                                    </div>
                                    <div class="form-group" id="unit_id_div ">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="unit_id" id="unit_id_lbl">Unit</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control col-md-7 col-xs-12" name="unit_id" id="unit_id">
                                                <option value="">Select</option>
                                                @foreach($units as $unit)
                                                    <option value="{{$unit->id}}">{{$unit->Unit}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="vehicle_id_div">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_id" id="vehicle_id_lbl">Garage No</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control col-md-7 col-xs-12" name="vehicle_id" id="vehicle_id">
                                                <option value="">Select</option>
                                                @foreach($vehicles as $vehicle)
                                                    <option value="{{$vehicle->id}}">{{$vehicle->QN}} - {{$vehicle->Marka}} - {{$vehicle->Tipi}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="position_id_div">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="position_id" id="position_id_lbl">Position</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control col-md-7 col-xs-12" name="position_id" id="position_id">
                                                <option value="">Select</option>
                                                @foreach($positions as $position)
                                                    <option value="{{$position->id}}">{{$position->position}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="Remark_div">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Remark" id="Remark_lbl">Remark</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="Remark" id="Remark" class="form-control col-md-7 col-xs-12" cols="30" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group" id="image_div">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image" id="image_lbl">Image<br><small>File formats: jpeg,png,jpg,gif,svg</small></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="file" class="form-control col-md-7 col-xs-12" name="picture" id="image">
                                        </div>
                                    </div>
                                    <div class="form-group" id="deffect_doc_div">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="deffect_doc" id="deffect_doc_lbl">Defect document<br><small>File formats: doc,docx,pdf,jpeg,png,jpg,gif,svg</small></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="file" class="form-control col-md-7 col-xs-12" name="defect" id="deffect_doc">
                                        </div>
                                    </div>
                                </div>


                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="reset" class="btn btn-primary">Clear</button>
                                        <button type="submit" class="btn btn-success">Add</button>
                                    </div>
                                </div>
                            </form>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">

    <style>
        #inputs {
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
            $('form').validate();
            $('form').ajaxForm({
                beforeSubmit:function () {
                    //loading
                    swal ({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                        text: 'Loading, please wait...',
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
                        location.replace('/orders');
                    }
                }
            });
        });
    </script>

    {{--change category--}}
    <script>
        $('#category_id').change(function () {
            $('#Product_div').css('display', 'block');
            $('#Translation_Brand_div').css('display', 'block');
            $('#Part_div').css('display', 'block');
            $('#WEB_link_div').css('display', 'block');
            $('#Pcs_div').css('display', 'block');
            $('#unit_id_div ').css('display', 'block');
            $('#vehicle_id_div').css('display', 'block');
            $('#position_id_div').css('display', 'none');
            $('#Remark_div').css('display', 'block');
            $('#image_div').css('display', 'block');
            $('#deffect_doc_div').css('display', 'block');

            var category_id = $('#category_id').val();

            if (category_id === '') {
                $('#inputs').css('display', 'none');
                alert('Please, select category...');
                return false;
            }

            switch (category_id) {
                case '1': {
                    //xususi texnika
                    $('#Product_lbl').html('Product name');
                    $('#Translation_Brand_lbl').html('Translation Brand');
                    $('#Part_lbl').html('Part No');
                }
                    break;

                case '2': {
                    //xidmeti
                    $('#Product_lbl').html('Product name');
                    $('#Translation_Brand_lbl').html('Translation Brand');
                    $('#Part_lbl').html('Part No');
                }
                    break;

                case '3': {
                    //servis
                    $('#Product_lbl').html('Task name');
                    $('#Translation_Brand_div').css('display', 'none');
                    $('#Part_div').css('display', 'none');
                }
                    break;

                case '4': {
                    //mesref
                    $('#Product_lbl').html('Product name');
                    $('#Translation_Brand_lbl').html('Description');
                    $('#Part_lbl').html('Brand');
                    $('#vehicle_id_div').css('display', 'none');
                }
                    break;

                case '5': {
                    //inventar
                    $('#Product_lbl').html('Product name');
                    $('#Translation_Brand_lbl').html('Description');
                    $('#Part_lbl').html('Brand');
                    $('#vehicle_id_div').css('display', 'none');
                }
                    break;

                case '6': {
                    //akkumlyator
                    $('#Product_lbl').html('Product name');
                    $('#Translation_Brand_lbl').html('Description');
                    $('#Part_lbl').html('Model');
                }
                    break;

                case '7': {
                    //forma
                    $('#Product_lbl').html('Product name');
                    $('#Translation_Brand_lbl').html('Size');
                    $('#Part_lbl').html('Type/Brand');
                    $('#position_id_div').css('display', 'block');
                    $('#vehicle_id_div').css('display', 'none');
                }
                    break;

                case '8': {
                    //defterxana
                    $('#Product_lbl').html('Name');
                    $('#Translation_Brand_div').css('display', 'none');
                    $('#Part_lbl').html('Type');
                    $('#vehicle_id_div').css('display', 'none');
                }
                    break;

                case '9': {
                    //blank
                    $('#Product_lbl').html('Name');
                    $('#Translation_Brand_div').css('display', 'none');
                    $('#Part_lbl').html('Type');
                    $('#vehicle_id_div').css('display', 'none');
                }
                    break;

                case '10': {
                    //teker
                    $('#Product_lbl').html('Wheel size');
                    $('#Translation_Brand_lbl').html('Description');
                    $('#Part_lbl').html('Brand');
                }
                    break;

                ////////////////////////////////
                default: {
                    alert('Category not found!');
                }
            }

            $('#inputs').css('display', 'block');
        });
    </script>
@endsection