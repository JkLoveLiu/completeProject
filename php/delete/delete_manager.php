<?php
session_start();
header('Access-Control-Allow-Origin: *');

$dbHost = $_SESSION['dbHost'];
$dbUser = $_SESSION['dbUser'];
$dbPwd = $_SESSION['dbPwd'];
$dbName = $_SESSION['dbName'];
$tbManage = $_SESSION['tbManage'];
$tbClient = $_SESSION['tbClient'];

$id = $_GET['id'];
// 连接数据库
$conn = mysqli_connect($dbHost, $dbUser, $dbPwd, $dbName);
if ($_SESSION['id'] === $id) {
    echo 22;
} else {
    $sql = "delete from $dbName.$tbManage where id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo 11;
    }
}
mysqli_close($conn);