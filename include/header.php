<?php
	require 'core/database.php';
	include 'core/functions.php';

	ob_start();
	session_start();

	define('USER_ID', isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '');
?>
<!doctype html>
<html lang="pl" class="h-100">
	<head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
		<link rel="stylesheet" href="<?= $config['default']['link'] ?>ckeditor/plugins/codesnippet/lib/highlight/styles/default.css">
		<link rel="stylesheet" href="<?= $config['default']['link'] ?>css/custom.css">
		<script src="https://kit.fontawesome.com/7455abdd3b.js"></script>
		<script src="<?= $config['default']['link'] ?>ckeditor/ckeditor.js"></script>
		<script src="<?= $config['default']['link'] ?>ckeditor/config.js"></script>
		<script src="<?= $config['default']['link'] ?>ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js"></script>
		<script>hljs.initHighlightingOnLoad();</script>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<title>forum.pl</title>
	</head>
	<body class="d-flex flex-column h-100">
		<main role="main" class="flex-shrink-0">
			<header>
				<nav class="navbar navbar-expand-lg navbar-light bg-light">
					<div class="container">
					  	<a class="navbar-brand" href="<?= $config['default']['link'] ?>index.php">forum.pl</a>
					  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Włącz nawigacje">
					    	<span class="navbar-toggler-icon"></span>
					  	</button>
					  	<div class="collapse navbar-collapse" id="navbar">
							<ul class="navbar-nav ml-auto">
								<?php
									if (USER_ID) {
								?>
								<li class="nav-item dropdown">
									<span class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<?php
											$user = $database->prepare("SELECT * FROM users WHERE id = ?;");
											$user->execute(array(USER_ID));
											$user_row = $user->fetch(PDO::FETCH_OBJ);
										?>
										<canvas class="user-icon rounded" data-name="<?= $user_row->username ?>" width="22" height="22" style="float: left; display: inline-block; margin-right: 6px;" data-chars="1"></canvas>
										<?= $user_row->username ?>
									</span>
									<div class="dropdown-menu" aria-labelledby="navbarDropdown">
										<a class="dropdown-item" href="<?= $config['default']['link'] ?>profile.php?id=<?= USER_ID ?>">
											<i class="fas fa-user fa-fw"></i> Profil
										</a>
										<a class="dropdown-item" href="<?= $config['default']['link'] ?>settings.php">
											<i class="fas fa-users-cog fa-fw"></i> Ustawienia
										</a>
	          							<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="<?= $config['default']['link'] ?>logout.php">
											<i class="fas fa-sign-out-alt fa-fw"></i> Wyloguj
										</a>
									</div>
								</li>
								<?php
									} else {
								?>
								<li class="nav-item">
							        <a class="nav-link" href="login.php">
										<i class="fas fa-sign-in-alt"></i> Zaloguj
									</a>
							    </li>
								<li class="nav-item">
							        <a class="nav-link" href="register.php">
										<i class="fas fa-user-plus"></i> Zarejestruj
									</a>
							    </li>
								<?php
									}
								?>
					    	</ul>
						</div>
				  	</div>
				</nav>
				<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
					<div class="container">
					  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#subnavbar" aria-controls="subnavbar" aria-expanded="false" aria-label="Włącz nawigacje">
					    	<span class="navbar-toggler-icon"></span>
					  	</button>
					  	<div class="collapse navbar-collapse" id="subnavbar">
					    	<ul class="navbar-nav mr-auto">
						      	<li class="nav-item">
						        	<a class="nav-link" href="<?= $config['default']['link'] ?>index.php">
										<i class="fas fa-home fa-fw"></i> Strona główna
									</a>
						      	</li>
								<li class="nav-item">
						        	<a class="nav-link" href="<?= $config['default']['link'] ?>memberlist.php">
										<i class="fas fa-users fa-fw"></i> Lista użytkowników
									</a>
						      	</li>
							</ul>
						</div>
				  	</div>
				</nav>
			</header>
