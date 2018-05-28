<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/26
     * Time: 19:22
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','login');
    require dirname(__FILE__).'/includes/common.inc.php';
    loginState();
    if (@$_GET['action'] == 'login') {
        checkCode($_POST['code'],$_SESSION['code']);
        include ROOT_PATH.'includes/check_func.php';
        $clean=array();
        $clean['username'] = checkUsername($_POST['username'],2,20);
        $clean['password'] = checkLoginPassword($_POST['password'],6);
        $clean['time'] = checkTime($_POST['time']);
        if (!!$rows = fetchArray("SELECT tg_username,tg_uniqid,tg_level FROM tg_user
                                                                                      WHERE tg_username='{$clean['username']}'
                                                                                      AND tg_password='{$clean['password']}'
                                                                                      AND tg_active=''
                                                                                      LIMIT 1"))
        {
              query("UPDATE tg_user SET
                                              tg_last_time=NOW(),
											  tg_last_ip='{$_SERVER["REMOTE_ADDR"]}',
											  tg_login_count=tg_login_count+1
											  WHERE
											  tg_username='{$rows['tg_username']}'
                                              ");

              SetCookies($rows['tg_username'],$rows['tg_uniqid'],$clean['time']);
              if ($rows['tg_level'] == 1) {
                  $_SESSION['admin'] = $rows['tg_username'];
              }

              alertLocation(null,'member.php');
            mysqlClose();
              //echo $_COOKIE['username'];
        } else {
            alertLocation('用户名密码不正确或者该账户未被激活！','login.php');
            mysqlClose();
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统--登录</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
    <script type="text/javascript" src="js/login.js"></script>
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>
    <div id="login">
        <h2>登录</h2>
        <form method="post" name="login" action="login.php?action=login">
            <dl>
                <dt></dt>
                <dd>用 户 名 ：<input type="text" name="username" class="text" /></dd>
                <dd>密　　码：<input type="password" name="password" class="text" /></dd>
                <dd>保　　留：<input type="radio" name="time" value="0" checked="checked" /> 不保留 <input type="radio" name="time" value="1" /> 一天 <input type="radio" name="time" value="2" /> 一周 <input type="radio" name="time" value="3" /> 一月</dd>
                <dd>验 证 码：<input type="text" name="code" class="text code"  /> <img src="code.php" id="code" onclick="this.src='code.php?tm='+Math.random() " /></dd>
                <dd><input type="submit" value="登录" class="button" /> <input type="button" value="注册" id="location" class="button location" /></dd>
            </dl>
        </form>
    </div>
    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>