<?php

    require 'database.php';

    if ( !empty($_POST)) {
        // keep track post values
        $name = $_POST['name'];
				$id = $_POST['id'];
				$balance = $_POST['balance'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];

		// insert data
        $pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO card (name,id,balance,email,mobile) values(?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($name,$id,$balance,$email,$mobile));
		Database::disconnect();
		header("Location: user_data.php");
    }
?>
