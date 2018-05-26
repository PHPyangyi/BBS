<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/26
     * Time: 19:10
     */
    define('IN_TG',true);
    define('SCRIPT','active');
    require dirname(__FILE__).'/includes/common.inc.php';
    if (!isset($_GET['active'])) {
        alertBack('非法操作');
    }

    if (isset($_GET['action']) && isset($_GET['active']) && $_GET['action'] == 'ok') {
        $active = mysqlString($_GET['active']);
        if (fetchArray("SELECT 
												tg_active 
									FROM 
												tg_user 
								WHERE 
												tg_active='$active' 
									LIMIT 
														1"
        )) {
            //将tg_active设置为空
            query("UPDATE tg_user SET tg_active=NULL WHERE tg_active='$active' LIMIT 1");
            if (affectedRow() == 1) {
                mysqlClose();
                alertLocation('账户激活成功','login.php');
            } else {
                mysqlClose();
                alertLocation('账户激活失败','register.php');
            }
        } else {
            alertBack('非法操作');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统--激活</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
    <script type="text/javascript" src="js/register.js"></script>
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>

    <div id="active">
        <h2>激活账户</h2>
        <p>本页面是为了模拟您的邮件的功能，点击以下超级连接激活您的账户</p>
        <p><a href="active.php?action=ok&amp;active=<?php echo $_GET['active']?>"><?php echo 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>active.php?action=ok&amp;active=<?php echo $_GET['active']?></a></p>
    </div>

    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>