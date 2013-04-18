<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php 
	if(intval($_GET['book'])==0) {
		redirect_to("content.php");
	}
	if(isset($_POST['submit'])) {
		$errors = array();
	
		$required_fields = array('book_name', 'position', 'published');
		foreach($required_fields as $fieldname) {
			if(!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && !is_numeric($_POST[$fieldname]))) {
				$errors[] = $fieldname;
			}
		}

		$fields_with_length = array('book_name' => 30);
		foreach($fields_with_length as $fieldname => $maxlength) {
			if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) {
				$errors[] = $fieldname;
			}
		}
		
		if(empty($errors)) {
			$id = mysql_prep($_GET['book']);
			$book_name = mysql_prep($_POST['book_name']);
			$position = mysql_prep($_POST['position']);
			$published = mysql_prep($_POST['published']);
			
			$query = "UPDATE books SET
						book_name = '{$book_name}',
						position = {$position},
						published = {$published}
					WHERE id = {$id}";
			$result = mysql_query($query, $db);
			if(mysql_affected_rows() == 1) {
				// Success
				$message = "Le livre a ete mis a jour";
			}
			else {
				// Failed
				$message = "Le livre a pas marche";
				$message .= "<br />" . mysql_error();
			}
		}
		else {
			//error
			$message = "Il y avait " . count($errors) . " erreur(s)";
		}
	}
?>
<?php find_selected_page(); ?>
<?php include("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
			<?php echo navigation($sel_book, $sel_chapter); ?>
		</td>
		<td id="chapter">
			<h2> Edit Book: <?php echo $sel_book['book_name'];?> </h2>
			<?php if(!empty($message)) {
				echo "<p class = \"message}\">" . $message . "</p>";
			}?>
			<?php if(!empty($errors)) {
				echo "<p class=\"errors\">";
				echo "Revoyer les plages suivantes:<br />";
				foreach($errors as $error) {
					echo " - " . $error . "<br />";
				}
			} ?>
			<form action="edit_book.php?book=<?php echo urlencode($sel_book['id']);?>" method="post">
				<p> Book Name:
					<input type="text" name="book_name" value="<?php echo $sel_book['book_name'];?>" id="book_name" />
				</p>
					<select name="position"> 
						<?php  
							$book_set = get_all_books();
							$book_count = mysql_num_rows($book_set);
							for($count=1; $count <= $book_count+1; $count++) {
								echo "<option value = \"{$count}\"";
								if($sel_book['position'] == $count) {
									echo " selected";
								}
								echo ">{$count}</option>";
							}
						?>
					</select>
				</p>
				<p> Published:
					<input type="radio" name="published" value="0"<?php 
					if($sel_book['published'] == 0) {echo " checked";}?>  /> No
					&nbsp;
					<input type="radio" name="published" value="1"<?php 
					if($sel_book['published'] == 1) {echo " checked";}?> /> Yes
				</p>
				<input type="submit" name="submit" value="Edit Book" />
				<!-- Remember to make the corresponding chapters disapear also...-->
				&nbsp;&nbsp;
				<a href= "delete_book.php?book=<?php echo urlencode($sel_book['id']);?>"  onclick="return confirm('En etes vous bien sure?');" >Detruire ce livre </a>
			</form> 
				
			<br />
			<a href="content.php">Cancel</a>
		</td>
	</tr>
</table>
<?php require("includes/footer.php"); ?>	