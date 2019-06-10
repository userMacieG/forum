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
					<th scope="col" width="50%">
						Nazwa użytkownika
					</th>
					<th scope="col" width="50%">
						Grupa
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
						<a href="<?= $config['default']['link'] ?>profile.php?id=<?= $members_row->id ?>">
							<b><?= $members_row->username ?></b>
						</a>
					</td>
					<td>
						<?php
							$group = $database->prepare("SELECT * FROM groups WHERE id = ?;");
							$group->execute(array($members_row->group_id));
							$group_row = $group->fetch(PDO::FETCH_OBJ);
							echo "<span class='badge badge-dark'>{$group_row->name}</span>";
						?>
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
