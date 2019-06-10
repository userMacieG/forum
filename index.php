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
			</div>
			<table class="table mb-0">
				<thead>
					<tr>
						<th scope="col" width="8%" class="text-center">
							Rodzaj
						</th>
						<th scope="col" width="50%">
							Nazwa kategorii
						</th>
						<th scope="col" width="10%" class="text-center">
							Tematów
						</th>
						<th scope="col" width="10%" class="text-center">
							Postów
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
								<i class="fas fa-comment-alt"></i>
							</span>
						</td>
						<td>
							<a href="<?= $config['default']['link'] ?>category.php?forum=<?= $forums_row->id ?>&category=<?= $categories_row->id ?>">
								<?= $categories_row->name ?>
							</a>
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
