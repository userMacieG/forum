<?php
	include 'header.php';
?>
<div class="container mt-3">
<?php
	if ($_GET) {

		$forum_id = @$_GET['forum'];
		$category_id = @$_GET['category'];
		$topic_id = @$_GET['topic'];

		if (empty($forum_id) || empty($category_id) || empty($topic_id)) {
			alert("danger", "Podane forum, kategoria lub temat nie istnieje!");
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

		$topic = mysqli_query($database, "select * from `topics` where id='".$topic_id."';");
		if (mysqli_num_rows($topic) == 0) {
			alert("danger", "Podany temat nie istnieje!");
			return;
		}
?>
<div class="card mb-3">
	<div class="card-body">
		<?php
			$topicInfo = mysqli_query($database, "select * from `topics` where id='".$topic_id."';");
			$topicRow = mysqli_fetch_assoc($topicInfo);
			echo "<div style='display: inline-block;'><h4 class='mb-0'>Temat: <b>".$topicRow['name']."</b></h4>";
			$authorTopic = mysqli_query($database, "select * from `users` where id='".$topicRow['user_id']."';");
			$authorTopicRow = mysqli_fetch_assoc($authorTopic);
			echo "<h6 class='mb-0'>Autor: <a href='profile.php?id=".$authorTopicRow['id']."'><b>".$authorTopicRow['username']."</b></a></h6></div>";
			echo "<canvas class='user-icon rounded' data-name='".$authorTopicRow['username']."' width='48' height='48' style='float: left; display: inline-block; margin-right: 10px;' data-chars='1'></canvas>";
		?>
	</div>
</div>
	<?php
		$posts = mysqli_query($database, "select * from `posts` where category_id='".$category_id."' and forum_id='".$forum_id."' and topic_id='".$topic_id."';");
		while ($postsRow = mysqli_fetch_array($posts)) {
	?>
					<div id="post_<?php echo $postsRow['id']; ?>" class="mb-3">
						<div class="card">
							<div class="card-body">
								<?php
									$author = mysqli_query($database, "select * from `users` where id='".$postsRow['user_id']."';");
									$authorRow = mysqli_fetch_assoc($author);
									echo "<div style='display: inline-block; width: 100%;'><a href='profile.php?id=".$authorRow['id']."'><b>".$authorRow['username']."</b></a>";
									echo "<canvas class='user-icon rounded' data-name='".$authorRow['username']."' width='38' height='38' style='float: left; margin-right: 6px;' data-chars='1'></canvas>";

									if ($postsRow['created'] == $postsRow['modified']) {
										echo "<div class='text-muted' style='font-size: 12px;'>".$postsRow['created']."</div>";
									} else {
										echo "<div class='text-muted' style='font-size: 12px;'>".$postsRow['modified']." <i class='fas fa-edit'></i></div>";
									}

									echo "<br><div>".$postsRow['content']."</div>";
								?>
								</div>
							</div>
						</div>
					</div>
	<?php
		}

		if (isset($user_id)) {
			if (isset($_POST['post'])) {
				$content = $_POST['content'];
				if (empty($content)) {
					alert("danger", "Uzupełnij treść odpowiedzi!");
					return;
				}

				mysqli_query($database, "insert into `posts` values (null, '".$forum_id."', '".$category_id."', '".$topic_id."', '".$user_id."', '".$content."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."');");
				header("Refresh:0");
			}
	?>
	<div class="card mb-3">
		<div class="card-body text-center">
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
		alert("danger", "Podane forum, kategoria lub temat nie istnieje!");
		return;
	}
?>
</div>
<?php
	include 'footer.php';

	mysqli_close($database);
?>
