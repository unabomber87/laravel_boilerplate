@extends('bo.layouts.master') 
@section('bodycontent')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Application Setting</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{route('upgrade')}}" method="POST"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-2 control-label">Application Name*</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" placeholder="name" name="name" value="{{$settings['name']}}" required>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('logo') ? ' has-error' : '' }}">
                        <label for="logo" class="col-sm-2 control-label v-center">Logo</label>
                        <div class="col-sm-4 v-center">
                            <input id="logo" name="logo" type="file">
                            @if ($errors->has('logo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('logo') }}</strong>
                                </span>
                            @endif
                        </div>
                        @if(isset($settings['logo']) && !empty($settings['logo']))
                            <div class="col-xs-3 v-center">
                                <img src="{{asset('assets/img/site/')}}/{{$settings['logo']}}" class="img-responsive" alt="Image">
                            </div>
                        @endif

                    </div>

                    <div class="form-group {{ $errors->has('icon') ? ' has-error' : '' }}">
                        <label for="icon" class="col-sm-2 control-label v-center">Fav Icon</label>
                        <div class="col-sm-4 v-center">
                            <input id="icon" name="icon" type="file">
                            @if ($errors->has('icon'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('icon') }}</strong>
                                </span>
                            @endif
                        </div>
                        @if(isset($settings['icon']) && !empty($settings['icon']))
                            <div class="col-xs-3 v-center">
                                <img src="{{asset('assets/img/site/')}}/{{$settings['icon']}}" class="img-responsive" alt="Image">
                            </div>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('lang') ? ' has-error' : '' }}">
                        <label for="lang" class="col-sm-2 control-label">Front Language</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" style="width: 100%;" name="lang">
                                <option value="0" @if($settings['lang'] == "0")selected="true" @endif>FR</option>
                                <option value="1" @if($settings['lang'] == "1")selected="true" @endif>EN</option>
                            </select>
                            @if ($errors->has('lang'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lang') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">Save</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
</script>
@endsection