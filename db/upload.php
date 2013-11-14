<?php

$user = $_GET["user"];
$key  = $_GET["key"];

$data = file_get_contents("php://input");


if(!checkUserAndKey($user, $key)){
	file_put_contents(__DIR__ . "/log", "*** auth fail ***\n", FILE_APPEND);
	header("Content-type: application/json", true, 401);
	echo "{}";
	exit;
}else{
	file_put_contents(__DIR__ . "/log", "*** auth success! ***\n", FILE_APPEND);
}

/*
 * structure:
 * 
 * +-- owner
 * +-- activity_name
 * +-- ts
 * +-- rating
 * +-- distance
 * +-- duration
 * +-+ points
 *   |
 *   +-- ts
 *   +-- lat
 *   +-- lon
 *   +-- sigma
 *   +-- duration
 *   +-- distance
 */
 
file_put_contents(__DIR__ . "/log", "decoding\n", FILE_APPEND);
try{
	$data = json_decode($data,true);
}catch(Exception $e){
	file_put_contents(__DIR__ . "/log", "error $e\n", FILE_APPEND);
}

$data['owner'] = $user;
$dd = print_r($data, true);

file_put_contents(__DIR__ . "/log", "done\n$dd\n", FILE_APPEND);
file_put_contents(__DIR__ . "/log", "starting\n", FILE_APPEND);
addRun($data);



