
@extends('layouts.app')

@section('content')
<script type="text/javascript">
	var ctxPath = "{{$context_path}}";
	function login() {

		var username = _byId("user-name").value;
		var password = _byId("password").value;
		var request = new XMLHttpRequest();
		infoLoading();
		var requestObject = {
			'user' : {
				'username' : username,
				'password' : password
			}
		}
		postReq(
				ctxPath +"/api/account/login" ,
				requestObject,
				function(xhr) {
					infoDone();
					var response = (xhr.data);
					if (response != null && response.code == "00") {
						alert("LOGIN SUCCESS");
						const redirectLocation = xhr.getResponseHeader("location");
						
						// if (redirectLocation!= null) {
						// 	window.location.href = redirectLocation;
						// } else
						// 	window.location.href = ctxPath+"/admin/home";
					} else {
						alert("LOGIN FAILED");
					}
				});
	}
 
</script>
<div class="content">
	<p id="info" align="center"></p>
	<div class="card" style="max-width: 400px; margin: auto">
		<div class="card-header">Please Login</div>
		<div class="card-body">
			<div class="login-form">
			
				<label for="user-name">Username</label>
				<input id="user-name"
					class="form-control" type="text" />
				<label for="password">Password</label> 
				<input id="password" type="password" class="form-control" />
				 
				<button class="btn btn-primary" onclick="login(); return false;">Login</button> 
				<a role="button" class="btn btn-success"
					href='<spring:url value="/account/register"></spring:url>'>Register</a>  

			</div>
		</div>
	</div>
</div>

@endsection