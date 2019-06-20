<?php
	include 'include/header.php';
?>
<div class="container mt-3">
	<div id="forums">
		<?php
			$forums = $database->prepare('SELECT * FROM forums;');
			$forums->execute();
			while ($forums_row = $forums->fetch(PDO::FETCH_OBJ)) {
		?>
		<div class="card mb-3">
			<div class="card-header">
				<?= $forums_row->name ?>
				<div class="text-muted" style="font-size: 12px;"><?= $forums_row->description ?></div>
			</div>
			<table class="table mb-0">
				<thead style="visibility: collapse;">
					<tr>
						<th scope="col" width="6%" class="text-center">
							Rodzaj
						</th>
						<th scope="col" width="38%">
							Nazwa kategorii
						</th>
						<th scope="col" width="8%" class="text-center">
							Tematów
						</th>
						<th scope="col" width="8%" class="text-center">
							Postów
						</th>
						<th scope="col" width="18%">
							Ostatni post
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$categories = $database->prepare('SELECT * FROM categories WHERE forum_id = ?;');
						$categories->execute(array($forums_row->id));
						while ($categories_row = $categories->fetch(PDO::FETCH_OBJ)) {
					?>
					<tr>
						<td class="text-center">
							<span class="topic">
								<?php
									if ($categories_row->type == 1) {
								?>
								<i class="fas fa-square"></i>
								<?php
									} else if ($categories_row->type == 2) {
								?>
								<i class="far fa-square"></i>
								<?php
									} else if ($categories_row->type == 3) {
								?>
								<i class="fas fa-link"></i>
								<?php
									}
								?>
							</span>
						</td>
						<td>
							<?php
								if ($categories_row->type == 1 || $categories_row->type == 2) {
							?>
							<a href="<?= $config['default']['link'] ?>category.php?forum=<?= $forums_row->id ?>&category=<?= $categories_row->id ?>">
								<b><?= $categories_row->name ?></b>
							</a>
							<?php
								} else if ($categories_row->type == 3) {
							?>
							<a href="<?= $categories_row->link ?>">
								<b><?= $categories_row->name ?></b>
							</a>
							<?php
								}
							?>
							<div class="text-muted">
								<?= $categories_row->description ?>
							</div>
						</td>
						<td class="text-center">
							<div class="text">
								<?= forum_statistics($database, 'topics', $forums_row->id, $categories_row->id) ?>
							</div>
							<div class="text-muted subtext">
								Tematów
							</div>
						</td>
						<td class="text-center">
							<div class="text">
								<?= forum_statistics($database, 'posts', $forums_row->id, $categories_row->id) ?>
							</div>
							<div class="text-muted subtext">
								Postów
							</div>
						</td>
						<td>
							<?php
								$post = $database->prepare('SELECT * FROM posts WHERE forum_id = ? AND category_id = ? ORDER BY id DESC LIMIT 1;');
								$post->execute(array($forums_row->id, $categories_row->id));
								$post_row = $post->fetch(PDO::FETCH_OBJ);
								if (empty($post_row)) {
							?>
							<span class="text-muted">Brak</span>
							<?php
								} else {
									$post_user = $database->prepare('SELECT * FROM users WHERE id = ?;');
									$post_user->execute(array($post_row->user_id));
									$post_user_row = $post_user->fetch(PDO::FETCH_OBJ);

									$topic = $database->prepare('SELECT * FROM topics WHERE forum_id = ? AND category_id = ? ORDER BY id DESC;');
									$topic->execute(array($forums_row->id, $categories_row->id));
									$topic_row = $topic->fetch(PDO::FETCH_OBJ);
							?>
							<div style="display: inline-block;">
								<a href="topic.php?forum=<?= $forums_row->id ?>&category=<?= $categories_row->id ?>&topic=<?= $topic_row->id ?>">
									<b><?= substr($topic_row->name, 0, 20) ?></b>
								</a>
								<br>
								<span class="text-muted" style="font-size: 12px;"><?= formatDate($post_row->created) ?></span>
								<br>
								<span style="font-size: 12px;">Przez: <a href="profile.php?id=<?= $post_user_row->id ?>">
									<b><?= $post_user_row->username ?></b>
								</a></span>
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
		?>
	</div>
	<div id="statistics" class="card mb-3">
		<div class="card-header">
			Statystyki forum
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-4 text-center">
					<div class="text">
						<?= statistics($database, 'users') ?>
					</div>
					<div class="text-muted subtext">
						Użytkowników
					</div>
				</div>
				<div class="col-md-4 text-center">
					<div class="text">
						<?= statistics($database, 'topics') ?>
					</div>
					<div class="text-muted subtext">
						Tematów
					</div>
				</div>
				<div class="col-md-4 text-center">
					<div class="text">
						<?= statistics($database, 'posts') ?>
					</div>
					<div class="text-muted subtext">
						Postów
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	include 'include/footer.php';
?>
