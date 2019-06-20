<?php
	include 'include/header.php';
?>
<div class="container mt-3">
<?php
	if ($_GET) {
		$forum_id = $_GET['forum'];
		$category_id = $_GET['category'];
		$topic_id = $_GET['topic'];
		$post_id = $_GET['post'];

		$forum = $database->prepare("SELECT * FROM forums WHERE id = ?;");
		$forum->execute(array($forum_id));

		$category = $database->prepare("SELECT * FROM categories WHERE id = ?;");
		$category->execute(array($category_id));

		$topic = $database->prepare("SELECT * FROM topics WHERE id = ?;");
		$topic->execute(array($topic_id));

		$post = $database->prepare("SELECT * FROM posts WHERE id = ?;");
		$post->execute(array($post_id));

		$error = '';

		if (empty($forum_id) || empty($category_id) || empty($post_id) || empty($topic_id)) {
			$error = 'Podane forum, kategoria, temat lub post nie istnieje!';
		} else if ($forum->rowCount() <= 0) {
			$error = 'Podane forum nie istnieje!';
		} else if ($category->rowCount() <= 0) {
			$error = 'Podana kategoria nie istnieje!';
		} else if ($post->rowCount() <= 0) {
			$error = 'Podany post nie istnieje!';
		} else if ($topic->rowCount() <= 0) {
			$error = 'Podany temat nie istnieje!';
		}

		if (empty($error)) {
			if (USER_ID) {
				if (empty($post_error)) {
					$edit_post = $database->prepare("DELETE FROM posts WHERE id = ?;");
					$edit_post->execute(array($post_id));
					alert('success', 'Post został usunięty.');
					header("refresh:2;url={$config['default']['link']}topic.php?forum=$forum_id&category=$category_id&topic=$topic_id");
				} else {
					alert('danger', $post_error);
				}
			} else {
				alert("danger", "Musisz być zalogowany aby usunąć post!");
			}
		} else {
			alert('danger', $error);
		}
	} else {
		alert("danger", "Podane forum, kategoria, temat lub post nie istnieje!");
	}
?>
</div>
<?php
	include 'include/footer.php';
?>
