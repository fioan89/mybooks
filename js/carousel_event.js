/**
 * When a user click an image from the carousel, this script should call
 * a php script that will return the needed information.
 *
 * @author Faur Ioan-Aurel
 */
$(document).ready(function() {
	$(document).on("click", ".img_button", function() {
		var bid = $(this).attr("alt");
		// a little bit of ajax magic
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
					$(".booksubjectslist").html(resp[4]);
				} else {
					//There was a problem with the response!
				}
			} else {
				//Server is not ready yet!
			}
		};

		httpRequest.open('POST', './books/carousel.php', true);
		httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		httpRequest.send("bookid=" + bid);
	})
});
