<?php
	include 'include/header.php';
?>
<div class="container mt-3">
	<div class="card mb-3">
		<div class="card-header">
			Lista użytkowników
		</div>
		<table class="table mb-0">
			<thead>
				<tr>
					<th scope="col" width="35%">
						Nazwa użytkownika
					</th>
					<th scope="col" width="30%">
						Grupa
					</th>
					<th scope="col" width="35%">
						Email
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$members = $database->prepare("SELECT * FROM users;");
					$members->execute();
					while ($members_row = $members->fetch(PDO::FETCH_OBJ)) {
				?>
				<tr>
					<td>
						<canvas class='user-icon rounded' data-name='<?= $members_row->username ?>' width='22' height='22' style='float: left; display: inline-block; margin-right: 6px;' data-chars='1'></canvas>
						<a href="<?= $config['default']['link'] ?>profile.php?id=<?= $members_row->id ?>">
							<b><?= $members_row->username ?></b>
						</a>
					</td>
					<td>
						<?php
							$group = $database->prepare("SELECT * FROM groups WHERE id = ?;");
							$group->execute(array($members_row->group_id));
							$group_row = $group->fetch(PDO::FETCH_OBJ);
						?>
						<span class="badge badge-<?= $group_row->color ?>"><?= $group_row->name ?></span>
					</td>
					<td>
						<?= $members_row->email ?>
					</td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
	include 'include/footer.php';
?>
