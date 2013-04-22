<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/form_functions.php"); ?>
<?php 
	if(intval($_GET['chapter'])==0) {
		redirect_to("content.php");
	}
	if(isset($_POST['submit'])) {
		$errors = array();
	
		$required_fields = array('chapter_name', 'position', 'published', 'content');
		$errors = array_merge($errors, check_required_fields($required_fields));
		
		$fields_with_length = array('chapter_name' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_length));
		
		if(empty($errors)) {
			$id = mysql_prep($_GET['chapter']);
			$chapter_name = trim(mysql_prep($_POST['chapter_name']));
			$position = mysql_prep($_POST['position']);
			$published = mysql_prep($_POST['published']);
			$content = mysql_prep($_POST['content']);
			
			$query = "UPDATE chapters SET
						chapter_name = '{$chapter_name}',
						position = {$position},
						published = {$published},
						content = '{$content}'
					WHERE id = {$id}";
			$result = mysql_query($query, $db);
			if(mysql_affected_rows() == 1) {
				// Success
				$message = "Le chapitre a ete mis a jour";
			}
			else {
				// Failed
				$message = "Le chapitre n'a pas ete modifie";
				$message .= "<br />" . mysql_error();
			}
		}
		else {
			//error
			if(count($errors) == 1) {
				$message = "Il y avait une erreur";
			}
			else {
				$message = "Il y avait " . count($errors) . " erreur(s)";
			}
		}
	}
?>
<?php find_selected_page(); ?>
<?php include("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
			<?php echo navigation($sel_book, $sel_chapter); ?>
			<br />
			<a href="new_book.php">+ Add a new Book</a>
		</td>
		<td id="chapter">
			<h2> Edit Chapter: <?php echo $sel_chapter['chapter_name'];?> </h2>
			<?php if(!empty($message)) {
				echo "<p class = \"message}\">" . $message . "</p>";
			}?>
			<?php if(!empty($errors)) {
				display_errors($errors);
			} ?>
			<form action="edit_chapter.php?chapter=<?php echo urlencode($sel_chapter['id']);?>" method="post">
				<?php include "chapter_form.php" ?>
				<input type="submit" name="submit" value="Edit Chapter" />
				<!-- Remember to make the corresponding chapters disapear also...-->
				&nbsp;&nbsp;
				<a href= "delete_book.php?book=<?php echo urlencode($sel_book['id']);?>"  onclick="return confirm('En etes vous bien sure?');" >Detruire ce chapitre</a>
			</form> 
				
			<br />
			<a href="content.php">Cancel</a>
		</td>
	</tr>
</table>
<?php require("includes/footer.php"); ?>	