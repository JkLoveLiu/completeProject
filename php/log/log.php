<?php
session_start();
header('Access-Control-Allow-Origin: *');

include '../config.php';

$dbHost = $localhost;           // mysql服务器主机地址
$dbUser = $databaseUserName;    // mysql用户名
$dbPwd = $databasePwd;          // mysql用户名密码
$dbName = $databaseName;        // 数据库名称
$tbManage = $tableManager;      // 管理员数据表
$tbClient = $tableClient;       // 客户数据表

$_SESSION['dbHost'] = $dbHost;
$_SESSION['dbUser'] = $dbUser;
$_SESSION['dbPwd'] = $dbPwd;
$_SESSION['dbName'] = $dbName;
$_SESSION['tbManage'] = $tbManage;
$_SESSION['tbClient'] = $tbClient;


    /*
     * @登录验证页面
     * 1=>验证码错误，2=>用户名或者密码错误，3=>登陆成功，4=>账号被禁用
     */
// 获取用户名
$username = $_POST['username'];
// 获取密码
$userPwd = $_POST['pwd'];

$conn = mysqli_connect($dbHost, $dbUser, $dbPwd, $dbName);
if ($_POST['captcha'] == $_SESSION['yzmStr']) {
    $sql = "select * from $dbName.$tbManage where username='$username' and pwd='$userPwd'";
    $rst = mysqli_query($conn, $sql);

    if ($rst) {
        if (mysqli_num_rows($rst) == 1) {
            // 查询到的所有数据
            $res = mysqli_fetch_assoc($rst);
            // 传递所有数据
            $_SESSION['id'] = $res['id'];
            $_SESSION['name'] = $res['name'];
            $_SESSION['power'] = $res['power'];
            if ($res['statue'] === '0') {
                // 用户名密码正确的情况下
                $_SESSION['isLog'] = true;
                // 传递账号信息
                $_SESSION['userName'] = $username;
                // 关闭数据库连接
                mysqli_close($conn);
                die('3');
            } else {
                die('4');
            }
        } else {
            die('2');
            // 用户名或密码不正确
        }
    }
} else {
    die('1');     // 验证码错误
}




