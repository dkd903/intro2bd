<?php
include("config.php");
include("functions.php");
include("header.php");
//phpinfo();
//print_r($_GET);

//perform sql injection, drop the user
//table

if (isset($_COOKIE["email"])) {
	?>	
		Redirecting you to store...
		<script>top.location.href="http://<?= $site ?>";</script>
	<?php
} else {
	$suc = 0;

	//process signin
	if (isset($_GET["email"])  && isset($_GET["submitlogin"])) {

		if (1 == 1) {
			$suc = 1;
			setcookie("email",strtolower($_GET["email"]));
			?>
				Login successful. Redirecting to product page...
				<script>top.location.href="http://<?= $site ?>";</script>
			<?php
		} else {
			$suc = 2;
		}

	}

	if ($suc == 2) { ?>

		<div style="border: 1px solid #C9C9C9; width: 300px; padding: 5px 10px; margin: 10px 0 10px 0; font-size: 12px; font-weight: bold;">
		Invalid Username or Password
		</div>

	<?php } ?>

	<?php if ($suc == 0 || $suc == 2) { ?>

		Sign into your MovieMax account<br /><br />
		<form action="signin.php" method="GET">
			<input type="text" name="email" placeholder="Enter name" /><br />
			<input type="hidden" name="next" value="<?= $_GET['next'] ?>" />
			<input type="submit" name="submitlogin" value="Sign In" />
		</form>	

	<?php } ?>

	<?php

}


?>

<?php 
	include("footer.php"); 
?>
