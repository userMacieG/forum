<?php
	include 'include/header.php';
?>
<div class="container mt-3">
	<?php
		if (USER_ID) {
			alert('success', 'Zostałeś wylogowany.');
			session_destroy();
			header('refresh:0;url=index.php');
		} else {
			alert('danger', 'Nie możesz się wylogować będąć nie zalogowanym!');
		}
	?>
</div>
<?php
	include 'include/footer.php';
?>
