<?php

require("db/db.php");

$path = $_SERVER["REQUEST_URI"];
$path = str_replace("/orange","",$path);

$topRunners = array(
	array(
		"user" => "Ryan Muller",
		"distance" => 5.1
	),
	array(
		"user" => "Grace Kennedy",
		"distance" => 3.1
	)
);
if(startsWith($path,'/users')){
	$q = $_GET["term"];
	echo json_encode(getUsersByQuery($q));
	exit;
}

if(startsWith($path,'/upload')){
	require 'db/upload.php';
	exit;
}

?>
<html>
<head>
	<link rel="stylesheet" href="/orange/css/orange.css" />
	<link rel="stylesheet" href="/orange/css/semantic.min.css" />
	<title>Orange</title>
</head>
<body>
	<div class="ui fixed main menu">
		<div class="container">
			<div class="main title item" id="brand">
				<span class="logo"><img class="logo" src="/orange/images/orange.png" height="30px" /></span>
				Orange
			</div>
			<a href="/orange/" class="<?php if($path=='/'){ echo 'active'; }?> item">
				<i class="home icon"></i>
				Home
			</a>
			<a href="/orange/profile" class="<?php if(startsWith($path,'/profile')){ echo 'active'; } ?> item">
				<i class="user icon"></i>
				Profile
			</a>
			<div class="right menu">
				<a class="item" id="signUp">
					<i class="edit icon"></i>
					Sign up
				</a>
				<div class="ui top pointing dropdown item" id="userSearchOverall">
					<div class="ui icon input">
						<input placeholder="Find a user" type="text" id="userSearch">
						<i class="search link icon"></i>
					</div>
					<div id="autocompleteResults" class="menu">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="main_content">
		
		<?php 
		main_feed();
		if(false){ ?>
		<div class="ui piled feed segment">
			<h2 class="ui header">Top runners</h2>
			<?php 
			$i = 1;
			foreach($topRunners as $item) {
				 ?>
			<div class="ui blue raised event segment">
				<div class="ui left corner blue label">
					#<?= $i++ ?>
				</div>
				
				<div class="ui container">
				<div class="circular label">
					<img src="http://robohash.org/<?= hash('ripemd160',$item["user"]) ?>.png?size=100x100&bgset=any">
				</div>
				<div class="content">
				  <div class="summary">
					 <a href="#"><?= $item["user"] ?></a> ran <a href="/orange/u/<?= $item["id"].'/'.$item["user"] ?>"><?= $item["distance"] ?></a> miles total
				  </div>
				</div>
				</div>
			</div>
			<?php } } ?>
			<div class="ui small modal" id="newUserModal">
			  <div class="header">
				Start using Orange
			  </div>
			  <div class="content" style="text-align:center;">
				  Your user code is:
				  <h2><?php
				  $str = base64_encode(hash('ripemd160',rand(), true));
				  $str = substr($str,0,3).'-'.substr($str,3,3);
				  echo strtoupper($str);
				  ?></h2>
			  </div>
			  <div class="actions">
				<div class="ui button">OK</div>
			  </div>
			</div>
		</div>
	</div>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="/orange/javascript/semantic.min.js"></script>
	<script src="/orange/javascript/autocomplete.js"></script>
</body>
</html>
