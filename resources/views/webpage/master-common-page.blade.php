@extends('layouts.app')
@section('content')
<div class="content">
	<h2>{{$page->name}}</h2>
	{{-- <p>Good ${timeGreeting}, ${loggedUser.displayName}. Have a great day!</p> --}}
	<p>{{$page->description }}</p>
	<div class="row">
		@if(is_null($page->menus) == false && is_array($page->menus))
		@foreach ($page->menus as $menu)
			 
			<div class="col-sm-3">
				<div class="card" style="width: 100%;">
					@if(is_null($menu ['icon_url']) || "" == trim($menu ['icon_url']))
					<img class="card-img-top"  width="100" height="150" src="{{$context_path}}/img/DefaultIcon.BMP"
						alt="Card image cap">
					@else 
					<img class="card-img-top"  width="100" height="150" src="{{$context_path}}/img/{{ $menu ['icon_url']  }}"
						alt="Card image cap">
					@endif
					<div class="card-body" style="background-color:{{$menu ['general_color']}}; color:{{$menu ['font_color']}}">
						<h5 class="card-title">
							  {{$menu ['name']  }} 
						</h5>
						<a class="badge badge-primary"
							data-toggle="tooltip" data-placement="bottom"
							title="{{$menu ['description'] }}" href="{{$context_path}}{{$menu ['url'] }}" >Detail</a>
					</div>
				</div>
			</div>
		@endforeach
		@endif
	</div>
	<p></p>
</div>
@endsection