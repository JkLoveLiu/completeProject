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
$username = $_POST['username'];
$pwd = $_POST['pwd'];
$name = $_POST['name'];
$power = $_POST['power'];
$statue = $_POST['statue'];
//print_r($_POST);
$conn = mysqli_connect($dbHost, $dbUser, $dbPwd, $dbName);
// 查询数据库，账号是否重复
$sql = "select * from $dbName.$tbManage where username='$username'";
$res = mysqli_query($conn,$sql);
if (mysqli_num_rows($res) === 1){
    echo 3;
}else{
    $sql = "insert into $dbName.$tbManage (username, pwd, name, power, statue) VALUES ('$username','$pwd','$name','$power','$statue')";
    if (mysqli_query($conn, $sql)) {
//     修改成功
        echo 2;
    } else {
        echo 1;
    }
}


mysqli_close($conn);