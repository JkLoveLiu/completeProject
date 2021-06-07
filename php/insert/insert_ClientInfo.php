<?php
session_start();
header('Access-Control-Allow-Origin: *');

$dbHost = $_SESSION['dbHost'];
$dbUser = $_SESSION['dbUser'];
$dbPwd = $_SESSION['dbPwd'];
$dbName = $_SESSION['dbName'];
$tbManage = $_SESSION['tbManage'];
$tbClient = $_SESSION['tbClient'];

// 增加管理用户数据
/*
Array
(
    [name] => 22
    [formType] => 0
    [statue] => 1
    [manager] => 22
    [require] => 22
    [phone] => 22
    [complete] => 0
    [address] => 222
    [callName] => 222
    [industry] => 222
)
*/
$name = $_POST['name'];
$formType = $_POST['formType'];
$statue = $_POST['statue'];
$manager = $_POST['manager'];
$require = $_POST['require'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$callName = $_POST['callName'];
$industry = $_POST['industry'];
$dateTime = date('Y-m-d H:i:s');

$conn = mysqli_connect($dbHost, $dbUser, $dbPwd, $dbName);

$sql = "insert into $dbName.$tbClient (name, type, statue, manager, `require`, phone, datetime, complete, address, industry, `call`)
values ('$name','$formType','$statue','$manager','$require','$phone','$dateTime',1,'$address','$industry','$callName')";

$res = mysqli_query($conn, $sql);
if ($res) {
//     修改成功
    echo 2;
} else {
    echo 1;
}


mysqli_close($conn);