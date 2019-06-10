<?php
	$config = include('config.php');

	try {
	    $database = new PDO('mysql:host='.$config['database']['hostname'].';port='.$config['database']['port'].';dbname='.$config['database']['database'].';charset='.$config['database']['charset'], $config['database']['username'], $config['database']['password']);
	    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
	    echo $e->getMessage();
		die();
	}
?>
