<?php
  require 'database.php';

  $id = null;
  if ( !empty($_GET['id'])) {
      $id = $_REQUEST['id'];
  }
    
  if ( !empty($_POST)) {
    // keep track post values
    $name = $_POST['name'];
    $id = $_POST['id'];
    $balance = $_POST['balance'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
      
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE `card`  set name = ?, balance =?, email =?, mobile =? WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($name,$balance,$email,$mobile,$id));

	  $write="<?php $" . "balance='" . $balance . "'; " . "echo $" . "balance;" . " ?>";
	  file_put_contents('balanceContainer.php', $write);
    Database::disconnect();

    header("Location: user_data.php");
  }
