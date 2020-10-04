<?php
	$Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
	file_put_contents('UIDContainer.php',$Write);
?>

<!DOCTYPE html>
<html lang="en">
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script>
		<style>
		html {
			font-family: Arial;
			display: inline-block;
			margin: 0px auto;
			text-align: center;
		}

		ul.topnav {
			list-style-type: none;
			margin: auto;
			padding: 0;
			overflow: hidden;
			background-color: #4CAF50;
			width: 70%;
		}

		ul.topnav li {float: left;}

		ul.topnav li a {
			display: block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		ul.topnav li a:hover:not(.active) {background-color: #3e8e41;}

		ul.topnav li a.active {background-color: #333;}

		ul.topnav li.right {float: right;}

		@media screen and (max-width: 600px) {
			ul.topnav li.right, 
			ul.topnav li {float: none;}
		}
		
		.table {
			margin: auto;
			width: 90%; 
		}
		
		thead {
			color: #FFFFFF;
		}
		</style>
		
		<title>User Data : NodeMCU</title>
	</head>
	
	<body>
		<ul class="topnav">
			<li><a href="home.php">Home</a></li>
			<li><a class="active" href="user_data.php">User Data</a></li>
			<li><a href="registration.php">Registration</a></li>
			<li><a href="read_tag.php">Read Tag ID</a></li>
		</ul>
		<br>
		<div class="container">
            <div class="row">
                <h3>User Data Table</h3>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr bgcolor="#10a0c5" color="#FFFFFF">
											<th>ID</th>
                      <th>Name</th>
					  					<th>Balance</th>
					  					<th>Email</th>
                      <th>Mobile Number</th>
					  					<th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM `card` ORDER BY name ASC';
                   foreach ($pdo->query($sql) as $row) {
														echo '<tr>';
														echo '<td>'. $row['id'] . '</td>';
                  	        echo '<td>'. $row['name'] . '</td>';
                  	        echo '<td>'. $row['balance'] . '</td>';
														echo '<td>'. $row['email'] . '</td>';
														echo '<td>'. $row['mobile'] . '</td>';
														echo '<td><a class="btn btn-success" href="user_data_edit_page.php?id='.$row['id'].'">Edit</a>';
														echo ' ';
														echo '<a class="btn btn-danger" href="user_data_delete_page.php?id='.$row['id'].'">Delete</a>';
														echo '</td>';
                  	        echo '</tr>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
				</table>
			</div>
		</div> <!-- /container -->
	</body>
</html>