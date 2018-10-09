<?php
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	require_once 'class.Feed.php';

	require_once ("db_config.php");
	require_once ("databases/" . DB_TYPE);

	db_connect(DB_HOST, DB_NAME, DB_LOGIN, DB_PASSWORD);

	$feed = new Feed();

	if (isset($_POST['send'])) {
		$feed->getData();

		echo $feed->showResult();
	}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Rss</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
</head>

<body>
<form action="" method="post">
<input type="submit" name="send" value="Разобрать">
</form>

</body>
</html>

