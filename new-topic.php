<?php
	include 'include/header.php';
?>
<div class="container mt-3">
<?php
	if ($_GET) {

		$forum_id = $_GET['forum'];
		$category_id = $_GET['category'];

		$forum = $database->prepare("SELECT * FROM forums WHERE id = ?;");
		$forum->execute(array($forum_id));

		$category = $database->prepare("SELECT * FROM categories WHERE id = ?;");
		$category->execute(array($category_id));

		$error = '';

		if (empty($forum_id) || empty($category_id)) {
			$error = 'Podane forum lub kategoria nie istnieje!';
		} else if ($forum->rowCount() <= 0) {
			$error = 'Podane forum nie istnieje!';
		} else if ($category->rowCount() <= 0) {
			$error = 'Podana kategoria nie istnieje!';
		}

		if (empty($error)) {
			if (USER_ID) {
				if (isset($_POST['post'])) {
					$title = $_POST['title'];

					$content = $_POST['content'];

					$post_error = [];

					if (empty($title)) {
						$post_error = 'Uzupełnij tytuł tematu!';
					} else if (strlen($title) < 12) {
						$post_error = 'Temat jest zbyt krótki! Minimalna długość to 12 znaki';
					} else if (strlen($title) > 124) {
						$post_error = 'Temat jest zbyt długi! Maksymalna długość to 124 znaki.';
					} else if (empty($content)) {
						$post_error = 'Uzupełnij treść tematu!';
					} else if (strlen($content) < 12) {
						$post_error = 'Treść tematu jest zbyt krótka! Minimalna długość to 12 znaki';
					} else if (strlen($content) > 64000) {
						$post_error = 'Treść tematu jest zbyt długa! Maksymalna długość to 64,000 znaki.';
					}

					if (empty($post_error)) {
						$new_topic = $database->prepare("INSERT INTO topics VALUES (NULL, ?, ?, ?, ?);");
						$new_topic->execute(array($title, $category_id, $forum_id, USER_ID));
						$topic_id = $database->lastInsertId();
						$new_post = $database->prepare("INSERT INTO posts VALUES (NULL, ?, ?, ?, ?, ?, NOW(), NOW());");
						$new_post->execute(array($forum_id, $category_id, $topic_id, USER_ID, $content));
						alert('success', 'Temat został utworzony.');
						header('refresh:2;url=topic.php?forum='.$forum_id.'&category='.$category_id.'&topic='.$topic_id);
					} else {
						alert('danger', $post_error);
					}
				}
	?>
	<div class="card mb-3">
		<div class="card-body text-center">
			<form method="post">
				<input name="title" class="form-control" placeholder="Tytuł tematu">
				<br>
				<textarea name="content" class="form-control" placeholder="Treść posta..." rows="6"></textarea>
				<br>
				<button name="post" class="btn btn-outline-primary btn-block">Utwórz temat</button>
			</form>
			<script>
                CKEDITOR.replace('content');
            </script>
		</div>
	</div>
<?php
			} else {
				alert("danger", "Musisz być zalogowany aby stworzyć nowy temat!");
			}
		} else {
			alert('danger', $error);
		}
	} else {
		alert("danger", "Podane forum lub kategoria nie istnieje!");
	}
?>
</div>
<?php
	include 'include/footer.php';
?>
