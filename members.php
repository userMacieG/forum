<?php
	include 'header.php';
?>
<div class="container mt-3">
	<?php
		$member = mysqli_query($database, "select * from `users`;");
		$memberRow = mysqli_fetch_assoc($member);
	?>
	<div class="card mb-3">
		<div class="card-header">
			Lista użytkowników
		</div>
		<table class="table mb-0">
			<thead>
				<tr>
					<th scope="col" width="50%">Nazwa użytkownika</th>
					<th scope="col" width="50%">Email</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo "<a href='profile.php?id=".$memberRow['id']."'><b>".$memberRow['username']."</b></a>"; ?></td>
					<td><?php echo $memberRow['email']; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
	include 'footer.php';

	mysqli_close($database);
?>
