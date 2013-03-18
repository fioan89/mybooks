<?php
    class Book {
    	private $book_id = "";
		private $book_title = "";
		private $book_authors = array();
		private $book_subjects = array();
		private $book_description = "";
		
		/**
		 * Sets the book id
		 */
		public function setBookId($id) {
			if (is_string($id)) {
				$this->book_id = $id;
			} else {
				$this->book_id = "no id found";
			}			
		}
		/**
		 * Returns the book id.
		 * 
		 * @return a string as a book id.
		 */
		public function getBookId() {
			return $this->book_id;
		}
		
				/**
		 * Sets the book title
		 */
		public function setTitle($title) {
			if (is_string($title)) {
				$this->book_title = $title;
			} else {
				$this->book_title = 'No title found for this book';
			}			
		}
		
		/**
		 * Returns the book title.
		 * 
		 * @return a string as a book title.
		 */
		public function getTitle() {
			return $this->book_title;
		}
		
		/**
		 * Sets the book authors.
		 */
		public function setAuthors($authors) {
			if (is_array($authors)) {
				$this->book_authors = $authors;
			} else {
				$this->book_authors = array("No author found for this book");
			}			
		}
		/**
		 * Returns the book authors.
		 * 
		 * @return an array of authors for the book.
		 */
		public function getAuthors() {
			return $this->book_authors;
		}
		
		/**
		 * Sets the book subjects.
		 */
		public function setSubjects($subjects) {
			if (is_array($subjects)) {
				$this->book_subjects = $subjects;
			} else {
				$this->book_subjects = array("No subject found for this book");
			}			
		}
		
		/**
		 * Returns the book subjects.
		 * 
		 * @return an array of subjects for the book.
		 */
		public function getSubjects() {
			return $this->book_subjects;
		}
		
		/**
		 * Sets the book description.
		 */
		public function setDescription($description) {
			if (is_string($description)) {
				$this->book_description = $description;
			} else {
				$this->book_description = 'No description found for this  book';
			}			
		}
		/**
		 * Returns the book description.
		 * 
		 * @return a string as a book description.
		 */
		public function getDescription() {
			return $this->book_description;
		}
    }
?>