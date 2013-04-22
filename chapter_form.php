<?php if(!isset($new_chapter)) {$new_chapter = false;} ?>

<p> Chapter Name: <input type="text" name="chapter_name" value="<?php echo $sel_chapter['chapter_name'];?>" id="chapter_name" /></p>
	<select name="position"> 
		<?php  
			if(!$new_chapter) {
				$chapter_set = get_chapters_for_book($sel_chapter['book_id']);
				$chapter_count = mysql_num_rows($chapter_set);
			}
			else {
				$chapter_set = get_chapters_for_book($sel_book['id']);
				$chapter_count = mysql_num_rows($chapter_set)+1;
			}
			for($count=1; $count <= $chapter_count; $count++) {
				echo "<option value = \"{$count}\"";
				if($sel_chapter['position'] == $count) {
					echo " selected";
				}
				echo ">{$count}</option>";
			}
		?>
	</select>
</p>
<p> Published:
	<input type="radio" name="published" value="0"<?php 
	if($sel_chapter['published'] == 0) {echo " checked";}?>  /> No
	&nbsp;
	<input type="radio" name="published" value="1"<?php 
	if($sel_chapter['published'] == 1) {echo " checked";}?> /> Yes
</p>
<p>Content:<br />
	<textarea name="content" rows="8" cols="80"><?php echo $sel_chapter['content'];?></textarea>
</p>