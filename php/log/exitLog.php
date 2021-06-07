<?php
session_start();
header('Access-Control-Allow-Origin: *');
// 退出登录
unset($_SESSION['userName']);
unset($_SESSION['isLog']);
echo 4;
