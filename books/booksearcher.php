<?php
require_once 'dbmanager.php';
require_once 'bookutil.php';

$manager = DBManager::getInstance();
$con = $manager -> getConnection();
mysql_select_db("books", $con);
////////////////////////////////// find book id's ///////////////////
$search_type = $_POST['search_type'];
$search_vals = explode("<::mybooks::>", $_POST['search_val']);
$cmd = "";
switch($search_type) {
	case "Title" :
		// build comand for searching by title
		$cmd = "select book_id from Books where";
		$cmd .= " title like '%#################%'";
		// low chanches
		foreach ($search_vals as $val) {
			if (strlen($val) > 0) {
				$cmd .= " or title like '%$val%'";
			}
		}
		$cmd .= ";";
		break;
	case "Author" :
		// build comand for searching by author
		$cmd = "select Link_BookAuthors.book_id from Link_BookAuthors left join Authors on Link_BookAuthors.author_id=Authors.author_id where ";
		$cmd .= " Authors.name like '%##################'";
		// low chanches
		foreach ($search_vals as $val) {
			if (strlen($val) > 0) {
				$cmd .= " or Authors.name like '%$val%'";
			}
		}
		$cmd .= ";";
		break;
	case "Subject" :
		// build comand for searching by subject
		$cmd = "select book_id from Subjects where";
		$cmd .= " subject like '%#################%'";
		// low chanches
		foreach ($search_vals as $val) {
			if (strlen($val) > 0) {
				$cmd .= " or subject like '%$val%'";
			}
		}
		$cmd .= ";";
		break;
}

$result = mysql_query($cmd);
$_book_ids = array();
$contor = 0;

while ($row = mysql_fetch_array($result)) {
	$_book_ids[$contor] = $row['book_id'];
	$contor++;
}
// remove book id's
$_book_ids = array_unique($_book_ids);
$book_ids = array();
$counter = 0;
foreach ($_book_ids as $val) {
	$book_ids[$counter]= $val;
	$counter++;	
}
$books = get_books($book_ids);

// Now that we got the books we need to prepare the response.
// That means we should chose a default book to select, load it
// and the rest should go to the carousel. Therefore:

// build response
if (count($books) > 0) {
	//////////////////////////////////  book cover ///////////////////////////////////////////////////////////
	$book_url = "http://covers.openlibrary.org/b/olid/" . $books[0] -> getBookId() . "-M.jpg?default=false";
	// check if cover exist if not use the default cover
	if (check_cover_exist($book_url) == False) {
		$book_url = "./img/no_cover.png";
	}
	$r_img = '<img id="bookcover" src="' . $book_url . '" alt="' . $books[0] -> getBookId() . '" width=\"250px\" height=\"300px\"/>';

	/////////////////////////////////// book title  ///////////////////////////////////////////////////////////
	$r_title = ' ' . $books[0] -> getTitle() . ' ';
	/////////////////////////////////// book authors //////////////////////////////////////////////////////////
	$tmp_a = $books[0] -> getAuthors();
	$cc = count($tmp_a);
	$r_authors = '';
	for ($i = 0; $i < $cc; $i++) {
		$r_authors .= '<div class="authorslist">
				<span>' . $tmp_a[$i] . '</span></div> ';
	}
	/////////////////////////////////////// book description //////////////////////////////////////////////////
	$r_description = $books[0] -> getDescription();
	/////////////////////////////////////// book subjects ////////////////////////////////////////////////////
	$tmp_s = $books[0] -> getSubjects();
	$cc = count($tmp_s);
	$r_subjects = '';
	for ($i = 0; $i < $cc; $i++) {
		$r_subjects .= '<div class="authorslist">
							<span>' . $tmp_s[$i] . '</span></div> ';
	}
	//////////////////////////////////////// carousel /////////////////////////////////////////////////////////
	$r_carousel = "<ul> ";
	$nr_books = count($books);
	for ($i = 0; $i < $nr_books; $i++) {
		$book_url = "http://covers.openlibrary.org/b/olid/" . $books[$i] -> getBookId() . "-M.jpg?default=false";
		// check if cover exist if not use the default cover
		if (check_cover_exist($book_url) == False) {
			$book_url = "./img/no_cover.png";
		}
		$book_id = $books[$i] -> getBookId();
		$r_carousel .= "<li><img class=\"img_button\" src=\"$book_url\" alt=\"$book_id\"/></li>";
	}
	$r_carousel .= "</ul>";
	$res = array($r_img, $r_title, $r_authors, $r_description, $r_subjects, $r_carousel);
	// send result
	echo implode('<::mybook::>', $res);
} else {
	// send no book founded
	//////////////////////////////////  book cover ///////////////////////////////////////////////////////////
	$book_url = "./img/no_cover.png";
	$r_img = '<img id="bookcover" src="' . $book_url . '" alt="0" width=\"250px\" height=\"300px\"/>';

	/////////////////////////////////// book title  ///////////////////////////////////////////////////////////
	$r_title = 'No book was found!';
	/////////////////////////////////// book authors //////////////////////////////////////////////////////////
	$r_authors .= '<div class="authorslist">
				<span></span></div> ';

	/////////////////////////////////////// book description //////////////////////////////////////////////////
	$r_description = "No book was found with the specified input. Please try again!";
	/////////////////////////////////////// book subjects ////////////////////////////////////////////////////
	$r_subjects .= '<div class="authorslist">
					<span></span></div> ';
	//////////////////////////////////////// carousel /////////////////////////////////////////////////////////
	$r_carousel = "<ul> ";
	$book_url = "./img/no_cover.png";
	$r_carousel .= "<li><img class=\"img_button\" src=\"$book_url\" alt=\"0\"/></li>";
	$r_carousel .= "</ul>";
	$res = array($r_img, $r_title, $r_authors, $r_description, $r_subjects, $r_carousel);
	// send result
	echo implode('<::mybook::>', $res);
}
?>