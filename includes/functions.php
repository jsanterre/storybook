<?php 

	function confirm_query($result_set) {
		if(!$result_set) {
			die('Database query failed: ' . mysql_error()); 
		}
	}
	
	function get_all_books() {
		global $db;
		$query = "SELECT * 
				FROM books 
				ORDER BY position ASC";
		$book_set = mysql_query($query, $db);
		confirm_query($book_set);
		return $book_set;
	}
	
	function get_chapters_for_book($book_id) {
		global $db;
		$query = "SELECT * 
				FROM chapters 
				WHERE book_id = {$book_id} 
				ORDER BY position ASC";
		$chapter_set = mysql_query($query, $db);
		confirm_query($chapter_set);
		return $chapter_set;
	}

	function get_book_by_id($book_id) {
		global $db;
		$query = "SELECT * 
				FROM books 
				ORDER BY position ASC
				WHERE id=" . $book_id . 
				" LIMIT 1";
		$result_set = mysql_query($query, $db);
		confirm_query($book_set);
		if($book = mysql_fetch_array($result_set)) {
			return $book;
		}
		else {
			return NULL;
		}
	}

?>