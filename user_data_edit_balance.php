<?php
  require 'database.php';
  require 'balanceContainer.php';

  $id = null;
  if ( !empty($_GET['id'])) {
      $id = $_REQUEST['id'];   
  }

  if ( !empty($_POST['amount'])){
    // keep track post values
    $amount = $_POST['amount'];
      
    $new_balance = $balance + $amount;
    
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE `card`  set balance =? WHERE id =? ";
    $q = $pdo->prepare($sql);
    $q->execute(array($new_balance, $id));
    

	  $write="<?php $" . "balance='" . $new_balance . "'; " . "echo $" . "balance;" . " ?>";
    file_put_contents('balanceContainer.php', $write);
    Database::disconnect();
    

    header("Location: read_tag.php");
  }
