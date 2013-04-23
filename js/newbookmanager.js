/**
 * Informs server side that a new book must
 * be registered on the database.
 *
 * @author Faur Ioan-Aurel
 */

$(document).ready(function() {
	$("#submitbook").bind("click", function() {
		// get fname, lname, email and password
		var bid = $("#bid_value").val();
		var aid = $("#aid_value").val();
		var title = $("#title_value").val();
		var name = $("#name_value").val();
		var subjects = $("#subjects_value").val();
		var description = $("#description_value").val();
		
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
					window.location = "../index.php?user=" + resp;
				} else {
					//There was a problem with the response!
				}
			} else {
				//"Server is not ready yet!"
			}
		};

		httpRequest.open('POST', './newbook_handler.php', true);
		httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		httpRequest.send("aid=" + aid + "&bid=" + bid + "&name=" + name + "&title=" + title + "&subjects=" + subjects + "&description=" + description);
	});
});
/**
 * @author Faur Ioan-Aurel
 */
