<html>
<head>
	<title>MovieMax</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>	
	<style>
		.ui-autocomplete-loading {
		background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat;
		}
		.ui-autocomplete {
			font-size: 12px;
			max-height: 300px;
			overflow-y: auto;
		}
	</style>
</head>
<body style="width: 830px; margin: 0 10px;">
<div>
	<div style="border: 1px solid #C9C9C9; background: #C9C9C9; width: 800px; padding: 5px 10px; margin: 10px 0 10px 0;">
		<a style="text-decoration: none;" href="http://<?=$site?>"><span style="font-size: 25px;">MovieMax</span></a>
		<br />
		<em>Movie Analysis Tool</em>
		<br />
		<br />
		<?php if (isset($_COOKIE["email"])) { ?> 
			<span style="font-size: 12px;">Hi, <a href="user.php"><?= $_COOKIE["email"] ?></a>! <a href="logout.php">Logout</a></span>
		<?php } else { ?>
			<span style="font-size: 12px;"><a href="signin.php">Sign In</a></span>
		<?php } ?>
	</div>
</div>