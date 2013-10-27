<?php

require("db/db.php");

$feedItems = array(
	array(
		"user"=> "Ryan Muller",
		"distance"=> 3.1,
		"time" => "21:56"
	),
	array(
		"user" => "Grace Kennedy",
		"distance" => 3.1,
		"time" => "21:26"
	),
	array(
		"user" => "Ryan Muller",
		"distance" => 2.0,
		"time" => "16:24"
	)
);
?>
<html>
<head>
	<link rel="stylesheet" href="css/orange.css" />
	<link rel="stylesheet" href="css/semantic.min.css" />
	
</head>
<body>
	<div class="ui fixed main menu">
		<div class="container">
			<div class="main title item" id="brand">
				<span class="logo"><img class="logo" src="images/orange.png" height="30px" /></span>
				Orange
			</div>
			<a class="active item">
				<i class="home icon"></i>
				Home
			</a>
			<a class="item">
				<i class="user icon"></i>
				Profile
			</a>
			<div class="right menu">
				<a class="item">
					<i class="edit icon"></i>
					Sign up
				</a>
				<div class="item">
					<div class="ui icon input">
						<input placeholder="Find a user" type="text">
						<i class="search link icon"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="main_content">
		<div class="ui piled feed segment">
			<h2 class="ui header">Recent activity</h2>
			<?php foreach($feedItems as $item) { ?>
			<div class="event">
				<div class="circular label">
					<img src="http://robohash.org/<?= hash('ripemd160',$item["user"]) ?>.png?size=100x100&bgset=any">
				</div>
				<div class="content">
				  <div class="summary">
					 <a href="#"><?= $item["user"] ?></a> ran <?= $item["distance"] ?> miles in <?= $item["time"] ?>
				  </div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</body>
</html>
