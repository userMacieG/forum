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

			$category = $database->prepare("SELECT * FROM categories WHERE id = ?;");
			$category->execute(array($category_id));
			$category_row = $category->fetch(PDO::FETCH_OBJ);

			$error = '';

			if (empty($forum_id) || empty($category_id)) {
				$error = 'Podana kategoria lub forum nie istnieje!';
			} else if ($forums->rowCount() <= 0) {
				$error = 'Podana kategoria lub forum nie istnieje!';
			} else if ($category->rowCount() <= 0) {
				$error = 'Podana kategoria lub forum nie istnieje!';
			}

			if (empty($error)) {
				if (USER_ID && $category_row->type != 2) {
	?>
	<div class="mb-3">
		<a class="btn btn-primary" href="<?= $config['default']['link'] ?>new-topic.php?forum=<?= $forum_id ?>&category=<?= $category_id ?>">Stwórz temat</a>
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
					<th scope="col" width="54%">
						Temat
					</th>
					<th scope="col" width="10%" class="text-center">
						Postów
					</th>
					<th scope="col" width="10%" class="text-center">
						Wyświetleń
					</th>
					<th scope="col" width="26%">
						Ostatni post
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
					while ($topics_row = $topics->fetch(PDO::FETCH_OBJ)) {
				?>
				<tr>
					<td>
						<?php if ($topics_row->type == 2) { ?>
						<span class="badge badge-dark"><i class="fas fa-lock"></i></span>
						<?php } ?>
						<a href="<?= $config['default']['link'] ?>topic.php?forum=<?= $forum_id ?>&category=<?= $category_id ?>&topic=<?= $topics_row->id ?>">
							<b><?= $topics_row->name ?></b>
						</a>
						<?php
							$author = $database->prepare("SELECT * FROM users WHERE id = ?;");
							$author->execute(array($topics_row->user_id));
							$author_row = $author->fetch(PDO::FETCH_OBJ);
						?>
						<br>
						Autor: <a href='profile.php?id=<?= $author_row->id ?>'><?= $author_row->username ?></a>
					</td>
					<td class="text-center">
						<?php
							$topics_posts = $database->prepare("SELECT * FROM posts WHERE topic_id = ?;");
							$topics_posts->execute(array($topics_row->id));
							$topics_posts_count = $topics_posts->rowCount();
						?>
						<div style="font-size: 20px; font-weight: 900;">
							<?= $topics_posts_count ?>
						</div>
						<div class="text-muted" style="font-size: 12px;">Postów</div>
					</td>
					<td class="text-center">
						<div style="font-size: 20px; font-weight: 900;">
							<?= $topics_row->views ?>
						</div>
						<div class="text-muted" style="font-size: 12px;">Wyświetleń</div>
					</td>
					<td>
						<?php
							$post = $database->prepare('SELECT * FROM posts WHERE forum_id = ? AND category_id = ? ORDER BY id DESC LIMIT 1;');
							$post->execute(array($forum_id, $category_id));
							$post_row = $post->fetch(PDO::FETCH_OBJ);
							if (empty($post_row)) {
						?>
						<span class="text-muted">Brak</span>
						<?php
							} else {
								$post_user = $database->prepare('SELECT * FROM users WHERE id = ?;');
								$post_user->execute(array($post_row->user_id));
								$post_user_row = $post_user->fetch(PDO::FETCH_OBJ);
						?>
						<div style="display: inline-block;">
							<a href="profile.php?id=<?= $post_user_row->id ?>">
								<b><?= $post_user_row->username ?></b>
							</a>
							<br>
							<span class="text-muted"><?= $post_row->created ?></span>
						</div>
						<canvas class="user-icon rounded" data-name="<?= $post_user_row->username ?>" width="42" height="42" style="float: left; display: inline-block; margin-right: 6px;" data-chars="1"></canvas>
						<?php
							}
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
