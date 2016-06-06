<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$servername = "laravel-devtim.cjczjvx3sd7d.us-west-1.rds.amazonaws.com";
$username = "laravel";
$password = "Televisa2010..";
$dbname = "vcms2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo '<div style="color:red;"><br>'."Connected successfully".'<br></div>';

$sql = DB::insert("INSERT INTO LogsProcess (action, vod_id, unixTimeStart, log, unixTimeEnd, deltaUnixTime) VALUES ('.$action.','.$vod_id.','.$unixTimeStart[$j].','.$log.','.$unixTimeEnd.','.$deltaUnixTime.')");
//$sql  = "INSERT INTO log (action,vod_id,unixTimeStart,log,unixTimeEnd) VALUES ('.$action.','.$vod_id.','.$unixTimeStart.','.$log.','.$unixTimeEnd.')";

if ($sql === TRUE) {
    echo '<div style="color:red;">Nuevo Registro creado correctamente..<br></div>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


