<?php
	include 'include/header.php';
?>
<div class="container mt-3">
	<?php
		if ($_GET) {
			$forum_id = $_GET['forum'];
			$category_id = $_GET['category'];
			$topic_id = $_GET['topic'];

			$forum = $database->prepare("SELECT * FROM forums WHERE id = ?;");
			$forum->execute(array($forum_id));

			$category = $database->prepare("SELECT * FROM categories WHERE id = ?;");
			$category->execute(array($category_id));

			$topic = $database->prepare("SELECT * FROM topics WHERE id = ?;");
			$topic->execute(array($topic_id));

			$error = '';

			if (empty($forum_id) || empty($category_id) || empty($topic_id)) {
				$error = 'Podane forum, kategoria lub temat nie istnieje!';
			} else if ($forum->rowCount() <= 0) {
				$error = 'Podane forum nie istnieje!';
			} else if ($category->rowCount() <= 0) {
				$error = 'Podana kategoria nie istnieje!';
			} else if ($topic->rowCount() <= 0) {
				$error = 'Podany temat nie istnieje!';
			}

			if (empty($error)) {
	?>
	<div class="card mb-3">
		<div class="card-body">
			<?php
				$topic_info = $database->prepare("SELECT * FROM topics WHERE id = ?;");
				$topic_info->execute(array($topic_id));
				$topic_row = $topic_info->fetch(PDO::FETCH_OBJ);
				echo '<div style="display: inline-block;"><h4 class="mb-0">Temat: <b>'.$topic_row->name.'</b></h4>';

				$author_topic = $database->prepare("SELECT * FROM users WHERE id = ?;");
				$author_topic->execute(array($topic_row->user_id));
				$author_topic_row = $author_topic->fetch(PDO::FETCH_OBJ);
				echo '<h6 class="mb-0">Autor: <a href="profile.php?id='.$author_topic_row->id.'"><b>'.$author_topic_row->username.'</b></a></h6></div>';
				echo '<canvas class="user-icon rounded" data-name="'.$author_topic_row->username.'" width="48" height="48" style="float: left; display: inline-block; margin-right: 10px;" data-chars="1"></canvas>';
			?>
		</div>
	</div>
	<?php
		$posts = $database->prepare("SELECT * FROM posts WHERE category_id = ? AND forum_id = ? AND topic_id = ?;");
		$posts->execute(array($category_id, $forum_id, $topic_id));
		while ($posts_row = $posts->fetch(PDO::FETCH_OBJ)) {
	?>
	<div class="mb-3">
		<div class="card">
			<div class="card-body">
				<?php
					$author = $database->prepare("SELECT * FROM users WHERE id = ?;");
					$author->execute(array($posts_row->user_id));
					$author_row = $author->fetch(PDO::FETCH_OBJ);
					echo '<div style="display: inline-block; width: 100%;"><a href="profile.php?id='.$author_row->id.'"><b>'.$author_row->username.'</b></a>';
					echo '<canvas class="user-icon rounded" data-name="'.$author_row->username.'" width="38" height="38" style="float: left; margin-right: 6px;" data-chars="1"></canvas>';

					if ($posts_row->created == $posts_row->modified) {
				?>
				<div class="text-muted" style="font-size: 12px;">
					<?= $posts_row->created ?>
				<?php
					} else {
				?>
				<div class="text-muted" style="font-size: 12px;">
					<?= $posts_row->modified ?> <i class="fas fa-edit"></i>
				<?php
					}
				?>
				</div>
				<div class="mt-3">
					<?= $posts_row->content ?>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php
		}

		if (USER_ID) {
			if (isset($_POST['post'])) {
				$content = $_POST['content'];

				$post_error = [];

				if (empty($content)) {
					$post_error = 'Uzupełnij treść odpowiedzi!';
				} else if (strlen($content) < 12) {
					$post_error = 'Treść odpowiedzi jest zbyt krótka! Minimalna długość to 12 znaki';
				} else if (strlen($content) > 64000) {
					$post_error = 'Treść odpowiedzi jest zbyt długa! Maksymalna długość to 64,000 znaki.';
				}

				if (empty($post_error)) {
					$new_post = $database->prepare("INSERT INTO posts VALUES (NULL, ?, ?, ?, ?, ?, NOW(), NOW());");
    				$new_post->execute(array($forum_id, $category_id, $topic_id, USER_ID, $content));
					header('refresh:0');
				} else {
					alert('danger', $post_error);
				}
			}
	?>
	<div class="card mb-3">
		<div class="card-body">
			<form method="post">
				<textarea name="content" class="form-control" placeholder="Treść posta..." rows="6"></textarea>
				<br>
				<button name="post" class="btn btn-outline-primary btn-block">Dodaj post</button>
			</form>
			<script>
				CKEDITOR.replace('content');
			</script>
		</div>
	</div>
	<?php
				}
			} else {
				alert('danger', $error);
			}
		} else {
			alert('danger', 'Podane forum, kategoria lub temat nie istnieje!');
		}
	?>
</div>
<?php
	include 'include/footer.php';
?>
