
@extends('layouts.app')
@section('content')
<div class="content">
	<p id="info" align="center"></p>
	<div class="card" style="max-width: 400px; margin: auto">
		<div class="card-header">Register New User</div>
		<div class="card-body">
			<div class="login-form">
				<div>
					<label for="useraname"> Username </label>
				</div>
				<div>
					<input id="useraname" class="form-control" type="text" required />
					<span id="user-availability"></span>
				</div>
				<div>
					<label for="name"> Display Name </label>
				</div>
				<div>
					<input id="name" class="form-control" type="text" required />
				</div>
				<div>
					<label for="password"> Password </label>
				</div>
				<div>
					<input id="password" type="password" class="login-field" required />
				</div>
				<div>
					<label for="re_password"> Password </label>
				</div>
				<div>
					<input id="re_password" type="password" class="login-field"
						required />
				</div>

				<div>
					<button class="btn btn-success" onclick="register(); return false;">Register</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var ctxPath = "${contextPath}";
	const usernameField = _byId("useraname");
	const nameField = _byId("name");
	const passwordField = _byId("password");
	const rePasswordField = _byId("re_password");
	const usernameAvailabilityInfo = _byId("user-availability");

	usernameField.onkeyup = function(e) {
		checkUsername(e.target.value);
	}

	function checkUsername(username) {
		const requestObject = {
			'username' : username
		}
		postReq("{{$context_path}}/api/account/checkusername",
				requestObject, function(xhr) {
					var response = xhr.data;
					var msg;
					var color;
					if (response != null) {
						msg = response.message;
						color = response.code == "00" ? "green" : "red";
					} else {
						msg = "SERVER ERROR";
						color = "red";
					}
					usernameAvailabilityInfo.innerHTML = msg;
					usernameAvailabilityInfo.style.color = color;
				});
	}
	
	

	function register() { 
	
		if(isOneOfInputFieldEmpty(rePasswordField, passwordField, usernameField, nameField)){
			alert("Please complete the fields!");
			return;
		}
	
		if (rePasswordField.value != passwordField.value) {
			alert("Password does not match!");
			
			return;
		} 
		 
		
		const requestObject = {
			'user' : {
				'display_name' : nameField.value,
				'username' : usernameField.value,
				'password' : passwordField.value
			}
		}
		postReq(
				"{{$context_path}}/api/account/register"  ,
				requestObject,
				function(xhr) {
					var response = xhr.data;
					if (response != null && response.code == "00") {
						alert("register Success");
						window.location.href = "{{$context_path}}/account/login";
					} else {
						alert("register Failed");
					}
				});
	}
</script> 
@endsection