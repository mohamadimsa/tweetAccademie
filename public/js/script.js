$(document).ready(function () {
	// Register Button
	$("#submitRegister").click(function(e) {
		e.preventDefault();
		$.post("?page=register&action=register",
			$("#formRegister").serializeArray(),
			function(data) {
				var obj = JSON.parse(data);
				$.each(obj, function(key, value) {
					if (key == "error") {
						$("#error").html(value);
					}
					if (key == "Signup" && value == "Valid") {
						location.href = "/Twitter/signin";
					}
				});
			});
	});
	
	// Login Button
	$("#submitSignin").click(function(e) {
		e.preventDefault();
		$.post("?page=signin&action=signin",
			$("#formSignin").serializeArray(),
			function(data) {
				var obj = JSON.parse(data);
				$.each(obj, function(key, value) {
					if (key == "error") {
						$("#error").html(value);
					}
					if (key == "Signin" && value == "ok") {
						location.href = "/Twitter/";
					}
				});
			});
	});

		//Log out Button
	$("#logout").click(function() {
		$.get("?action=Logout")
		.done(() => {
			location.href = "/Twitter/signin";
		});
	});

		// Message 
	$("#msgLink").click(function() {
		$.get("?page=message")
		.done((data) => {
			$("#msgModal").html(data);
		});
	});

	$("#DeleteUser").click(function() {
		$.get("?page=account&action=delAccount")
		.done((data) => {
			var obj = JSON.parse(data);
			$.each(obj, (k, v) => {
				if (k == "ok") {
					$.get("?action=Logout")
					.done((msg) => {
						location.href = "/Twitter/";
					});
				}
			});
		});
	});
});