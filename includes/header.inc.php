<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/26
     * Time: 13:14
     */
    if (!defined('IN_TG')) {
        exit('error');
    }
?>
<script type="text/javascript" src="js/skin.js"></script>
<div id="header">
    <h1><a href="index.php">YANGweb俱乐部多用户留言系统</a></h1>
    <ul>
        <li><a href="index.php">首页&nbsp&nbsp&nbsp</a></li>
        <?php
            if (isset($_COOKIE['username'])){
                echo '<li><a href="member.php">'.$_COOKIE['username'].'·个人中心</a>'.$GLOBALS['message'].'</li>';
                echo "\n";
            } else {
                echo '<li><a href="register.php">注册</a></li>';
                echo "\n";
                echo "\t\t";
                echo '<li><a href="login.php">登录</a></li>';
                echo "\n";
            }
        ?>
        <li><a href="blog.php">&nbsp&nbsp&nbsp博友</a></li>
        <li><a href="photo.php">&nbsp&nbsp&nbsp相册</a></li>
        <li class="skin" onmouseover='inskin()' onmouseout='outskin()'>
            <a href="javascript:;">&nbsp&nbsp&nbsp风格</a>
            <dl id="skin">
                <dd><a href="skin.php?id=1">1.一号皮肤</a></dd>
                <dd><a href="skin.php?id=2">2.二号皮肤</a></dd>
                <dd><a href="skin.php?id=3">3.三号皮肤</a></dd>
            </dl>
        </li>
        <?php
            if (isset($_COOKIE['username']) && isset($_SESSION['admin'])) {
                echo '<li><a href="manage.php" class="manage">&nbsp&nbsp&nbsp管理</a></li> ';
            }
            if (isset($_COOKIE['username'])){
                echo '<li><a href="logout.php">&nbsp&nbsp&nbsp退出</a></li>';
            }
        ?>
    </ul>
</div>