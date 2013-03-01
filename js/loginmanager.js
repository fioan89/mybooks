/**
 * Handles sign in push by sending to a php script the needed data.
 * If user clicks on "don have and account" just redirect to create user page.
 * @author Faur Ioan-Aurel
 */
$(document).ready(function() {
	$("#email_value").bind("keydown", function() {
		$("#error_message").text("");
	});
	$("#password_value").bind("keydown", function() {
		$("#error_message").text("");
	});
	$("#submituser").bind("click", function() {
		// get email and password
		var email = $("#email_value").val();
		var password = CryptoJS.MD5($("#password_value").val());
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

		httpRequest.open('POST', './login_handler.php', true);
		httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		httpRequest.send("email=" + email + "&password=" + password);
	});
});
