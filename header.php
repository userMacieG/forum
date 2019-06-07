<?php
	require 'core/database.php';
	include 'core/functions.php';

	ob_start();
	session_start();

	$user_id = @$_SESSION['user_id'];
?>
<!doctype html>
<html lang="pl" class="h-100">
	<head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="css/custom.css">
		<title>forum.pl</title>
		<script src="https://kit.fontawesome.com/7455abdd3b.js"></script>
		<script src="ckeditor/ckeditor.js"></script>
	</head>
	<body class="d-flex flex-column h-100">
		<main role="main" class="flex-shrink-0">
			<header>
				<nav class="navbar navbar-expand-lg navbar-light bg-light">
					<div class="container">
					  	<a class="navbar-brand" href="index.php">forum.pl</a>
					  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					    	<span class="navbar-toggler-icon"></span>
					  	</button>
					  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
					    	<ul class="navbar-nav mr-auto">
						      	<li class="nav-item">
						        	<a class="nav-link" href="index.php"><i class="fas fa-home"></i> Strona główna</a>
						      	</li>
								<li class="nav-item">
						        	<a class="nav-link" href="members.php"><i class="fas fa-users"></i> Lista użytkowników</a>
						      	</li>
							</ul>
							<ul class="navbar-nav ml-auto">
								<?php
									if (isset($user_id)) {
								?>
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<?php
											$user = mysqli_query($database, "select * from `users` where id='".$user_id."'");
											$row = mysqli_fetch_assoc($user);
											echo $row["username"];
											mysqli_free_result($user);
										?>
									</a>
									<div class="dropdown-menu" aria-labelledby="navbarDropdown">
										<a class="dropdown-item" href="profile.php?id=<?php echo $user_id; ?>"><i class="fas fa-user"></i> Profil</a>
	          							<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Wyloguj</a>
									</div>
								</li>
								<?php
									} else {
								?>
								<li class="nav-item">
							        <a class="nav-link" href="#" data-toggle="modal" data-target="#loginRegisterModal">
										<i class="fas fa-sign-in-alt"></i> Zaloguj / <i class="fas fa-user-plus"></i> Zarejestruj
									</a>
							    </li>
								<div class="modal fade" id="loginRegisterModal" tabindex="-1" role="dialog" aria-labelledby="loginRegisterModalLabel" aria-hidden="true">
								  	<div class="modal-dialog modal-lg" role="document">
								    	<div class="modal-content">
								      		<div class="modal-body">
								        		<div class="row">
													<div class="col-md-6">
														<form method="post">
															<div class="card-body">
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
																<div class="text-center">
																	<button type="submit" class="btn btn-outline-primary btn-block" name="register">Zarejestruj</button>
																</div>
															</div>
														</form>
													</div>
													<div class="col-md-6">
														<form method="post">
															<div class="card-body">
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
															</div>
														</form>
													</div>
												</div>
								      		</div>
								    	</div>
								  	</div>
								</div>
								<?php
									}
								?>
					    	</ul>
						</div>
				  	</div>
				</nav>
			</header>
