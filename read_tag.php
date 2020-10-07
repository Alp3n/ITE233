<?php
$Write = "<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
file_put_contents('UIDContainer.php', $Write);
$Write2="<?php $" . "balance=''; " . "echo $" . "balance;" . " ?>";
    file_put_contents('balanceContainer.php', $write);
?>

<?php
require 'database.php';

// require 'database.php';
$id = null;
if (!empty($_GET['id'])) {
	$id = $_REQUEST['id'];
}

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM `card` where id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);
Database::disconnect();

// if(isset($_POST['update'])){

// 	$amount = $_POST['amount'];
// 	$id = $UIDresult;

// 	$new_balance = $balance + $amount;

// 	$pdo = Database::connect();
// 	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 	$sql = "UPDATE `card`set balance =? WHERE id =? ";
// 	$q = $pdo->prepare($sql);
// 	$q->execute(array($new_balance, $id));
// 	header("Location: user_data.php");   
// }
?>

<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<script src="js/bootstrap.min.js"></script>
	<script src="jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$("#getUID").load("UIDContainer.php");
			setInterval(function() {
				$("#getUID").load("UIDContainer.php");
			}, 500);
		});
	</script>
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

		ul.topnav li {
			float: left;
		}

		ul.topnav li a {
			display: block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		ul.topnav li a:hover:not(.active) {
			background-color: #3e8e41;
		}

		ul.topnav li a.active {
			background-color: #333;
		}

		ul.topnav li.right {
			float: right;
		}

		@media screen and (max-width: 600px) {

			ul.topnav li.right,
			ul.topnav li {
				float: none;
			}
		}

		td.lf {
			padding-left: 15px;
			padding-top: 12px;
			padding-bottom: 12px;
		}

		td.buttons-row {
			display: flex;
		}

		a.btn-info {
			margin-left: 15px;
		}
	</style>

	<title>Read Tag : NodeMCU</title>
</head>

<body>
	<ul class="topnav">
		<li><a href="home.php">Home</a></li>
		<li><a href="user_data.php">User Data</a></li>
		<li><a href="registration.php">Registration</a></li>
		<li><a class="active" href="read_tag.php">Read Tag ID</a></li>
	</ul>

	<br>

	<h3 align="center" id="blink">Please Tag to Display ID or User Data</h3>

	<p id="getUID" hidden></p>

	<br>
	
	<div class="container">
		<div class="row change-row">
			<div class="col-md-6">
				<div id="show_user_data">
					<form>
						<table width="452" border="1" bordercolor="#10a0c5" align="center" cellpadding="0" cellspacing="1" bgcolor="#000" style="padding: 2px">
							<tr>
								<td height="40" align="center" bgcolor="#10a0c5">
									<font color="#FFFFFF">
										<b>User Data</b>
									</font>
								</td>
							</tr>
							<tr>
								<td bgcolor="#f9f9f9">
									<table width="452" border="0" align="center" cellpadding="5" cellspacing="0">
										<tr>
											<td width="113" align="left" class="lf">ID</td>
											<td style="font-weight:bold">:</td>
											<td align="left">--------</td>
										</tr>
										<tr bgcolor="#f2f2f2">
											<td align="left" class="lf">Name</td>
											<td style="font-weight:bold">:</td>
											<td align="left">--------</td>
										</tr>
										<tr>
											<td align="left" class="lf">Balance</td>
											<td style="font-weight:bold">:</td>
											<td align="left">--------</td>
										</tr>
										<tr bgcolor="#f2f2f2">
											<td align="left" class="lf">Email</td>
											<td style="font-weight:bold">:</td>
											<td align="left">--------</td>
										</tr>
										<tr>
											<td align="left" class="lf">Mobile Number</td>
											<td style="font-weight:bold">:</td>
											<td align="left">--------</td>
										</tr>
										<tr>
											<td class="buttons-row">
												<a class="btn btn-success" href="user_data_edit_page.php?id='.$row['id'].'">Edit</a>
												<a class="btn btn-info" href="read_tag.php">Clear</a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>

			<!-- <div class="col-md-6">
				<form action="user_data_edit_balance.php?id=<?php echo $id ?>" method="post">
					<table width="452" border="1" bordercolor="#10a0c5" align="center" cellpadding="0" cellspacing="1" bgcolor="#000" style="padding: 2px">
						<tr>
							<td height="40" align="center" bgcolor="#10a0c5">
								<font color="#FFFFFF">
									<b>Change Balance</b>
								</font>
							</td>
						</tr>
						<tr>
							<td bgcolor="#f9f9f9">
								<table width="452" border="0" align="center" cellpadding="5" cellspacing="0">
									<tr></tr>
										<td width="113" align="left" class="lf">Balance</td>
										<td style="font-weight:bold">:</td>
										<td align="left"><input type="number" name="balance" min="0" step="1" value="<?php echo $data['balance'] ?>"></td>
									</tr>
									<tr bgcolor="#f2f2f2">
										<td align="left" class="lf"></td>
										<td style="font-weight:bold"></td>
										<td align="left"></td>
									</tr>
									<tr>
										<td align="left" class="lf"></td>
										<td style="font-weight:bold"></td>
										<td align="left"></td>
									</tr>
									<tr bgcolor="#f2f2f2">
										<td align="left" class="lf"></td>
										<td style="font-weight:bold"></td>
										<td align="left"></td>
									</tr>
									<tr>
										<td align="left" class="lf"></td>
										<td style="font-weight:bold"></td>
										<td align="left"></td>
									</tr>
									<tr>
										<td><input type="submit" class="btn btn-success"></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</form>
			</div> -->
		</div>
	</div>

	<script>
		var myVar = setInterval(myTimer, 1000);
		var myVar1 = setInterval(myTimer1, 1000);
		var oldID = "";
		clearInterval(myVar1);

		function myTimer() {
			var getID = document.getElementById("getUID").innerHTML;
			oldID = getID;
			if (getID != "") {
				myVar1 = setInterval(myTimer1, 500);
				showUser(getID);
				clearInterval(myVar);
			}
		}

		function myTimer1() {
			var getID = document.getElementById("getUID").innerHTML;
			if (oldID != getID) {
				myVar = setInterval(myTimer, 500);
				clearInterval(myVar1);
			}
		}
		function showUser(str) {
			if (str == "") {
				document.getElementById("show_user_data").innerHTML = "";
				return;
			} else {
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for IE6, IE5
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("show_user_data").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("GET", "read_tag_user_data.php?id=" + str, true);
				xmlhttp.send();
			}
		}

		var blink = document.getElementById('blink');
		setInterval(function() {
			blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
		}, 750);
	</script>
</body>

</html>