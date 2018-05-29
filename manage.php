<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/28
     * Time: 20:37
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','manage');
    require dirname(__FILE__).'/includes/common.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $system['webname'] ?>-后台管理中心</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>
    <div id="member">
        <?php require ROOT_PATH.'includes/manage.inc.php'; ?>
        <div id="member_main">
            <h2>后台管理中心</h2>
            <dl>
                <dd>·服务器主机名称：<?php echo $_SERVER['SERVER_NAME']; ?></dd>
                <dd>·通信协议名称/版本：<?php echo $_SERVER['SERVER_PROTOCOL']; ?></dd>
                <dd>·服务器IP：<?php echo $_SERVER["SERVER_ADDR"]; ?></dd>
                <dd>·客户端IP：<?php echo $_SERVER["REMOTE_ADDR"]; ?></dd>
                <dd>·服务器端口：<?php echo $_SERVER['SERVER_PORT']; ?></dd>
                <dd>·客户端端口：<?php echo $_SERVER["REMOTE_PORT"]; ?></dd>
                <dd>·Host头部的内容：<?php echo $_SERVER['HTTP_HOST']; ?></dd>
                <dd>·服务器主目录：<?php echo $_SERVER["DOCUMENT_ROOT"]; ?></dd>
                <dd>·Apache及PHP版本：<?php echo $_SERVER["SERVER_SOFTWARE"]; ?></dd>
            </dl>
        </div>
    </div>
    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>

