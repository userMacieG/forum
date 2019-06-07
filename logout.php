<?php
	include 'header.php';

	session_destroy();
?>
<div class="container mt-3">
	<?php
		alert("success", "Zostałeś wylogowany pomyślnie.");
		header("refresh:2;url=index.php");
	?>
</div>
<?php
	include 'footer.php';
?>
