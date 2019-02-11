@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Purchases</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="table-responsive">
                                <div>
                                    {!! $purchases->links(); !!}
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title" style="min-width: 200px;">Sifarişçi </th>
                                        <th class="column-title">Status </th>
                                        <th class="column-title" style="min-width: 100px;">Malın adı </th>
                                        <th class="column-title" style="min-width: 150px;">Marka </th>
                                        <th class="column-title" style="min-width: 100px;">Model </th>
                                        <th class="column-title">Miqdar </th>
                                        <th class="column-title">Ölçü vahidi </th>
                                        <th class="column-title">Qiymət </th>
                                        <th class="column-title">Ümumi qiymət </th>
                                        <th class="column-title">Yaradılma tarixi </th>
                                        <th class="column-title">Satıcı </th>
                                        <th class="column-title">Hesab </th>
                                        <th class="column-title">Qaime </th>
                                        <th class="column-title">Qiymətləndirən </th>
                                        <th class="column-title">Qiyməti təsdiq edən </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @php
                                        $row = 1;
                                    @endphp
                                    @foreach($purchases as $purchase)
                                        <?php
                                            $date = date('d.m.Y', strtotime($purchase->created_at));
                                            //deadline
                                            $dead_line = $purchase->deadline;
                                            $difference = intval(abs(strtotime($current_date)-strtotime($dead_line))/86400);
                                            $color = 'white';

                                            foreach ($deadlines as $deadline) {
                                              if ($difference <= $deadline->deadline) {
                                                $color = $deadline->color;
                                                break;
                                              }
                                            }
                                        ?>
                                        <tr class="even pointer" id="row_{{$row}}">
                                            <td style="background-color: {{$color}};">{{$purchase->id}}</td>
                                            <td>{{$purchase->name}} {{$purchase->surname}} , {{$purchase->Department}}</td>
                                            <td style="color: {{$purchase->color}};">{{$purchase->status}}</td>
                                            <td>{{$purchase->Product}}</td>
                                            <td>{{$purchase->Brend}}</td>
                                            <td>{{$purchase->Model}}</td>
                                            <td>{{$purchase->pcs}}</td>
                                            <td>{{$purchase->Unit}}</td>
                                            <td>{{$purchase->cost}}</td>
                                            <td>{{$purchase->total_cost}}</td>
                                            <td>{{$date}}</td>
                                            <td>{{$purchase->seller_name}}</td>
                                            <td>
                                                @if(isset($purchase->account_id))
                                                    <a title="{{$purchase->account_date}}" class="btn btn-success btn-xs" title="{{$purchase->account_date}}" target="_blank" href="/supply/accounts/print?a={{$purchase->account_id}}"><i class="fa fa-file-pdf-o"></i> {{$purchase->account_no}}</a>
                                                @else
                                                    <span title="Heç bir hesaba əlavə edilməyib" disabled="true" class="btn btn-success btn-xs" style="background-color: #b6a338; border-color: #b6a338;"><i class="fa fa-file-pdf-o"></i></span>
                                                @endif
                                            </td>
                                            <td style="min-width: 150px;">
                                                @if(isset($purchase->qaime_doc))
                                                    <a href="{{$purchase->qaime_doc}}" title="{{$purchase->qaime_date}}" class="btn btn-success btn-xs" style="background-color: #1b6d85; border-color: #1b6d85;"><i class="fa fa-download"></i> {{$purchase->qaime_no}}</a>
                                                @else
                                                    <span title="Qaiməni yoxdur" disabled="true" class="btn btn-success btn-xs" style="background-color: #b6a338; border-color: #b6a338;"><i class="fa fa-download"></i></span>
                                                @endif

                                                @if($purchase->account_id == null)
                                                    <span title="Qaimə yüklə" onclick="upload_qaime({{$purchase->id}});" class="btn btn-success btn-xs add-qaime"><i class="fa fa-upload"></i></span>
                                                @else
                                                    <span disabled="true" title="Düymə deaktivdir" class="btn btn-warning btn-xs"><i class="fa fa-upload"></i></span>
                                                @endif
                                            </td>
                                            <td title="{{$purchase->supply_date}}">{{$purchase->supply_name}} {{$purchase->supply_surname}}</td>
                                            <td title="{{$purchase->lawyer_date}}">{{$purchase->lawyer_name}} {{$purchase->lawyer_surname}}</td>
                                        </tr>
                                        @php
                                            $row++;
                                        @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                                <div>
                                    {!! $purchases->links(); !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--start add qaime modal--}}
    <div class="modal fade" id="add-qaime" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Qaiməni yüklə</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="add_qaime">
                        <div id="purchase_id_div"></div>
                        {{csrf_field()}}
                        <input type="file" name="file" class="form-control" style="width: 30%; display: inline-block;" required>
                        <input type="text" name="qaime_no" class="form-control" style="width: 30%; display: inline-block;" required placeholder="qaimənin nömrəsi">
                        <button type="submit" class="btn btn-success" style="display: inline-block;"><i class="fa fa-save"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--finish add qaime modal--}}
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script type="text/javascript">
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
                        location.reload();
                    }
                }
            });
        });

        //upload qaime
        function upload_qaime(purchase_id) {
            $('#purchase_id_div').html('<input type="hidden" name="purchase_id" value="' + purchase_id + '">');

            $('#add-qaime').modal('show');
        }

        //add modal
        // $(document).on('click', '.add-qaime', function() {
        //     $('#add-qaime').modal('show');
        // });
    </script>
@endsection
