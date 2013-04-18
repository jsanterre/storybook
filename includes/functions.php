<?php 
	function mysql_prep($value) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysql_real_escape_string" );
		
		if($new_enough_php) {
			if($magic_quotes_active) { $value = stripslashes($value); }
			$value = mysql_real_escape_string ($value);
		}
		else {
			if(!$magic_quotes_active) { $value = addslashes($value); }
		}
		return $value;
	}
	
	function redirect_to($location = NULL) {
		if($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}

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
				WHERE id=" . $book_id . " LIMIT 1";
		$result_set = mysql_query($query, $db);
		confirm_query($result_set);
		if($book = mysql_fetch_array($result_set)) {
			return $book;
		}
		else {
			return NULL;
		}
	}
	
	function get_chapter_by_id($chapter_id) {
		global $db;
		$query = "SELECT * 
				FROM chapters 
				WHERE id=" . $chapter_id . " LIMIT 1";
		$result_set = mysql_query($query, $db);
		confirm_query($result_set);
		if($chapter = mysql_fetch_array($result_set)) {
			return $chapter;
		}
		else {
			return NULL;
		}
	}

	function find_selected_page() {
		global $sel_book;
		global $sel_chapter;
		$sel_book = NULL;
		$sel_chapter = NULL;
		if(isset($_GET['book'])) {
			$sel_book = get_book_by_id($_GET['book']);
		}
		if(isset($_GET['chapter'])) {
			$sel_chapter = get_chapter_by_id($_GET['chapter']);
		}
	}
	
	function navigation($sel_book, $sel_chapter) {
		$output = "<ul class=\"books\">";
				
		$book_set = get_all_books();
			while($book = mysql_fetch_array($book_set)) {
				$output .= "<li";
				if($book['id'] == $sel_book['id']) { $output.= " class = \"selected\""; }
				$output.= "><a href=\"edit_book.php?book=" . urlencode($book['id']) . "\">{$book['book_name']}</a></li>";
				$chapter_set = get_chapters_for_book($book['id']);
				$output.= "<ul class=\"chapters\">";
				while($chapter = mysql_fetch_array($chapter_set)) {
					$output.= "<li";
					if($chapter['id'] == $sel_chapter['id']) { $output.= " class = \"selected\""; }
					$output.= "><a href=\"content.php?book=" . urlencode($book['id']) . "&chapter=" . urlencode($chapter['id']) . "\">{$chapter['chapter_name']}</a></li>";
				}
				$output.= "</ul>";
			}
			$output.= "</ul>";
			return $output;
	}
?>