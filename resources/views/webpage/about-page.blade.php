@extends('layouts.app')

@section('content')<div class="content">
	<p></p>
	<div class="card" style="width: 90%">
		<div class="card-header">About Us</div>
		<div class="card-body">

			<div style="display: grid; grid-template-columns: 20% 70%">

				<div>Name</div>
				<div>{{$profile->name }}</div>


				<div>Code</div>
				<div>{{$profile->appCode }}</div>


				<div>About</div>
				<div>{{$profile->about }}</div>


				<div>Address</div>
				<div>{{$profile->address }}</div>


				<div>Contact</div>
				<div>{{$profile->contact }}</div>


				<div>Website</div>
				<div>{{$profile->website }}</div>


			</div>
		</div>
	</div>
</div>
@endsection
