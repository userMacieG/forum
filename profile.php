<?php
	include 'include/header.php';
?>
<div class="container mt-3">
	<?php
		if ($_GET) {
			$profile_id = (isset($_GET['id'])) ? $_GET['id'] : '';

			$profile = $database->prepare("SELECT * FROM users WHERE id = ?;");
			$profile->execute(array($profile_id));

			$profile_row = $profile->fetch(PDO::FETCH_OBJ);

			$error = '';

			if (empty($profile_id)) {
				$error = 'Podane konto nie istnieje!';
			} else if ($profile->rowCount() <= 0) {
				$error = 'Podane konto nie istnieje!';
			}

			if (empty($error)) {
	?>
	<div class="card mb-3">
		<div class="card-header">
			Profil
		</div>
		<div class="card-body">
			<canvas class='user-icon rounded' data-name='<?= $profile_row->username ?>' width='22' height='22' style='margin-bottom: -6px;' data-chars='1'></canvas> <b><?= $profile_row->username ?></b>
			<br>
			<br>
			Grupa:
			<?php
				$group = $database->prepare("SELECT * FROM groups WHERE id = ?;");
				$group->execute(array($profile_row->group_id));
				$group_row = $group->fetch(PDO::FETCH_OBJ);
			?>
			<span class="badge badge-<?= $group_row->color ?>"><?= $group_row->name ?></span>
			<br>
			Email: <b><?= $profile_row->email ?></b>
		</div>
	</div>
	<?php
			} else {
				alert('danger', $error);
			}
		} else {
			alert("danger", "Podane konto nie istnieje!");
		}
	?>
</div>
<?php
	include 'include/footer.php';
?>
