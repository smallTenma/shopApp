<?php
header("content-type:text/html;charset=utf-8");
header("content-type:text/json;charset=utf-8");
header("Cache-control:no-cache");
header("Access-control-allow-origin:*");
require 'model/auto_load.php';
require_once 'controller/Func.class.php';
$class="";
$action="";
if(isset($_GET["class"])&isset($_GET["action"])){
    $class=$_GET["class"];
    $action=$_GET["action"];
}else if(isset($_POST["class"])&isset($_POST["action"])){
    $class=$_POST["class"];
    $action=$_POST["action"];
}else{
    die("方法不匹配");
}
$obj=new $class();
$obj->$action();
if(isset($obj->error)){
    echo "<script text/javascript>alert(\"{$obj->error}\")</script>";
   // header("http/1.1 303 see other");
    header("Refresh:0;url=view/signin.html");
}else if(isset($obj->success)){
    if(isset($obj->url)){
        $url=$obj->url;
        header("location:{$url}");
    }else{
        echo $obj->success;
    }
}