@extends('bo.layouts.table')

@section('listobject')
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Action</th>
</tr>
	@foreach ($users as $user)
	<tr>
		<th>{{$user->id}}</th>
		<th>{{$user->name}}</th>
		<th>{{$user->email}}</th>
		<th>
			<a class="btn btn-xs btn-success btn-edit" title="Edit Data" href="{{route('users.edit', $user->id)}}"><i class="fa fa-pencil"></i></a> 
        
            <a class="btn btn-xs btn-warning btn-delete" title="Delete" href="javascript:;" onclick="swal({
				title: &quot;Are you sure ?&quot;,   
				text: &quot;You will not be able to recover this record data!&quot;,   
				type: &quot;warning&quot;,   
				showCancelButton: true,   
				confirmButtonColor: &quot;#ff0000&quot;,   
				confirmButtonText: &quot;Yes!&quot;,  
				cancelButtonText: &quot;No&quot;}).then(function(){
					var id = '{!! $user->id !!}';
					document.getElementById('delete-form-'+id).submit();
				});">
				<i class="fa fa-trash"></i>
				<form id="delete-form-{{$user->id}}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
					<input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}
                </form>
			</a> 
		</th>
	</tr>
	@endforeach
@endsection

@section('javascript')
<script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
@endsection