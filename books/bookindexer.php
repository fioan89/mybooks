<?php
require_once 'dbmanager.php';
require_once 'book.php';

    class BookIndexer {
		private $book_ids;
		private $con;
		const nb = 7; // nr of books
		private $manager;
		
		public function __construct() {
			$this->manager = DBManager::getInstance();
			$this->con = $this->manager->getConnection();
			mysql_select_db("books", $this->con);
			$this->book_ids = mysql_query("select book_id from Books"); // now there's a lot of books here
		}
		
		/**
		 * Gets 10 random books with each new call.
		 * This will contain info like book_id, book title, authors, description and subjects.
		 * 
		 * @return an array of books 
		 */
		public function getNextBooks() {
			//initialize nb books
			$sz = mysql_num_rows($this->book_ids);
			$books = array();
			$seeds = get_randoms(0, $sz, self::nb);
			$trash = array("\"", "'","\n", "\t");
			for ($i = 0; $i<self::nb; $i++) {
				$books[$i] = new Book();
				$val = $seeds[$i];
				// seek to the $val row and fetch data
				if (mysql_data_seek($this->book_ids, $val)) {
					$data = mysql_fetch_array($this->book_ids);
					$bid = $data['book_id'];
					$books[$i]->setBookId($bid);
					// get book  details.
					$title = mysql_query("select title from Books where book_id='$bid';");
					$authors = mysql_query("select Link_BookAuthors.author_id, Authors.name from Link_BookAuthors left join Authors on Link_BookAuthors.author_id=Authors.author_id where Link_BookAuthors.book_id='$bid';");
					$subjects = mysql_query("select subject from Subjects where book_id='$bid';");
					$description = mysql_query("select description from Books where book_id='$bid';");
					
					// fetch and set title
					$tmp_t = mysql_fetch_array($title);
					$books[$i]->setTitle(str_replace($trash, "", $tmp_t['title']));
					
					// fetch and set authors
					$ccounter = 0;
					$tmp_a = array();
					while ($row = mysql_fetch_array($authors)) {
						$tmp_a[$ccounter] = str_replace($trash, "", $row['name']);
						$ccounter++;
					}
					if ($ccounter == 0) {
						$tmp_a[0]='No author was found the database';
					}
					$books[$i]->setAuthors($tmp_a);
					
					// fetch and set subjects
					$ccounter = 0;
					$tmp_s = array();
					while ($row = mysql_fetch_array($subjects)) {
						$tmp_s[$ccounter] = str_replace($trash, "", $row['subject']);
						$ccounter++;
					}
					if ($ccounter == 0) {
						$tmp_s[0]='No subject was found the database';
					}
					$books[$i]->setSubjects($tmp_s);
					
					// fetch and set description
					$tmp_d = mysql_fetch_array($description);
					$books[$i]->setDescription(str_replace($trash, "",$tmp_d['description']));					
				}
			}
		return $books;
		}    	
    }
?>