<?php
	include 'include/header.php';
?>
<div class="container mt-3">
	<?php
		if ($_GET) {
			$type = $_GET['type'];

			$error = '';

			if (empty($type)) {
				$error = 'Podany typ błędu nie istnieje!';
			}

			if (empty($error)) {
				if ($type === '400') {
?>
	<div class="card">
		<div class="card-body text-center">
			<i class="fas fa-exclamation-circle text-danger" style="font-size: 128px;"></i>
			<br>
			<br>
			<h1>Błąd 400</h1>
			<h5>Wykonane zapytanie nie podwiodło się!</h5>
			<br>
			<a href="<?= $config['default']['link'] ?>index.php" class="btn btn-danger">Strona główna</a>
		</div>
	</div>
<?php
	} else if ($type === '401') {
?>
	<div class="card">
		<div class="card-body text-center">
			<i class="fas fa-exclamation-circle text-danger" style="font-size: 128px;"></i>
			<br>
			<br>
			<h1>Błąd 401</h1>
			<h5>Nie posiadasz dostępu!</h5>
			<br>
			<a href="<?= $config['default']['link'] ?>index.php" class="btn btn-danger">Strona główna</a>
		</div>
	</div>
<?php
	} else if ($type === '403') {
?>
	<div class="card">
		<div class="card-body text-center">
			<i class="fas fa-exclamation-circle text-danger" style="font-size: 128px;"></i>
			<br>
			<br>
			<h1>Błąd 403</h1>
			<h5>Nie posiadasz dostępu!</h5>
			<br>
			<a href="<?= $config['default']['link'] ?>index.php" class="btn btn-danger">Strona główna</a>
		</div>
	</div>
<?php
	} else if ($type === '404') {
?>
	<div class="card">
		<div class="card-body text-center">
			<i class="fas fa-exclamation-circle text-danger" style="font-size: 128px;"></i>
			<br>
			<br>
			<h1>Błąd 404</h1>
			<h5>Podana strona nie istnieje!</h5>
			<br>
			<a href="<?= $config['default']['link'] ?>index.php" class="btn btn-danger">Strona główna</a>
		</div>
	</div>
<?php
	} else if ($type === '500') {
?>
	<div class="card">
		<div class="card-body text-center">
			<i class="fas fa-exclamation-circle text-danger" style="font-size: 128px;"></i>
			<br>
			<br>
			<h1>Błąd 500</h1>
			<h5>Wykonane zapytanie nie podwiodło się!</h5>
			<br>
			<a href="<?= $config['default']['link'] ?>index.php" class="btn btn-danger">Strona główna</a>
		</div>
	</div>
<?php
				}
			} else {
				alert('danger', $error);
			}
		} else {
			alert('danger', 'Podany typ błędu nie istnieje!');
		}
?>
</div>
<?php
	include 'include/footer.php';
?>
