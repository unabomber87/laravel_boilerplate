@extends('bo.layouts.master') 
@section('bodycontent')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Create user</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{route('users.store')}}" method="POST">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-2 control-label">Name*</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" placeholder="name" name="name" value="{{old('name')}}" required>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-sm-2 control-label">Email*</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" placeholder="email" name="email" value="{{old('email')}}" required>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-sm-2 control-label">Password*</label>
                        <div class="col-sm-10">
                            <input id="password" type="password" class="form-control" name="password" placeholder="password" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('password-confirm') ? ' has-error' : '' }}">
                        <label for="password-confirm" class="col-sm-2 control-label">Retype password*</label>
                        <div class="col-sm-10">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Retype password" required>
                            @if ($errors->has('password-confirm'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password-confirm') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="col-sm-2 control-label">Role</label>
                    <div class="col-sm-10">
                        <select class="form-control select2" style="width: 100%;" name="role">
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                          
                        </select>
                    </div>
                </div>


                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ route('users.index')}}" class="btn btn-default">Cancel</a>
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