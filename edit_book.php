<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/form_functions.php"); ?>
<?php 
	if(intval($_GET['book'])==0) {
		redirect_to("content.php");
	}
	if(isset($_POST['submit'])) {
		$errors = array();
	
		$required_fields = array('book_name', 'position', 'published');
		$errors = array_merge($errors, check_required_fields($required_fields));
		
		$fields_with_length = array('book_name' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_length));
		
		if(empty($errors)) {
			$id = mysql_prep($_GET['book']);
			$book_name = trim(mysql_prep($_POST['book_name']));
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
				$message = "Le livre n'a pas ete modifie";
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
			<br />
			<a href="new_book.php">+ Add a new Book</a>
		</td>
		<td id="chapter">
			<h2> Edit Book: <?php echo $sel_book['book_name'];?> </h2>
			<?php if(!empty($message)) {
				echo "<p class = \"message}\">" . $message . "</p>";
			}?>
			<?php if(!empty($errors)) {
				display_errors($errors);
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
				<a href= "delete_book.php?book=<?php echo urlencode($sel_book['id']);?>"  onclick="return confirm('En etes vous bien sure?');" >Detruire ce livre</a>
			</form> 
				
			<br />
			<a href="content.php">Cancel</a>
			<div style="margin-top: 2em; border-top: 1px solid #000000;">
				<h3>Chapters in this book:</h3>
				<ul>
				<?php 
					$book_chapters = get_chapters_for_book($sel_book['id']);
					while($chapter = mysql_fetch_array($book_chapters)) {
						echo "<li> <a href=\"content.php?chapter={$chapter['id']}\">{$chapter['chapter_name']}</a></li>";
					}
				?>
				</ul>
				<br />
				+ <a href="new_chapter.php?book=<? echo $sel_book['id']; ?>">Add a new chapter for this book</a>
			</div>
		</td>
	</tr>
</table>
<?php require("includes/footer.php"); ?>	