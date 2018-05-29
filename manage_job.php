<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/29
     * Time: 13:52
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','manage_job');
    require dirname(__FILE__).'/includes/common.inc.php';
    //添加管理员
    if (@$_GET['action'] == 'add') {
        include ROOT_PATH.'includes/check_func.php';
        if ($rows = fetchArray("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
            checkUniqid($rows['tg_uniqid'],$_COOKIE['uniqid']);
            $clean = array();
            $clean['username'] = $_POST['manage'];
            $clean = mysqlString($clean);
            //添加管理员
            query("UPDATE tg_user SET tg_level=1 WHERE tg_username='{$clean['username']}'");

            if (affectedRow() == 1) {
                mysqlClose();
                alertLocation('恭喜你，管理员添加成功！',SCRIPT.'.php');
            } else {
                mysqlClose();
                alertBack('管理员添加失败！原因：不存在此用户或者为空');
            }
        }  else {
            alertBack('非法登录！');
        }
    }
    //update
    if (@$_GET['action'] == 'job' && isset($_GET['id'])){
            //辞职
            @query("UPDATE tg_user SET tg_level=0 WHERE tg_username='{$_COOKIE['username']}' AND tg_id='{$_GET['id']}'");
            if (affectedRow() == 1) {
                mysqlClose();

                alertLocation('辞职成功！','index.php');
            } else {
                mysqlClose();
                _alert_back('辞职失败！');
            }
        }




    page("SELECT COUNT(tg_id) as NUM  FROM tg_user WHERE tg_level=1  ",$system['article']);
    $result = query("SELECT * FROM  tg_user WHERE tg_level=1 ORDER BY  tg_reg_time DESC LIMIT  $pagenum,$pagesize ");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $system['webname'] ?>--职务设置</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>
    <div id="member">
        <?php require ROOT_PATH.'includes/manage.inc.php'; ?>
    <div id="member_main">
        <h2>会员列表中心</h2>
        <table cellspacing="1">
            <tr><th>ID号</th><th>会员名</th><th>邮件</th><th>注册时间</th><th>操作</th></tr>
            <?php
                $html = array();
                while ($rows = fetchArrayList($result)) {
                    $html['id'] = $rows['tg_id'];
                    $html['username'] = $rows['tg_username'];
                    $html['email'] = $rows['tg_email'];
                    $html['reg_time'] = $rows['tg_reg_time'];
                    $html = Html($html);
                    if (@$_COOKIE['username'] == $html['username']) {
                        $html['job_html'] = '<a href="manage_job.php?action=job&id='.$html['id'].'">辞职</a>';
                    } else {
                        $html['job_html'] = '无权操作！';
                    }
                    ?>
                    <tr><td><?php echo $html['id']?></td><td><?php echo $html['username']?></td><td><?php echo $html['email']?></td><td><?php echo $html['reg_time']?></td><td><?php echo $html['job_html']?></td></tr>
                <?php }?>
        </table>
        <form method="post" action="?action=add">
            <input type="text" name="manage" class="text" /> <input type="submit" value="添加管理员" />
        </form>
        <?php
            paging(2);
        ?>
        </div>
    </div>

    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>
