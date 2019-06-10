<?php
	include 'include/header.php';
?>
<div class="container mt-3">
	<?php
		if (USER_ID) {
			alert('danger', 'Jesteś zalogowany, nie możesz zrobić teraz nowego konta!');
		} else {
			if (isset($_POST['register'])) {
				$username = trim(htmlspecialchars($_POST['registerUsername']));
				$email = filter_var(trim($_POST['registerEmail']), FILTER_SANITIZE_EMAIL);
				$password = trim($_POST['registerPassword']);
				$repeat_password = trim($_POST['registerRepeatPassword']);

				$error = '';

				$existsUsername = $database->prepare("SELECT username FROM users WHERE username = ?;");
				$existsUsername->execute(array($username));

				$existsEmail = $database->prepare("SELECT email FROM users WHERE email = ?;");
				$existsEmail->execute(array($email));

				if ($existsUsername->rowCount() > 0) {
					$error = 'Podana nazwa użytkownika jest już zajęta!';
				} else if ($existsEmail->rowCount() > 0) {
					$error = 'Podany adres email jest już zajęty!';
				} else if (empty($username)) {
					$error = 'Proszę podać nazwe użytkownika!';
				} else if (strlen($email) < 4) {
					$post_error = 'Podana nazwa użytkownika jest zbyt krótka! Minimalna długość to 3 znaki';
				} else if (strlen($email) > 256) {
					$post_error = 'Podany nazwa użytkownika jest zbyt długa! Maksymalna długość to 256 znaki.';
				} else if (empty($email)) {
					$error = 'Proszę podać email!';
				} else if (strlen($email) < 3) {
					$post_error = 'Podany email jest zbyt krótki! Minimalna długość to 3 znaki';
				} else if (strlen($email) > 320) {
					$post_error = 'Podany email zbyt długi! Maksymalna długość to 320 znaki.';
				} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$error = 'Podany adres email jest nieprawidłowy!';
				} else if (empty($password)) {
					$error = 'Proszę podać hasło!';
				} else if (empty($repeat_password)) {
					$error = 'Proszę powtórzyć hasło!';
				} else if ($password !== $repeat_password) {
					$error = 'Podane hasła nie zgadzają się!';
				}

				if (empty($error)) {
					alert('success', 'Pomyślnie zostałeś zarejestrowany!<br>Zostaniesz przeniesiony na strone logowania.');
					$password_hash = password_hash($password, PASSWORD_BCRYPT);
					$insert = $database->prepare("INSERT INTO users VALUES (NULL, ?, ?, ?, 1);");
					$insert->execute(array($username, $email, $password_hash));
					header("refresh:2;url={$config['default']['link']}index.php");
				} else {
					alert('danger', $error);
				}
			}
	?>
	<div class="card">
		<div class="card-body">
				<form method="post" autocomplete="off">
					<div class="text-center mb-3">
						<h1>Utwórz konto</h1>
						<h6 class="mb-1">Dołącz do nas już teraz!</h6>
					</div>
					<div class="form-group">
						<label for="inputRegisterUsername">Nazwa użytkownika</label>
						<input type="text" class="form-control" id="inputRegisterUsername" placeholder="Nazwa użytkownika" name="registerUsername" required>
					</div>
					<div class="form-group">
						<label for="inputRegisterEmail">Email</label>
						<input type="email" class="form-control" id="inputRegisterEmail" placeholder="Email" name="registerEmail" required>
					</div>
					<div class="form-group">
						<label for="inputRegisterPassword">Hasło</label>
						<input type="password" class="form-control" id="inputRegisterPassword" placeholder="Hasło" name="registerPassword" required>
					</div>
					<div class="form-group">
						<label for="inputRegisterRepeatPassword">Powtórz hasło</label>
						<input type="password" class="form-control" id="inputRegisterRepeatPassword" placeholder="Powtórz hasło" name="registerRepeatPassword" required>
					</div>
					<div class="text-center mt-3">
						<button type="submit" class="btn btn-outline-primary btn-block" name="register">Zarejestruj</button>
					</div>
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
