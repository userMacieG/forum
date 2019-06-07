<?php
	include 'header.php';
?>
<div class="container mt-3">
<?php
	if ($_GET) {

		$profile_id = $_GET['id'];

		if (empty($profile_id)) {
			alert("danger", "Podane konto nie istnieje!");
			return;
		}

		$profile = mysqli_query($database, "select * from `users` where id='".$profile_id."';");
		if (mysqli_num_rows($profile) == 0) {
			alert("danger", "Podane konto nie istnieje!");
			return;
		}

		$profileRow = mysqli_fetch_assoc($profile);
?>
		<div class="card mb-3">
			<div class="card-header">
				Profil
			</div>
			<div class="card-body">
				Nazwa użytkownika: <b><?php echo $profileRow['username']; ?></b>
				<br>
				Grupa: <b>
				<?php
					$group = mysqli_query($database, "select * from `groups` where id='".$profileRow['group_id']."';");
					$groupRow = mysqli_fetch_array($group);
					echo "<span class='badge badge-dark'>".$groupRow['name']."</span>";
				?></b>
				<br>
				Email: <b><?php echo $profileRow['email']; ?></b>
			</div>
		</div>
<?php
	} else {
		alert("danger", "Podane konto nie istnieje!");
	}
?>
</div>
<?php
	include 'footer.php';

	mysqli_close($database);
?>
