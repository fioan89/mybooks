<?php
session_start();
require_once './books/bookindexer.php';
require_once './books/bookutil.php';
$_SESSION['login_name'] = $_GET['user'];
$book_manager = new BookIndexer;
$books = $book_manager -> getNextBooks();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<!-- Ubuntu font family-->
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="js/carousel.js"></script>
		<script src="js/carousel_event.js"></script>
		<script src="js/search_handler.js"></script>

		<link href='http://fonts.googleapis.com/css?family=Ubuntu:500&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="css3/basicformat.css"/>
		<link rel="stylesheet" type="text/css" href="css3/bookstyle.css"/>
		<link rel="stylesheet" type="text/css" href="css3/carousel.css"/>
		<title>Welcome to My Books</title>
	</head>
	<body>
		<nav>
			<div class = "navigation">
				<div class = "menu_left">
					<a href="index.php">Home</a>
				</div>
				<div class = "menu_left">
					<a href="./books/about.html">About</a>
				</div>
				<div class = "menu_left">
					<a href="./books/contact.html">Contact</a>
				</div>
				<div class = "menu_right">
					<?php
					$tmp_user = $_SESSION['login_name'];
					echo "<input type=\"button\" name=\"signin\" value=\"$tmp_user\" id = \"signin_button\"/>";
					?>
				</div>

			</div>
		</nav>
		<!-- Main body of this page: contains a search bar, a book info, copyright, etc.. -->
		<div class = "book">
			<!-- Search bar -->
			<div class = "search_bar">
				<div id = "search_label">
					<span>Search</span>
				</div>

				<div id = "search_type">
					<select name="drop1" id="typeselect_box" >

						<option value="Title">By Title</option>

						<option value="Author">By Author</option>

						<option value="Subject">By Subject</option>
					</select>
				</div>

				<div id = "search_input">
					<input id = "search_textbox" type = "text" value = "Search"/>
				</div>
				<div id = "search_action">
					<input id = "search_button" type = "button" value="Go"/>
				</div>
			</div>

			<!-- Book information like title, author name, description, subjects, book cover etc..-->
			<div class = "bookinfo">
			<div id = "bookimg">
			
			<?php $book_url = "http://covers.openlibrary.org/b/olid/" . $books[0] -> getBookId() . "-M.jpg?default=false";

			// check if cover exist if not use the default cover
			if (check_cover_exist($book_url) == false) {
				$book_url = "./img/no_cover.png";
			}
			$book_id = $books[0] -> getBookId();
			echo "<img id=\"bookcover\" src=\"$book_url\" alt=\"$book_id\" width=\"250px\" height=\"300px\"/>";
			?>
			</div>

			<div class = "bookdetails" >
			<?php $title = $books[0] -> getTitle();
			echo "<span id = \"booktitle\">$title</span>";
			?>
			<br>
			<div class = "bookauthors">
			<?php $authors = $books[0] -> getAuthors();
			$cc = count($authors);
			if ($cc == 0) {
				echo "<div class=\"authorslist\">
			<span>No authors found for this book id/span>
			</div>";
			} else {
				for ($i = 0; $i < $cc; $i++) {
					echo "<div class=\"authorslist\">
			<span>$authors[$i]</span>
			</div>";
				}
			}
			?>
			</div>
			<br/>
			<br/>
			<span id = "descriptionlabel">Book Description
			<br/>
			</span>
			<div id = "bookdescription">
			<?php $description = $books[0] -> getDescription();
			echo "$description";
			?>
			</div>
			<br>
			<span id = "subjectslabel">Subjects</span>

			<div class = "booksubjectslist">
			<?php $subjects = $books[0] -> getSubjects();
				$cc = count($subjects);
				for ($i = 0; $i < $cc; $i++) {
					echo "<div class=\"authorslist\">
							<span>$subjects[$i]</span>
						</div>";
				}
			?>
			</div>
<div style="clear:both"></div>
</div>
</div>
</div>

<div id="carousel">
<div id="car-navigation">
<span id="prev">&laquo;</span>
<span id="next">&raquo;</span>
</div>
<div class="clear_car"></div>
<div id="slides">
<ul>
<?php
$nr_books = count($books);
for ($i = 0; $i < $nr_books; $i++) {
	$book_url = "http://covers.openlibrary.org/b/olid/" . $books[$i] -> getBookId() . "-M.jpg?default=false";
	// check if cover exist if not use the default cover
	if (check_cover_exist($book_url) == False) {
		$book_url = "./img/no_cover.png";
	}
	$book_id = $books[$i] -> getBookId();
	echo "<li><img class=\"img_button\" src=\"$book_url\" alt=\"$book_id\"/></li>";
}
			?>
			</ul>
			<div class="clear_car"></div>
			</div>
			</div>
			<a href="./books/newbook.html">Do you want to add a new book? Click here!</a>
			<div class = "copyright">
				<footer>
					&copy; Copyright  by Faur Ioan-Aurel
				</footer>
			</div>
	</body>
</html>
