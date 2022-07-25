<?php
include 'inc/header.php';
?>
<body class="signinPage">
	<div class="container-fluid">
		<div class="row">
			<div class="offset-md-6 offset-lg-4 offset-xl-4 col-sm-12 col-md-8 col-lg-4 col-xl-3">
				<h1 class="text-center">Register</h1>
				<form id="formRegister">
					<div class="form-group mx-sm-3 mb-2">
						<label for="Firstname">First name</label>
						<input type="text" id ="Firstname" class="form-control" placeholder="John" name="Firstname">
					</div>
					<div class="form-group mx-sm-3 mb-2">
						<label for="Lastname">Last name</label>
						<input type="text" id="Lastname" class="form-control" placeholder="Smith" name="Lastname">
					</div>
					<div class="form-group mx-sm-3 mb-2">
						<label for="Username">Username</label>
						<input type="text" id="Username" class="form-control" placeholder="johnsmith" name="Username">
					</div>
					<div class="form-group mx-sm-3 mb-2">
						<label for="Email">Email</label>
						<input type="email" id="Email" class="form-control" placeholder="johnsmith@example.com" name="Email">
					</div>
					<div class="form-group mx-sm-3 mb-2">
						<label for="Password">Password</label>
						<input type="password" id="Password" class="form-control" name="Password"  placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
					</div>
					<div class="form-group mx-sm-3 mb-2">
						<label for="Password">Confirm password</label>
						<input type="password" id="confirmPassword" class="form-control" name="confirmPassword" placeholder="Confirm Your Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
					</div>
					<div id="message">
						<h3>Password must contain the following:</h3>
						<p id="letter" class="invalid">A <b>lowercase</b> letter</p>
						<p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
						<p id="number" class="invalid">A <b>number</b></p>
						<p id="length" class="invalid">Minimum <b>8 characters</b></p>
					</div>
					<div class="text-center">
						<input type="submit" value="Submit" id="submitRegister" class="btn btn-primary mx-sm-3">
						<p class="mx-sm-3 change" id="error" style="color: red;"></p>
						<p class=" mx-sm-3 change">Already a member? <a href="./signin/">Sign in here</a></p>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script
	src="https://code.jquery.com/jquery-3.3.1.js"
	integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
	crossorigin="anonymous"></script>
	<script src="/Twitter/public/js/jschris.js"></script>
	<script src="/Twitter/public/js/script.js"></script>
</body>
</html>