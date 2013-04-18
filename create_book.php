<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php 
	$errors = array();
	
	$required_fields = array('book_name', 'position', 'published');
	foreach($required_fields as $fieldname) {
		if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
			$errors[] = $fieldname;
		}
	}

	$fields_with_length = array('book_name' => 30);
	foreach($fields_with_length as $fieldname => $maxlength) {
		if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) {
			$errors[] = $fieldname;
		}
	}
	
	if(!empty($errors)) {
		redirect_to("new_book.php");
	}
?>
<?php
	$book_name = mysql_prep($_POST['book_name']);
	$position = mysql_prep($_POST['position']);
	$published = mysql_prep($_POST['published']);
?>
<?php
	$query = "INSERT INTO books (book_name, position, published)
			VALUES ('{$book_name}', {$position}, {$published})";
			
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