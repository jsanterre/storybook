<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php find_selected_page(); ?>
<?php include("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="booknav">
			<?php echo book_navigation($sel_book); ?>
			<br />
			<a href="new_book.php">+ Add a new Book</a>
		</td>
		<td id="content">
			<table>
			<tr><td>
			<?php 
					if(!is_null($sel_book)) {
						echo "<h2>{$sel_book['book_name']}</h2>";
					}
					else {
						echo "<h2>Selectionner un livre</h2>";
					}
			?>
				
			<div class="chaptercontent">
				<?php 
				if(!is_null($sel_book)) {
					if(is_null($sel_chapter)) {
						echo "<h3>Description</h3>";
						echo $sel_book['book_description'];
					}
					else {
						echo "<h3>Chapitre ". $sel_chapter['position'] . "</h3><h3>" . $sel_chapter['chapter_name'] . "</h3>";
						echo $sel_chapter['content']; 
						echo "<br /><a href=\"edit_chapter.php?book=" . urlencode($sel_book['id']) . "&chapter=" . urlencode($sel_chapter['id'])  . "\">Editer</a>";
					}	
				}
				?> 
			</div>
			</td></tr>
			<tr><td>
			<div class="chapternav">
				<?php 
					if(!is_null($sel_book)) {
						echo chapter_navigation($sel_book, $sel_chapter); 
					}
				?>
			</div>
			</td></tr>
			</table>
		</td>
	</tr>
</table>
<?php require("includes/footer.php"); ?>	