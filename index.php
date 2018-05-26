<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/26
     * Time: 12:39
     */
    define('IN_TG',true);
    define('SCRIPT','index');
    require  dirname(__FILE__).'/includes/common.inc.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <?php require ROOT_PATH.'/includes/title.inc.php' ?>
</head>
<body>

    <?php require  ROOT_PATH.'/includes/header.inc.php'?>

    <div id="list">
        <h2>帖子列表</h2>
    </div>

    <div id="user">
        <h2>新进会员</h2>
    </div>

    <div id="pics">
        <h2>最新图片</h2>
    </div>

    <?php require ROOT_PATH.'/includes/footer.inc.php'?>



</body>
</html>