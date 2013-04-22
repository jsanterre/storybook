<?php
function check_required_fields($required_fields) {
	$errors = array();
	foreach($required_fields as $fieldname) {
			if(!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && !is_numeric($_POST[$fieldname]))) {
				$errors[] = $fieldname;
			}
	}
	return $errors;
}

function check_max_field_lengths($fields_with_length) {
	$errors = array();
	
	foreach($fields_with_length as $fieldname => $maxlength) {
			if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) {
				$errors[] = $fieldname;
			}
	}
	return $errors;
}

function display_errors($errors) {
	echo "<p class=\"errors\">";
	echo "Revoyer les plages suivantes:<br />";
	foreach($errors as $error) {
		echo " - " . $error . "<br />";
	}
}