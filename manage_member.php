<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/29
     * Time: 13:36
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','manage_member');
    require dirname(__FILE__).'/includes/common.inc.php';
    //delete
    if (@$_GET['action'] == 'del' &&  @isset($_GET['id'])) {

        query(" DELETE FROM tg_user WHERE tg_id='{$_GET['id']}' ");
        if (affectedRow()==1) {
            alertLocation('删除成功','manage_member.php');
        }
    }



    page("SELECT COUNT(tg_id) as NUM  FROM tg_user  ",$system['article']);
    $result = query("SELECT 
															tg_id,
															tg_username,
															tg_email,
															tg_reg_time
									FROM 
												tg_user 
							ORDER BY 
												tg_reg_time DESC 
									 LIMIT 
												$pagenum,$pagesize
							");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $system['webname'] ?>--会员列表</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>
    <div id="member">
        <?php require ROOT_PATH.'includes/manage.inc.php'; ?>
        <div id="member_main">
            <h2>会员列表中心</h2>
            <form method="post" action="?action=delete">
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
                            ?>
                            <tr><td><?php echo $html['id']?></td><td><?php echo $html['username']?></td><td><?php echo $html['email']?></td><td><?php echo $html['reg_time']?></td><td>[<a href="?action=del&id=<?php echo $html['id']?>">删</a>] [修]</td></tr>
                        <?php }?>
                </table>
            </form>
            <?php

                 paging(2);
            ?>
        </div>
    </div>
    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>
