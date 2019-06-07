<?php
	function alert($type, $text) {
		echo '<div class="alert alert-'.$type.'" role="alert">'.$text.'</div>';
	}

	function login($database, $email, $password) {
		if (empty($email)) {
			alert("danger", "Proszę podać email!");
			return;
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			alert("danger", "Podany email jest nieprawidłowy!");
			return;
		}
		if (empty($password)) {
			alert("danger", "Proszę podać hasło!");
			return;
		}
		$exists = mysqli_query($database, "select `email` from `users` where email='".$email."';");
		if (mysqli_num_rows($exists) > 0) {
			mysqli_free_result($exists);
			$user = mysqli_query($database, "select * from `users` where email='".$email."';");
			$row = mysqli_fetch_assoc($user);
			if (!password_verify($password, $row["password"])) {
				alert("danger", "Podane hasło jest nieprawidłowe!");
				return;
			}
			$_SESSION['user_id'] = $row['id'];
			mysqli_free_result($user);
			alert("success", "Pomyślnie zalogowano na konto.");
			header("refresh:2;url=index.php");
		} else {
			mysqli_free_result($exists);
			alert("danger", "Podane konto nie istnieje!");
		}
	}

	function register($database, $username, $email, $password, $repeat_password) {
		$existsUsername = mysqli_query($database, "select `username` FROM `users` WHERE username='".$username."';");
		if (mysqli_num_rows($existsUsername) > 0) {
			alert("danger", "Podana nazwa użytkownika jest już zajęta!");
			return;
		}
		mysqli_free_result($existsUsername);
		$existsEmail = mysqli_query($database, "select `email` FROM `users` WHERE email='".$email."';");
		if (mysqli_num_rows($existsEmail) > 0) {
			alert("danger", "Podany adres email jest już zajęty!");
			return;
		}
		mysqli_free_result($existsEmail);
		if (empty($username)) {
			alert("danger", "Proszę podać nazwe użytkownika!");
			return;
		}
		if (empty($email)) {
			alert("danger", "Proszę podać email!");
			return;
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			alert("danger", "Podany email jest nieprawidłowy!");
			return;
		}
		if (empty($password)) {
			alert("danger", "Proszę podać hasło!");
			return;
		}
		if (empty($repeat_password)) {
			alert("danger", "Proszę powtórzyć hasło!");
			return;
		}
		if ($password !== $repeat_password) {
			alert("danger", "Podane hasła nie zgadzają się!");
			return;
		}
		$password_hash = password_hash($password, PASSWORD_BCRYPT);
		mysqli_query($database, "insert into `users` values (null, '".$username."', '".$email."', '".$password_hash."', null);");
		alert("success", "Pomyślnie stworzono konto.");
		header("refresh:2;url=index.php");
	}
?>
