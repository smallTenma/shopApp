<?php
header("content-type:text/html;charset=utf-8");
header("content-type:text/json;charset=utf-8");
header("Cache-control:no-cache");
header("Access-control-allow-origin:*");
session_start();
if(isset($_SESSION["usernameId"])&isset($_SESSION["level"])){
    $usernameId=$_SESSION["usernameId"];
    $level=$_SESSION["level"];
    $arr=array($usernameId,$level);
    $json=json_encode($arr);
    echo $json;
}else{
    echo 1;
}
