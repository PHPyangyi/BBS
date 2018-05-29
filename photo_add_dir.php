<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/29
     * Time: 14:16
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','photo_add_dir');
    require dirname(__FILE__).'/includes/common.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo  $system['webname'] ?>--相册添加 </title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
    <script type="text/javascript" src="js/photo_add_dir.js"></script>
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>
    <div id="photo">
        <h2>添加相册目录</h2>
        <form method="post" action="?action=adddir">
            <dl>
                <dd>相册名称：<input type="text" name="name" class="text" /></dd>
                <dd>相册类型：<input type="radio" name="type" value="0" checked="checked" /> 公开 <input type="radio" name="type" value="1" /> 私密</dd>
                <dd id="pass">相册密码：<input type="password" name="password" class="text" /></dd>
                <dd>相册描述：<textarea name="content"></textarea></dd>
                <dd><input type="submit" class="submit" value="添加目录" /></dd>
            </dl>
        </form>
    </div>
    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>
