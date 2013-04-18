<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php find_selected_page(); ?>
<?php include("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
			<?php echo navigation($sel_book, $sel_chapter); ?>
		</td>
		<td id="chapter">
			<h2> Add a Book </h2>
			<form action="create_book.php" method="post">
				<p> Book Name:
					<input type="text" name="book_name" value="" id="book_name" />
				</p>
					<select name="position"> 
						<?php  
							$book_set = get_all_books();
							$book_count = mysql_num_rows($book_set);
							for($count=1; $count <= $book_count+1; $count++) {
								echo "<option value = \"{$count}\">{$count}</option>";
							}
						?>
					</select>
				</p>
				<p> Published:
					<input type="radio" name="published" value="0" /> No
					&nbsp;
					<input type="radio" name="published" value="1" /> Yes
				</p>
				<input type="submit" value="Add Book" />
			</form>
				
			<br />
			<a href="content.php">Cancel</a>
		</td>
	</tr>
</table>
<?php require("includes/footer.php"); ?>	