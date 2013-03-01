/**
 * Handles search events. That mean's when Go is pushed
 * this should get the data from the input, split the words and
 * send asyn call to a php script.
 *
 * @author Faur Ioan-Aurel
 */
$(document).ready(function() {
	$("#search_button").bind("click", function() {
		var search_type = $("#typeselect_box option:selected").val();
		var search_val = $("#search_textbox").val();
		// split search values by " "
		var s_vals = search_val.split(" ");
		//build the request
		var req = "search_type=" + search_type + "&search_val=";
		for (var i = 0; i < s_vals.length; i++) {
			req += s_vals[i] + "<::mybooks::>";
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
					var resp = httpRequest.responseText.split('<::mybook::>')
					$("#bookimg").html(resp[0]);
					$("#booktitle").html(resp[1]);
					$(".bookauthors").html(resp[2]);
					$("#bookdescription").html(resp[3]);
					$("#booksubjectslist").html(resp[4]);
					$("#slides").html(resp[5]);
				} else {
					//There was a problem with the response!
				}
			} else {
				//"Server is not ready yet!"
			}
		};

		httpRequest.open('POST', './books/booksearcher.php', true);
		httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		httpRequest.send(req);

	});
});
