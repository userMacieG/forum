<?php
	include 'header.php';
?>
<div class="container mt-3">
<?php
	if (!isset($user_id)) {
		if (isset($_POST['register'])) {
			$username = trim($_POST['registerUsername']);
			$email = trim($_POST['registerEmail']);
			$password = trim($_POST['registerPassword']);
			$repeat_password = trim($_POST['registerRepeatPassword']);
			register($database, $username, $email, $password, $repeat_password);
		}

		if (isset($_POST['login'])) {
			$email = trim($_POST['loginEmail']);
			$password = trim($_POST['loginPassword']);
			login($database, $email, $password);
		}
	}

	$forums = mysqli_query($database, "select * from `forums`;");
		while ($forumsRow = mysqli_fetch_array($forums)) {
?>
	<div class="card mb-3">
		<div class="card-header">
			<?php echo $forumsRow['name']; ?>
		</div>
		<table class="table mb-0">
			<thead>
				<tr>
					<th scope="col" width="8%" class="text-center">Rodzaj</th>
					<th scope="col" width="50%">Nazwa kategorii</th>
					<th scope="col" width="10%" class="text-center">Tematów</th>
					<th scope="col" width="10%" class="text-center">Postów</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$categories = mysqli_query($database, "select * from `categories` where forum_id='".$forumsRow['id']."';");
						while ($categoriesRow = mysqli_fetch_array($categories)) {
				?>
				<tr>
					<td class="text-center">
						<span class="rounded" style="color: #fff; background-color: #333; padding-top: 9px; width: 42px; height: 42px; display: inline-block; font-size: 18px;">
							<i class="fas fa-comment-alt"></i>
						</span>
					</td>
					<td><?php echo "<a href='topics.php?forum=".$forumsRow['id']."&category=".$categoriesRow['id']."'>".$categoriesRow['name']."</a>"; ?></td>
					<td class="text-center">
						<?php
							$forumPostsInfo = mysqli_query($database, "select * from `posts` where forum_id='".$forumsRow['id']."' and category_id='".$categoriesRow['id']."';");
							$forumPostsCount = mysqli_num_rows($forumPostsInfo);
							echo "<div style='font-size: 20px; font-weight: 900;'>".$forumPostsCount."</div><div class='text-muted' style='font-size: 12px;'>Postów</div>";
						?>
					</td>
					<td class="text-center">
						<?php
							$forumTopicsInfo = mysqli_query($database, "select * from `topics` where forum_id='".$forumsRow['id']."' and category_id='".$categoriesRow['id']."';");
							$forumTopicsCount = mysqli_num_rows($forumTopicsInfo);
							echo "<div style='font-size: 20px; font-weight: 900;'>".$forumTopicsCount."</div><div class='text-muted' style='font-size: 12px;'>Tematów</div>";
						?>
					</td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
	<?php
		}
	?>
	<div class="card mb-3">
		<div class="card-header">
			Statystyki forum
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-4 text-center">
					<?php
						$usersStat = mysqli_query($database, "select * from `users`;");
						$usersCount = mysqli_num_rows($usersStat);
					?>
					<div style="font-size: 20px; font-weight: 900;"><?php echo $usersCount; ?></div>
					<div class="text-muted" style="font-size: 12px;">Użytkowników</div>
				</div>
				<div class="col-md-4 text-center">
					<?php
						$topicsStat = mysqli_query($database, "select * from `topics`;");
						$topicsCount = mysqli_num_rows($topicsStat);
					?>
					<div style="font-size: 20px; font-weight: 900;"><?php echo $topicsCount; ?></div>
					<div class="text-muted" style="font-size: 12px;">Tematów</div>
				</div>
				<div class="col-md-4 text-center">
					<?php
						$postsStat = mysqli_query($database, "select * from `posts`;");
						$postsCount = mysqli_num_rows($postsStat);
					?>
					<div style="font-size: 20px; font-weight: 900;"><?php echo $postsCount; ?></div>
					<div class="text-muted" style="font-size: 12px;">Postów</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	include 'footer.php';

	mysqli_close($database);
?>
