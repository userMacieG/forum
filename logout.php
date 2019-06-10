<?php
	include 'include/header.php';
?>
<div class="container mt-3">
	<?php
		if (USER_ID) {
			alert('success', 'Zostałeś wylogowany.');
			session_destroy();
			header("refresh:2;url={$config['default']['link']}index.php");
		} else {
			alert('danger', 'Nie możesz się wylogować będąć nie zalogowanym!');
		}
	?>
</div>
<?php
	include 'include/footer.php';
?>
