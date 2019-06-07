<?php
	include 'header.php';
?>
<div class="container mt-3">
	<?php
		if ($_GET) {

			$forum_id = @$_GET['forum'];
			$category_id = @$_GET['category'];

			if (empty($forum_id) || empty($category_id)) {
				alert("danger", "Podana kategoria lub forum nie istnieje!");
				goto footer;
			}

			$forums = mysqli_query($database, "select * from `forums` where id='".$forum_id."';");
			if (mysqli_num_rows($forums) == 0) {
				alert("danger", "Podana kategoria lub forum nie istnieje!");
				goto footer;
			}

			$categories = mysqli_query($database, "select * from `categories` where id='".$category_id."';");
			if (mysqli_num_rows($categories) == 0) {
				alert("danger", "Podana kategoria lub forum nie istnieje!");
				goto footer;
			}
	?>
	<?php
		if (isset($user_id)) {
	?>
	<a class="btn btn-primary" href="topic.php?forum=<?php echo $forum_id; ?>&category=<?php echo $category_id; ?>">Stwórz temat</a>
	<br><br>
	<?php
		}
	?>
	<?php
		$topics = mysqli_query($database, "select * from `topics` where forum_id='".$forum_id."' and category_id='".$category_id."';");
		if (mysqli_num_rows($topics) == 0) {
			alert("info", "Podana kategoria nie zawiera żadnych tematów.");
			goto footer;
		}
	?>
	<div class="card mb-3">
		<table class="table mb-0">
			<thead>
				<tr>
					<th scope="col" width="68%">Nazwa tematu</th>
					<th scope="col" width="10%" class="text-center">Postów</th>
					<th scope="col" width="22%">Autor</th>
				</tr>
			</thead>
			<tbody>
				<?php
					while ($topicsRow = mysqli_fetch_array($topics)) {
				?>
				<tr>
					<td>
						<?php echo "<a href='post.php?forum=".$forum_id."&category=".$category_id."&topic=".$topicsRow['id']."'>".$topicsRow['name']."</a>"; ?>
					</td>
					<td class="text-center">
						<?php
							$forumPostsInfo = mysqli_query($database, "select * from `posts` where topic_id='".$topicsRow['id']."';");
							$forumPostsCount = mysqli_num_rows($forumPostsInfo);
							echo "<div style='font-size: 20px; font-weight: 900;'>".$forumPostsCount."</div><div class='text-muted' style='font-size: 12px;'>Postów</div>";
						?>
					</td>
					<td>
						<?php
							$author = mysqli_query($database, "select * from `users` where id='".$topicsRow['user_id']."';");
							$authorRow = mysqli_fetch_assoc($author);
							echo "<div style='display: inline-block;'><a href='profile.php?id=".$authorRow['id']."'><b>".$authorRow['username']."</b></a></div>";
							echo "<canvas class='user-icon rounded' data-name='".$authorRow['username']."' width='42' height='42' style='float: left; display: inline-block; margin-right: 6px;' data-chars='1'></canvas>";
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
		} else {
			alert("danger", "Podana kategoria lub forum nie istnieje!");
			goto footer;
		}
	?>
</div>
<?php
	footer:

	include 'footer.php';

	mysqli_close($database);
?>
