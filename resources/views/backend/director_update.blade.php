@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Update director</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <form id="form" data-parsley-validate class="form-horizontal form-label-left" method="post" action="">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="DepartmentID">Auditor
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="auditor" id="DepartmentID" class="form-control col-md-7 col-xs-12" required>
                                            @foreach($departments as $department)
                                                @if($department->id == $director->auditor)
                                                    <option value="{{$department->id}}" selected>{{$department->Department}}</option>
                                                @else
                                                    <option value="{{$department->id}}">{{$department->Department}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{Form::bsTextRequired('name', 'Name', $director->name)}}
                                {{Form::bsTextRequired('surname', 'Surname', $director->surname)}}
                                {{Form::bsEmailRequired('email', 'E-mail', $director->email)}}
                                {{Form::bsPassword('password', 'Password', ['id'=>'password','class'=>'form-control col-md-7 col-xs-12'])}}
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="reset" class="btn btn-primary">Clear</button>
                                        <button type="submit" class="btn btn-success">Update</button>
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
                        location.replace('/directors');
                    }
                }
            });
        });
    </script>
@endsection