<?php

$db = new SQLite3(__DIR__."/orange.db");

function main_feed(){
	?>
	<div class="ui piled feed segment">
			<h2 class="ui header">Recent activity</h2>
			<?php foreach(getRecentActivities() as $item) { ?>
			<div class="event">
				<div class="circular label">
					<img src="http://robohash.org/<?= hash('ripemd160',$item["user"]) ?>.png?size=100x100&bgset=any">
				</div>
				<div class="content">
				  <div class="summary">
					 <a href="/orange/u/<?= $item["uname"] ?>"><?= $item["user"] ?></a> ran <a href="/orange/u/<?= $item["uname"].'/'.$item["id"] ?>"><?= number_format($item["distance"]/1609,2) ?> miles</a> in <?= asTime($item["duration"]) ?>
				  </div>
				  <div class="date">
					  <?= strftime("%B %e %Y, %I:%M %p", $item["ts"]/1000) ?>
				  </div>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php
}

function pad($n){
	if($n<10) return "0".$n;
	return $n;
}

function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function asTime($dur) {
	$millis = floor(floor($dur % 1000) / 100);
	$dur /= 1000;
	$secs = ($dur % 60);
	$dur /= 60;
	$mins = floor($dur % 60);
	$dur /= 60;
	$hours = floor($dur);
	if ($hours > 0) {
		return $hours . ":" . pad($mins) . ":" . pad($secs);
	//*
	} else {
		return $mins .":" . pad($secs);
	}//*/
}

function checkUserAndKey($user, $key){
	global $db;
	$result = $db->query("SELECT name FROM users WHERE username = '$user' AND passkey = '$key';");
	if($result) return true;
	return false;
}

function getRecentActivities(){
	global $db;
	$activities = array();
	
	$query = "SELECT id, ts, owner, distance, duration, users.username as uname, users.name as full_name FROM activity JOIN users ON users.username = activity.owner ORDER BY ts LIMIT 10;";

	try{
		$result = $db->query($query);
		if(!$result) return $activities;
		//*
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			$row["user"] = $row["full_name"];
			array_push($activities, $row);
		}//*/
		return $activities;
	}catch(Exception $e){
		echo $e;
		return $activities;
	}
	//*/
}

function getUsersByQuery($q){
	global $db;
	$query = "SELECT name, username FROM users WHERE name LIKE '%$q%' OR username LIKE '%$q%';";
	header("Content-type: application/json");
	$users = array();
	try{
		$res = $db->query($query);
		if(!$res) return $users;
		while($row = $res->fetchArray(SQLITE3_ASSOC)){
			$row["label"] = $row["name"];
			array_push($users,$row);
		}
		return $users;
	}catch(Exception $e){
		return $users;
	}
}

function addRun($a){
	global $db;
	$query = "INSERT INTO `activity` (owner, ts, activity_name,".
		" distance, duration, rating) VALUES (\"".$a["owner"].
		"\", ".$a["ts"].", \"".$a["activity_name"]."\", ".
		$a["distance"].", ".$a["duration"].", ".$a["rating"].");";
	$db->exec($query);
	$id = $db->lastInsertRowID();
	foreach($a["points"] as $pt){
		$query = "INSERT INTO `trackPoint` (activity, ts, lat, lon, ".
			"sigma, duration, distance) VALUES ($id, ".$pt["ts"].
			", ".$pt["lat"].", ".$pt["lon"].", ".$pt["sigma"].",".
			$pt["duration"].", ".$pt["distance"].");";
		$db->exec($query);
	}
}
