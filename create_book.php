<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php 
	$errors = array();
	
	if(!isset($_POST['book_name']) || empty($_POST['book_name'])) {
		$errors[] = 'book_name';
	}
	if(!empty($errors)) {
		redirect_to("new_book.php");
	}
?>
<?php
	$book_name = mysql_prep($_POST['book_name']);
	$position = mysql_prep($_POST['position']);
	$visible = mysql_prep($_POST['visible']);
?>
<?php
	$query = "INSERT INTO books (book_name, position, visible)
			VALUES ('{$book_name}', {$position}, {$visible})";
			
	if(mysql_query($query, $db)) {
		header("Location: content.php");
		exit;
	}
	else {
		echo "<p> Subject creation failed.</p>";
		echo "<p>" . mysql_error() . "</p>";
	}
		

?>





<?php mysql_close($db); ?>