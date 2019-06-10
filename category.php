<?php
	include 'include/header.php';
?>
<div class="container mt-3">
	<?php
		if ($_GET) {

			$forum_id = $_GET['forum'];
			$category_id = $_GET['category'];

			$forums = $database->prepare("SELECT * FROM forums WHERE id = ?;");
			$forums->execute(array($forum_id));

			$categories = $database->prepare("SELECT * FROM categories WHERE id = ?;");
			$categories->execute(array($category_id));

			$error = '';

			if (empty($forum_id) || empty($category_id)) {
				$error = 'Podana kategoria lub forum nie istnieje!';
			} else if ($forums->rowCount() <= 0) {
				$error = 'Podana kategoria lub forum nie istnieje!';
			} else if ($categories->rowCount() <= 0) {
				$error = 'Podana kategoria lub forum nie istnieje!';
			}

			if (empty($error)) {
				if (USER_ID) {
	?>
	<div class="mb-3">
		<a class="btn btn-primary" href="new-topic.php?forum=<?= $forum_id ?>&category=<?= $category_id ?>">Stwórz temat</a>
	</div>
	<?php
		}
	?>
	<?php
		$topics = $database->prepare("SELECT * FROM topics WHERE forum_id = ? AND category_id = ?;");
		$topics->execute(array($forum_id, $category_id));
		if ($topics->rowCount() <= 0) {
			alert('info', 'Podana kategoria nie zawiera żadnych tematów.<br>Stwórz temat aby być pierwszym!');
		} else {
	?>
	<div class="card mb-3">
		<table class="table mb-0">
			<thead>
				<tr>
					<th scope="col" width="68%">
						Nazwa tematu
					</th>
					<th scope="col" width="10%" class="text-center">
						Postów
					</th>
					<th scope="col" width="22%">
						Autor
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
					while ($topics_row = $topics->fetch(PDO::FETCH_OBJ)) {
				?>
				<tr>
					<td>
						<a href="topic.php?forum=<?= $forum_id ?>&category=<?= $category_id ?>&topic=<?= $topics_row->id ?>"><?= $topics_row->name ?></a>
					</td>
					<td class="text-center">
						<?php
							$topics_posts = $database->prepare("SELECT * FROM posts WHERE topic_id = ?;");
							$topics_posts->execute(array($topics_row->id));
							$topics_posts_count = $topics_posts->rowCount();
							echo '<div style="font-size: 20px; font-weight: 900;">'.$topics_posts_count.'</div><div class="text-muted" style="font-size: 12px;">Postów</div>';
						?>
					</td>
					<td>
						<?php
							$author = $database->prepare("SELECT * FROM users WHERE id = ?;");
							$author->execute(array($topics_row->user_id));
							$author_row = $author->fetch(PDO::FETCH_OBJ);
							echo '<div style="display: inline-block;"><a href="profile.php?id='.$author_row->id.'"><b>'.$author_row->username.'</b></a></div>';
							echo '<canvas class="user-icon rounded" data-name="'.$author_row->username.'" width="42" height="42" style="float: left; display: inline-block; margin-right: 6px;" data-chars="1"></canvas>';
						?>
					</td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
	<?php
				}
			} else {
				alert('danger', $error);
			}
		} else {
			alert('danger', 'Podana kategoria lub forum nie istnieje!');
		}
	?>
</div>
<?php
	include 'include/footer.php';
?>
