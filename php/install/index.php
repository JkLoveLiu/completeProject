<?php
include '../config.php';

$dbHost = $localhost;
$dbUser = $databaseUserName;
$dbPwd = $databasePwd;
$dbName = $databaseName;
$tbManage = $tableManager;
$tbClient = $tableClient;

$getData = $_POST;
/*
 * [echoContent] => true
 * [localhost] => 127.0.0.1
 * [name] => root
 * [password] => root
 * [manager] => manager
 * [client] => client
 */

if ($_POST['echoContent']) {
    $writeData = '<?php ';
    // 数据库地址
    $writeData .= '$localhost = "' . $getData['localhost'] . '";' .
        //  数据库用户名
        '$databaseUserName = "' . $getData['username'] . '";' .
        // 数据库密码
        '$databasePwd = "' . $getData['password'] . '";' .
        //  数据库名称
        '$databaseName = "' . $getData['name'] . '";' .
        //  管理员数据表
        '$tableManager = "' . $getData['manager'] . '";' .
        //  客户数据表
        '$tableClient = "' . $getData['client'] . '";';
    $filename = '../config.php';
    $fp = fopen($filename, "w");  //w是写入模式，文件不存在则创建文件写入。
    $len = fwrite($fp, $writeData);
    fclose($fp);
}
if ($_POST['createDB']) {
    $conn = mysqli_connect($dbHost, $dbUser, $dbPwd);
    if (!$conn) {
        echo '连接错误: ' . mysqli_error($conn);
    } else {
        $sql = "CREATE DATABASE $dbName";
        $res = mysqli_query($conn, $sql);
        if (!$res) {
            echo '创建数据库失败: ' . mysqli_error($conn);
        } else {
            echo "数据库创建成功\n";
        }
    }
}
if ($_POST['createTbClient']) {
    $conn = mysqli_connect($dbHost, $dbUser, $dbPwd);
    if (!$conn) {
        echo '连接错误: ' . mysqli_error($conn);
    } else {
        // 客户信息表
        $sql = "CREATE TABLE `$tbClient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT '客户姓名',
  `type` int(16) NOT NULL DEFAULT '1' COMMENT '客户类型（1，企业，0，个人）',
  `statue` int(16) NOT NULL DEFAULT '1' COMMENT '客户类型（1,潜在，2,意向，3,现有，4,代理，5,供应商，0,无效）',
  `manager` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '客户所属人',
  `require` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '客户需求',
  `phone` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '客户联系方式',
  `endedittime` datetime DEFAULT NULL,
  `datetime` datetime NOT NULL COMMENT '创建时间',
  `complete` int(16) NOT NULL DEFAULT '1' COMMENT '完成状态（0，完成，1，未完成）',
  `address` int(16) NOT NULL COMMENT '客户地址(1,华北，2，东北，3，华东，4，华中，5，华南，6，西南，7，西北，0，港澳台）',
  `industry` int(16) NOT NULL COMMENT '客户行业（1，IT互联网，2，金融保险，3，房地产建筑，4，教育培训，5，娱乐传媒，6，医疗健康，7，法律咨询，8，供应链物流，0，其他）',
  `call` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '称呼',
  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        mysqli_select_db($conn, $dbName);
        $res = mysqli_query($conn, $sql);
        if (!$res) {
            echo '创建客户信息表失败: ' . mysqli_error($conn);
        } else {
            echo "数据表创建成功\n";
        }
    }
}
if ($_POST['createTbManage']) {
    $conn = mysqli_connect($dbHost, $dbUser, $dbPwd);
    // 管理员表
    $sql = "CREATE TABLE `$tbClient` (
  `id` int(16) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `username` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `pwd` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `power` int(16) NOT NULL DEFAULT '2' COMMENT '权限（0为总经理，1为经理，2为游客）',
  `statue` int(4) NOT NULL DEFAULT '1' COMMENT '状态(1为禁止操作）',
  PRIMARY KEY (`id`,`username`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=194 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    mysqli_select_db($conn, $dbName);
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        echo '创建管理员表失败: ' . mysqli_error($conn);
    } else {
        echo "数据表创建成功\n";
    }
}
if ($_POST['createUser']) {
    $conn = mysqli_connect($dbHost, $dbUser, $dbPwd, $dbName);
    $sql = "insert into $dbName.$tbManage (username, pwd, name, power, statue) 
            VALUES ('admin','222222','最高权限','0','0')";
    if (mysqli_query($conn, $sql)) {
        echo '管理员账户创建成功';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>配置数据库</title>
    <style>
        table tr {
            height: 35px
        }

        .btn {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<p style="text-align: center;font-size: 18px;color: red">测试完成后请及时删掉install文件夹</p>
<hr style="width: 100%">
<form method="post" action="index.php" style="float: left;margin-left: 400px">
    <input type="hidden" name="echoContent" placeholder="输入数据库地址" value="true">
    <table style="text-align: right;">
        <tr>
            <td colspan="2" style="text-align: center">数据库配置</td>
        </tr>
        <tr>
            <td>数据库地址</td>
            <td>
                <label>
                    <input type="text" name="localhost" placeholder="输入数据库地址">
                </label>
            </td>
        </tr>
        <tr>
            <td>数据库用户名</td>
            <td>
                <label>
                    <input type="text" name="username" placeholder="输入数据库用户名">
                </label>
            </td>
        </tr>
        <tr>
            <td>数据库密码</td>
            <td>
                <label>
                    <input type="text" name="password" placeholder="输入数据库密码">
                </label>
            </td>
        </tr>
        <tr>
            <td>数据库名</td>
            <td>
                <label>
                    <input type="text" name="name" placeholder="输入数据库名">
                </label>
            </td>
        </tr>
        <tr>
            <td>数据库端口号</td>
            <td>
                <label>
                    <input type="text" name="port" placeholder="输入数据库端口号" value="3306">
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">数据表配置</td>
        </tr>
        <tr>
            <td>管理员数据表</td>
            <td>
                <label>
                    <input type="text" name="manager" placeholder="输入管理员数据表名">
                </label>
            </td>
        </tr>
        <tr>
            <td>客户数据表</td>
            <td>
                <label>
                    <input type="text" name="client" placeholder="输入客户数据表名">
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="配置数据库">
            </td>
            <td><input type="button" value="刷新" id="reload"></td>
        </tr>
    </table>
    <p style="text-align: center;font-size: 18px;color: red">请确认数据库配置正确</p>
</form>
<div style="width: 200px;float: right;margin-right: 400px">
    <table>
        <tr>
            <td>数据库地址</td>
            <td>
                <?php
                echo $dbHost;
                ?>
            </td>
        </tr>
        <tr>
            <td>数据库用户名</td>
            <td>
                <?php
                echo $dbUser;
                ?>
            </td>
        </tr>
        <tr>
            <td>数据库密码</td>
            <td>
                <?php
                echo $dbPwd;
                ?>
            </td>
        </tr>
        <tr>
            <td>数据库名称</td>
            <td>
                <?php
                echo $dbName;
                ?>
            </td>
        </tr>
        <tr>
        <tr>
            <td>管理员数据表名</td>
            <td>
                <?php
                echo $tbManage;
                ?>
            </td>
        </tr>
        <tr>
            <td>客户数据表名</td>
            <td>
                <?php
                echo $tbClient;
                ?>
            </td>
        </tr>
    </table>
    <p style="text-align: center;font-size: 18px;color: red">请确认数据库配置正确</p>
    <hr style="width: 100%">
    <form action="./index.php" method="post">
        <button name="createDB" value="true" class="btn">建立数据库</button>
        <button name="createTbManage" value="true" class="btn">建立管理员数据表</button>
        <button name="createTbClient" value="true" class="btn">建立客户数据表</button>
        <button name="createUser" value="true" class="btn" id="btn">建立管理员账户</button>
    </form>
</div>
<script>
    document.getElementsByTagName('form')[0].onsubmit = function () {
        window.location.reload()
    }
    document.getElementById('reload').onclick = function () {
        window.location.reload()
    }
    document.getElementById('btn').onclick = function () {
        alert('管理员账号：admin   密码：222222，请登陆后修改密码')
    }
</script>
</body>
</html>
