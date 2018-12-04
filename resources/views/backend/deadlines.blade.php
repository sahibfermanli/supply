@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Deadlines</h3>
                    <a href="/deadlines/add" class="btn btn-primary" style="float: right;">Add</a>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="table-responsive">
                                <div>
                                    {!! $deadlines->links(); !!}
                                </div>
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title">Type</th>
                                        <th class="column-title">Deadline </th>
                                        <th class="column-title">Color </th>
                                        <th class="column-title">Creation date </th>
                                        <th class="column-title">#Edit </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @php
                                        $row = 1;
                                    @endphp
                                    @foreach($deadlines as $deadline)
                                        <?php
                                            $date = date('d M Y', strtotime($deadline->created_at));
                                            if ($deadline->type == 0) {
                                                $type = 'Yerli';
                                            }
                                            else {
                                                $type = 'Xarici';
                                            }
                                        ?>
                                        <tr class="even pointer" id="row_{{$row}}">
                                            <td>{{$deadline->id}}</td>
                                            <td>{{$type}}</td>
                                            <td>{{$deadline->deadline}}</td>
                                            <td><span style="color: {{$deadline->color}};">{{$deadline->color}}</span></td>
                                            <td>{{$date}}</td>
                                            <td>
                                                <a href="deadlines/update/{{$deadline->id}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                                                <span class="btn btn-danger btn-xs" onclick="del(this, '{{$deadline->id}}', '{{$row}}');"><i class="fa fa-trash-o"></i> Delete </span>
                                            </td>
                                        </tr>
                                        @php
                                            $row++;
                                        @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                                <div>
                                    {!! $deadlines->links(); !!}
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
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "Post",
                        url: '',
                        data: {
                            'id': id,
                            '_token': CSRF_TOKEN,
                            'row_id': row_id
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
@endsection