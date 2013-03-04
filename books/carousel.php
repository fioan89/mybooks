<?php
    require_once 'dbmanager.php';
	require_once 'bookutil.php';
	
	$manager = DBManager::getInstance();
	$con = $manager->getConnection();
	mysql_select_db("books", $con);
	$book_id = $_POST['bookid'];
	
	
	$title = mysql_query("select title from Books where book_id='$book_id';");
	$authors = mysql_query("select Link_BookAuthors.author_id, Authors.name from Link_BookAuthors left join Authors on Link_BookAuthors.author_id=Authors.author_id where Link_BookAuthors.book_id='$book_id';");
	$subjects = mysql_query("select subject from Subjects where book_id='$book_id';");
	$description = mysql_query("select description from Books where book_id='$book_id';");
	
	// fetch title
	$tmp_t = mysql_fetch_array($title);
	
	
	// fetch authors
	$ccounter = 0;
	$tmp_a = array();
	while ($row = mysql_fetch_array($authors)) {
		$tmp_a[$ccounter] = $row['name'];
		$ccounter++;
	}
	if ($ccounter == 0) {
		$tmp_a[0]='No author was found in our database';
	}
	
	// fetch subjects
	$ccounter = 0;
	$tmp_s = array();
	while ($row = mysql_fetch_array($subjects)) {
		$tmp_s[$ccounter] = $row['subject'];
		$ccounter++;
	}
	if ($ccounter == 0) {
		$tmp_s[0]='No subject was found in our database';
	}
	
	// fetch and set description
	$tmp_d = mysql_fetch_array($description);
	
	// build response
	//////////////////////////////////  book cover ///////////////////////////////////////////////////////////
	$book_url = "http://covers.openlibrary.org/b/olid/" . $book_id . "-M.jpg?default=false";
	// check if cover exist if not use the default cover
	if (check_cover_exist($book_url) == False) {
		$book_url = "./img/no_cover.png";
	}
	$r_img = '<img id="bookcover" src="' . $book_url. '" alt="' .$book_id . '" width=\"250px\" height=\"300px\"/>';	
	
	/////////////////////////////////// book title  ///////////////////////////////////////////////////////////
	$r_title = ' ' . $tmp_t['title'] . ' ';
	/////////////////////////////////// book authors //////////////////////////////////////////////////////////
	$cc = count($tmp_a);
	$r_authors = '';
	for ($i=0; $i<$cc; $i++) {
	$r_authors .= '<div class="authorslist">
				<span>' . $tmp_a[$i] . '</span></div> ';
     }
	/////////////////////////////////////// book description //////////////////////////////////////////////////
	if (!is_string($tmp_d['description'])) {
		$tmp_d['description'] = 'No description found for this book!';
	}
	$r_description = $tmp_d['description'];
	/////////////////////////////////////// book subjects ////////////////////////////////////////////////////
	$cc = count($tmp_s);
	$r_subjects = '';
	for ($i=0; $i<$cc; $i++) {
		$r_subjects .= '<div class="authorslist">
							<span>' . $tmp_s[$i] . '</span></div> ';	
	}
	
	$res = array($r_img, $r_title, $r_authors, $r_description,  $r_subjects);
	// send result
	echo implode('<::mybook::>', $res);

?>