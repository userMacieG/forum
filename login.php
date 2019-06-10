<?php
	include 'include/header.php';
?>
<div class="container mt-3">
	<?php
		if (USER_ID) {
			alert('danger', 'Jesteś już zalogowany!');
		} else {
			if (isset($_POST['login'])) {
				$email = trim($_POST['loginEmail']);
				$password = trim($_POST['loginPassword']);

				$user = $database->prepare("SELECT * FROM users WHERE email = ?;");
				$user->execute(array($email));
				$user_row = $user->fetch(PDO::FETCH_OBJ);

				$error = '';

				if (empty($email)) {
					$error = 'Proszę podać email!';
				} else if (strlen($email) < 3) {
					$post_error = 'Podany email jest zbyt krótki! Minimalna długość to 3 znaki';
				} else if (strlen($email) > 320) {
					$post_error = 'Podany email zbyt długi! Maksymalna długość to 320 znaki.';
				} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$error = 'Podany email jest nieprawidłowy!';
				} else if (empty($password)) {
					$error = 'Proszę podać hasło!';
				} else if ($user->rowCount() <= 0) {
					$error = 'Podane konto nie istnieje!';
				} else if (!password_verify($password, $user_row->password)) {
					$error = 'Podane hasło jest nieprawidłowe!';
				}

				if (empty($error)) {
					alert('success', 'Pomyślnie zalogowano!');
					$_SESSION['user_id'] = $user_row->id;
					header('refresh:2;url=index.php');
				} else {
					alert('danger', $error);
				}
			}
	?>
	<div class="card">
		<div class="card-body">
			<form method="post">
				<div class="text-center mb-3">
					<h1>Zaloguj się</h1>
					<h6 class="mb-1">Odkryj dostępne funkcje.</h6>
				</div>
				<div class="form-group">
					<label for="inputEmail">Email</label>
					<input type="email" class="form-control" id="inputEmail" placeholder="Email" name="loginEmail" required>
				</div>
				<div class="form-group">
					<label for="inputPassword">Hasło</label>
					<input type="password" class="form-control" id="inputPassword" placeholder="Hasło" name="loginPassword" required>
				</div>
				<div class="text-center">
					<button type="submit" class="btn btn-outline-primary btn-block" name="login">Zaloguj</button>
				</div>
			</form>
		</div>
	</div>
	<?php
		}
	?>
</div>
<?php
	include 'include/footer.php';
?>
