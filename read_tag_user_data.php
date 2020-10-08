<?php

require 'database.php';
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

$balance = $data['balance'];
$write = "<?php $" . "balance='" . $balance . "'; " . "echo $" . "balance;" . " ?>";
file_put_contents('balanceContainer.php', $write);

$msg = null;
if (null == $data['name']) {
	$msg = "The ID of your Card / KeyChain is not registered !!!";
	$data['id'] = $id;
	$data['name'] = "--------";
	$data['balance'] = "--------";
	$data['email'] = "--------";
	$data['mobile'] = "--------";
	$balance = '';
} else {
	$msg = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<script src="js/bootstrap.min.js"></script>
	<script src="jquery.min.js"></script>
	<style>
		td.lf {
			padding-left: 15px;
			padding-top: 12px;
			padding-bottom: 12px;
		}

		.not-found {
			display:flex,
		}
	</style>
</head>

<body>

	<div>
		<div class="col-md-12">
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
										<td align="left"><?php echo $data['id']; ?></td>
									</tr>
									<tr bgcolor="#f2f2f2">
										<td align="left" class="lf">Name</td>
										<td style="font-weight:bold">:</td>
										<td align="left"><?php echo $data['name']; ?></td>
									</tr>
									<tr>
										<td align="left" class="lf">Balance</td>
										<td style="font-weight:bold">:</td>
										<td align="left"><?php echo $data['balance']; ?></td>
									</tr>
									<tr bgcolor="#f2f2f2">
										<td align="left" class="lf">Email</td>
										<td style="font-weight:bold">:</td>
										<td align="left"><?php echo $data['email']; ?></td>
									</tr>
									<tr>
										<td align="left" class="lf">Mobile Number</td>
										<td style="font-weight:bold">:</td>
										<td align="left"><?php echo $data['mobile']; ?></td>
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
		
		<div class="col-md-12">
			<form action="user_data_edit_balance.php?id=<?php echo $data['id']?>" name="update" method="POST">
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
									<td width="113" align="left" class="lf">Add Amount</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><input type="number" name="amount" min="0" step="1" value="0"></td>
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
									<td><input type="submit" class="btn btn-success" value="Update"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</div>


		<div class="not-found">
			<p style="color:red;"><?php echo $msg; ?></p>
		</div>
	</div>	
	
</body>

</html>