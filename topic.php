<?php
	include 'header.php';
?>
<div class="container mt-3">
<?php
	if ($_GET) {

		$forum_id = $_GET['forum'];
		$category_id = $_GET['category'];

		if (empty($forum_id) || empty($category_id)) {
			alert("danger", "Podane forum lub kategoria nie istnieje!");
			return;
		}

		$forum = mysqli_query($database, "select * from `forums` where id='".$forum_id."';");
		if (mysqli_num_rows($forum) == 0) {
			alert("danger", "Podane forum nie istnieje!");
			return;
		}

		$category = mysqli_query($database, "select * from `categories` where id='".$category_id."';");
		if (mysqli_num_rows($category) == 0) {
			alert("danger", "Podana kategoria nie istnieje!");
			return;
		}

		if (isset($user_id)) {
			if (isset($_POST['post'])) {
				$title = $_POST['title'];
				if (empty($title)) {
					alert("danger", "Uzupełnij tytuł tematu!");
					return;
				}

				$content = $_POST['content'];
				if (empty($content)) {
					alert("danger", "Uzupełnij treść tematu!");
					return;
				}

				mysqli_query($database, "insert into `topics` values (null, '".$title."', '".$category_id."', '".$forum_id."', '".$user_id."');");
				$topic_id = mysqli_insert_id($database);
				mysqli_query($database, "insert into `posts` values (null, '".$forum_id."', '".$category_id."', '".$topic_id."', '".$user_id."', '".$content."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."');");
				alert("success", "Temat został utworzony.");
				header("refresh:2;url=post.php?forum=".$forum_id."&category=".$category_id."&topic=".$topic_id);
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
		}
	} else {
		alert("danger", "Podane forum lub kategoria nie istnieje!");
		return;
	}
?>
</div>
<?php
	include 'footer.php';

	mysqli_close($database);
?>
