<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="{{$name}}">{{$label}}
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{ Form::date($name, $value, array_merge(['class' => 'form-control col-md-7 col-xs-12', 'id'=>$name, 'required'])) }}
    </div>
</div>