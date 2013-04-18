<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php 
	if(intval($_GET['book'])==0) {
		redirect_to("content.php");
	}
	$id = mysql_prep($_GET['book']);
	if($book = get_book_by_id($id)) {
	
		$query  = "DELETE FROM books WHERE id = {$id} LIMIT 1";
		$result = mysql_query($query, $db);
		if(mysql_affected_rows() == 1) {
			redirect_to("content.php");
		}
		else {
			echo "<p> Incapable de detruire. </p>";
			echo "<p>" . mysql_error() . "<p>";
			echo "<a href=\"content.php\">Retourner a la page principale</a>";
		}
	}
	else {
		redirect_to("content.php");
	}
?>

<?php mysql_close($db); ?>