@extends('bo.layouts.master') 
@section('bodycontent')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Create role</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{route('roles.store')}}" method="POST">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name*</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" placeholder="name" name="name" value="{{old('name')}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-5">
                        <select name="from[]" id="multiselect" class="form-control" size="8" multiple="multiple">
                            @foreach ($permissions as $perm)
                                <option value="{{$perm->name}}">{{$perm->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-xs-2">
                        <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                        <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                        <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                        <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                    </div>
                    
                    <div class="col-xs-5">
                        <select name="to[]" id="multiselect_to" class="form-control" size="8" multiple="multiple"></select>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ route('roles.index')}}" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-info pull-right">Save</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('assets/js/multiselect.js') }}"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#multiselect').multiselect({
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            }
        });
    });
</script>
@endsection