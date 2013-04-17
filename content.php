<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
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
			<?php 
				if(!is_null($sel_book)) { echo "<h2>{$sel_book['book_name']}</h2>";}
				elseif(!is_null($sel_chapter)) {echo $sel_chapter['chapter_name'];?>
				<div class="chapter-content">
					<?php echo $sel_chapter['content'];} 
				else{echo "Select a chapter";}
			?> 
		</td>
	</tr>
</table>
<?php require("includes/footer.php"); ?>	