/**
 * @author Faur Ioan-Aurel
 */
$(document).ready(function() {
	// if prev is clicked
	$("#prev").bind("click", function() {
		// slide to left with one
		$("#carousel ul").animate({
			marginLeft : -140
		}, 1000, function() {
			$(this).find("li:last").after($(this).find("li:first"));
			$(this).css({
				marginLeft : 0
			});
		});
	});

	// if next is clicked
	$("#next").bind("click", function() {
		// slide to right
		$("#carousel ul").animate({
			marginLeft : +140
		}, 1000, function() {
			$(this).find("li:first").before($(this).find("li:last"));
			$(this).css({
				marginLeft : 0
			});
		});
	});
});
