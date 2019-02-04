@extends('backend.app')
@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
      <div>
          <h1>Ana səhifə</h1>
          <p>Tezliklə bildirişlər burada olacaq...</p>
      </div>
        @if(session('display') == 'block')
            <div class="alert alert-{{session('class')}}" role="alert">
                {{session('message')}}
            </div>
        @endif
        {{--<div class="">--}}
            {{--<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
                {{--<div class="tile-stats">--}}
                    {{--<div class="icon"><i class="fa fa-users"></i></div>--}}
                    {{--<div class="count">fdsfds</div>--}}
                    {{--<h3>Yeni satıcılar</h3>--}}
                    {{--<p><a href="/sellers?type=new">Satıcılar menyusuna keç</a></p>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="clearfix"></div>
    </div>
    <!-- /page content -->

@endsection

@section('css')

@endsection

@section('js')

@endsection
