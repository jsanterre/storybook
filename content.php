<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php 
	if(isset($_GET['book'])) {
		$sel_book = $_GET['book'];
		$sel_chapter = "";
	}
	elseif(isset($_GET['chapter'])) {
		$sel_chapter = $_GET['chapter'];
		$sel_book = "";
	}
	else {
		$sel_book = "";
		$sel_chapter = "";
	}
?>
<?php include("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
			<ul class="books">
				<?php
					$book_set = get_all_books();
					while($book = mysql_fetch_array($book_set)) {
						echo "<li";
						if($book['id'] == $sel_book) { echo " class = \"selected\""; }
						echo "><a href=\"content.php?book=" . urlencode($book['id']) . "\">{$book['book_name']}</a></li>";
						$chapter_set = get_chapters_for_book($book['id']);
						echo "<ul class=\"chapters\">";
						while($chapter = mysql_fetch_array($chapter_set)) {
							echo "<li";
							if($chapter['id'] == $sel_chapter) { echo " class = \"selected\""; }
							echo "><a href=\"content.php?chapter=" . urlencode($chapter['id']) . "\">{$chapter['chapter_name']}</a></li>";
						}
						echo "</ul>";
					}
				?>
			</ul>
		</td>
		<td id="chapter">
			<h2>Content Area</h2>
			<?php echo $sel_book;?> <br />
			<?php echo $sel_chapter;?> <br />
		</td>
	</tr>
</table>
<?php require("includes/footer.php"); ?>	