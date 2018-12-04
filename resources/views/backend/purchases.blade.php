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
                                        <th class="column-title">Malın adı </th>
                                        <th class="column-title">Marka </th>
                                        <th class="column-title">Model </th>
                                        <th class="column-title">Miqdar </th>
                                        <th class="column-title">Ölçü vahidi </th>
                                        <th class="column-title">Qiymət </th>
                                        <th class="column-title">Ümumi qiymət </th>
                                        <th class="column-title">Yaradılma tarixi </th>
                                        <th class="column-title">Sirket </th>
                                        <th class="column-title">Təslimatçı </th>
                                        <th class="column-title">Ödəniş tarixi </th>
                                        <th class="column-title">Hesab doc. </th>
                                        <th class="column-title">Qaime doc. </th>
                                        <th class="column-title">AWB_Akt doc. </th>
                                        <th class="column-title">Icraci doc. </th>
                                        <th class="column-title">Verilib MHIS </th>
                                        <th class="column-title">Verilib MS </th>
                                        {{--<th class="column-title">#Edit </th>--}}
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
                                            <td style="background-color: {{$color}};">{{$row}}</td>
                                            <td>{{$purchase->Product}}</td>
                                            <td>{{$purchase->Brend}}</td>
                                            <td>{{$purchase->Model}}</td>
                                            <td>{{$purchase->pcs}}</td>
                                            <td>{{$purchase->Unit}}</td>
                                            <td>{{$purchase->cost}}</td>
                                            <td>{{$purchase->total_cost}}</td>
                                            <td>{{$date}}</td>
                                            <td title="{{$purchase->phone}} , {{$purchase->address}}">{{$purchase->company}}</td>
                                            <td title="{{$purchase->delivery_date}}">{{$purchase->name}} {{$purchase->surname}}</td>
                                            <td>{{$purchase->odenish_date}}</td>
                                            @if(isset($purchase->hesab_doc))
                                                <td title="{{$purchase->hesab_doc_date}}"><a href="{{$purchase->hesab_doc}}" class="btn btn-success btn-xs"><i class="fa fa-download"></i></a></td>
                                            @else
                                                <td title="{{$purchase->hesab_doc_date}}"><span disabled="true" class="btn btn-success btn-xs"><i class="fa fa-download"></i></span></td>
                                            @endif
                                            @if(isset($purchase->qaime_doc))
                                                <td title="{{$purchase->qaime_doc_date}}"><a href="{{$purchase->qaime_doc}}" class="btn btn-success btn-xs"><i class="fa fa-download"></i></a></td>
                                            @else
                                                <td title="{{$purchase->qaime_doc_date}}"><span disabled="true" class="btn btn-success btn-xs"><i class="fa fa-download"></i></span></td>
                                            @endif
                                            @if(isset($purchase->AWB_Akt_doc))
                                                <td title="{{$purchase->AWB_Akt_doc_date}}"><a href="{{$purchase->AWB_Akt_doc}}" class="btn btn-success btn-xs"><i class="fa fa-download"></i></a></td>
                                            @else
                                                <td title="{{$purchase->AWB_Akt_doc_date}}"><span disabled="true" class="btn btn-success btn-xs"><i class="fa fa-download"></i></span></td>
                                            @endif
                                            @if(isset($purchase->icrachi_doc))
                                                <td title="{{$purchase->icrachi_doc_date}}"><a href="{{$purchase->icrachi_doc}}" class="btn btn-success btn-xs"><i class="fa fa-download"></i></a></td>
                                            @else
                                                <td title="{{$purchase->icrachi_doc_date}}"><span disabled="true" class="btn btn-success btn-xs"><i class="fa fa-download"></i></span></td>
                                            @endif
                                            @if(isset($purchase->Verilib_MHIS))
                                                <td title="{{$purchase->Verilib_MHIS_date}}"><a href="{{$purchase->Verilib_MHIS}}" class="btn btn-success btn-xs"><i class="fa fa-download"></i></a></td>
                                            @else
                                                <td title="{{$purchase->Verilib_MHIS_date}}"><span disabled="true" class="btn btn-success btn-xs"><i class="fa fa-download"></i></span></td>
                                            @endif
                                            @if(isset($purchase->Verilib_MS))
                                                <td title="{{$purchase->Verilib_MS_date}}"><a href="{{$purchase->Verilib_MS}}" class="btn btn-success btn-xs"><i class="fa fa-download"></i></a></td>
                                            @else
                                                <td title="{{$purchase->Verilib_MS_date}}"><span disabled="true" class="btn btn-success btn-xs"><i class="fa fa-download"></i></span></td>
                                            @endif
                                            {{--<td>--}}
                                                {{--<span class="btn btn-danger btn-xs" onclick="del(this, '{{$purchase->id}}', '{{$row}}');"><i class="fa fa-trash-o"></i> Delete </span>--}}
                                            {{--</td>--}}
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
        // function del(e, id, row_id) {
        //     swal({
        //         title: 'Are you sure you want to delete?',
        //         text: 'This process has no return...',
        //         type: 'warning',
        //         showCancelButton: true,
        //         cancelButtonText: 'Cancel',
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Delete!'
        //     }).then(function (result) {
        //         if (result.value) {
        //             var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //             $.ajax({
        //                 type: "Post",
        //                 url: '',
        //                 data: {
        //                     'id': id,
        //                     '_token': CSRF_TOKEN,
        //                     'row_id': row_id
        //                 },
        //                 beforeSubmit: function () {
        //                     //loading
        //                     swal({
        //                         title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
        //                         text: 'Loading, please wait..',
        //                         showConfirmButton: false
        //                     });
        //                 },
        //                 success: function (response) {
        //                     swal(
        //                         response.title,
        //                         response.content,
        //                         response.case
        //                     );
        //                     if (response.case === 'success') {
        //                         var elem = document.getElementById('row_' + response.row_id);
        //                         elem.parentNode.removeChild(elem);
        //                     }
        //                 }
        //             });
        //         } else {
        //             return false;
        //         }
        //     });
        // }
    </script>
@endsection
