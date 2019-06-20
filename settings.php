<?php
	include 'include/header.php';
?>
<div class="container mt-3">
	<div class="card">
		<div class="card-body">
			<?php
				if (USER_ID) {
			?>
			<div class="row">
				<div class="col-md-3">
					<h5>Zakładki</h5>
					<hr>
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
				      	<a class="nav-link active" href="settings.php?page=user">Konto</a>
				      	<a class="nav-link" href="settings.php?page=changepass">Zmień hasło</a>
				    </div>
				</div>
				<div class="col-md-9">
					right
				</div>
			</div>
			<?php
				} else {
					alert('danger', 'Podana podstrona ustawień nie istnieje!');
				}
			?>
		</div>
	</div>
</div>
<?php
	include 'include/footer.php';
?>
