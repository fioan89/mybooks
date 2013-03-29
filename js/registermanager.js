/**
 * Handles register button by sending to a php script the needed data.
 * Also it make's shure password are the same
 * @author Faur Ioan-Aurel
 */

$(document).ready(function() {
	$("#submituser").bind("click", function() {
		// get fname, lname, email and password
		var fname = $("#fname_value").val();
		var lname = $("#lname_value").val();
		var email = $("#email_value").val();
		var password = CryptoJS.MD5($("#password_value").val()).toString(CryptoJS.enc.Hex);
		var rpassword = CryptoJS.MD5($("#rpassword_value").val()).toString(CryptoJS.enc.Hex);

		if (password !== rpassword) {
			$("#error_message").text("Passwords don't match");
			return;
		}
		// send ajax request
		var httpRequest;
		if (window.XMLHttpRequest) {// Mozilla, Safari, ...
			httpRequest = new XMLHttpRequest();
		} else if (window.ActiveXObject) {// IE 8 and older
			httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}

		httpRequest.onreadystatechange = function() {
			if (httpRequest.readyState === 4) {
				if (httpRequest.status === 200) {
					var resp = httpRequest.responseText;
					if (resp != "not good to go") {
						window.location = "../index.php?user=" + resp;
					} else {
						$("#error_message").text("Email or password invalid!")
					}
				} else {
					//There was a problem with the response!
				}
			} else {
				//"Server is not ready yet!"
			}
		};

		httpRequest.open('POST', './register_handler.php', true);
		httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		httpRequest.send("fname=" + fname + "&lname=" + lname + "&email=" + email + "&password=" + password);
	});
});
