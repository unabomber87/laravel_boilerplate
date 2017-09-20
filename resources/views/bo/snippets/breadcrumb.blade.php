<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    {{$title}}
    {{-- <small>it all starts here</small> --}}
  </h1>
  <ol class="breadcrumb">
  @if(Route::current()->getName() != '')
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">{{$title}}</li>
   @else
   	<li class="active"><i class="fa fa-dashboard"></i> {{$title}}</li>
   @endif
  </ol>
</section>