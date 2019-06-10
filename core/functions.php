<?php
	function alert($type, $text) {
		echo "<div class='alert alert-{$type}' role='alert'>{$text}</div>";
	}

	function statistics($database, $table) {
		$table_query = $database->prepare("SELECT * FROM {$table};");
		$table_query->execute();
		$result = $table_query->rowCount();
		return $result;
	}

	function forum_statistics($database, $table, $forum_id, $category_id) {
		$table_query = $database->prepare("SELECT * FROM {$table} WHERE forum_id = ? AND category_id = ?;");
		$table_query->execute(array($forum_id, $category_id));
		$result = $table_query->rowCount();
		return $result;
	}
?>
