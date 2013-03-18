<?php
require_once 'book.php';
/**
 * Checks if a cover exist at the specified url.
 */
function check_cover_exist($cover_url) {
	$contents = file_get_contents($cover_url);
	$search = <<<EOF
not found
EOF;

	if (strpos($contents, $search) === TRUE) {
		return false;
	}
	return true;
}

/**
 * Returns an array of $sz random numbers between low and high.
 * If you want unique numbers $sz must be less than $high.
 */
function get_randoms($low, $high, $sz) {
	$result = array();
	for ($i = 0; $i < $sz; $i++) {
		$ok = false;
		while (!$ok) {
			$nr = rand($low, $high);
			if (!in_array($nr, $result)) {
				$result[$i] = $nr;
				$ok = true;
			}
		}
	}
	return $result;
}

/**
 * Returns an array of Book instances from the paramater specified.
 * $book_id is a list of book id's;
 */
function get_books($book_ids) {
	$sz = count($book_ids);
	$books = array();
	$trash = array("\"", "'", "\n", "\t");
	for ($i = 0; $i < $sz; $i++) {
		$books[$i] = new Book();
		$bid = $book_ids[$i];
		$books[$i] -> setBookId($bid);
		// get book  details.
		$title = mysql_query("select title from Books where book_id='$bid';");
		$authors = mysql_query("select Link_BookAuthors.author_id, Authors.name from Link_BookAuthors left join Authors on Link_BookAuthors.author_id=Authors.author_id where Link_BookAuthors.book_id='$bid';");
		$subjects = mysql_query("select subject from Subjects where book_id='$bid';");
		$description = mysql_query("select description from Books where book_id='$bid';");

		// fetch and set title
		$tmp_t = mysql_fetch_array($title);
		$books[$i] -> setTitle(str_replace($trash, "", $tmp_t['title']));

		// fetch and set authors
		$ccounter = 0;
		$tmp_a = array();
		while ($row = mysql_fetch_array($authors)) {
			$tmp_a[$ccounter] = str_replace($trash, "", $row['name']);
			$ccounter++;
		}
		if ($ccounter == 0) {
			$tmp_a[0] = 'No author was found the database';
		}
		$books[$i] -> setAuthors($tmp_a);

		// fetch and set subjects
		$ccounter = 0;
		$tmp_s = array();
		while ($row = mysql_fetch_array($subjects)) {
			$tmp_s[$ccounter] = str_replace($trash, "", $row['subject']);
			$ccounter++;
		}
		if ($ccounter == 0) {
			$tmp_s[0] = 'No subject was found the database';
		}
		$books[$i] -> setSubjects($tmp_s);

		// fetch and set description
		$tmp_d = mysql_fetch_array($description);
		$books[$i] -> setDescription(str_replace($trash, "", $tmp_d['description']));
	}
	return $books;

}
?>