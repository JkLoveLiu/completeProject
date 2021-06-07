<?php
session_start();
header('Access-Control-Allow-Origin: *');
// 判断是否已经登录
if (isset($_SESSION['isLog'])){
    // 已经登录
    echo 1;
}else{
    // 未登录
    echo 2;
}