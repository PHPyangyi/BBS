<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/27
     * Time: 22:09
     */
    define('IN_TG',true);
    define('SCRIPT','member_flower');
    require dirname(__FILE__).'/includes/common.inc.php';

    if (@$_GET['action'] == 'delete' && isset($_POST['ids'])) {
        include ROOT_PATH.'includes/check_func.php';
        $clean = array();
        $clean['ids'] = mysqlString(implode(',',$_POST['ids']));
        if ($rows = fetchArray("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
            checkUniqid($rows['tg_uniqid'],$_COOKIE['uniqid']);
            query("DELETE FROM 
												tg_flower 
								  WHERE 
												tg_id 
											IN 
												({$clean['ids']})"
            );
            if (affectedRow() == 1) {
                mysqlClose();
                //session_unset();
                //session_destroy();
                alertLocation('花花删除成功','member_flower.php');

            } else {
                mysqlClose();
                //session_unset();
                //session_destroy();
                alertLocation('花花删除成功','member_flower.php');
            }

        } else {
            alertBack('非法登录');
        }
    }


    $result = query("SELECT 
                                *
                           FROM
                                tg_flower
                           WHERE 
                                tg_touser='{$_COOKIE['username']}'
                           ORDER BY 
                                 tg_date DESC       
                    ");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统--花朵列表</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
    <script type="text/javascript" src="js/member_message.js"></script>
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>
    <div id="member">
        <?php require ROOT_PATH.'includes/member.inc.php'; ?>
    <div id="member_main">
        <h2>花朵管理中心</h2>
        <form method="post" action="?action=delete">
            <table cellspacing="1">
                <tr><th>送花人</th><th>花朵数目</th><th>感言</th><th>时间</th><th>操作</th></tr>
                <?php
                    $html = array();
                    while ($rows = fetchArrayList($result)) {
                        $html['id'] = $rows['tg_id'];
                        $html['fromuser'] = $rows['tg_fromuser'];
                        $html['content'] = $rows['tg_content'];
                        $html['flower'] = $rows['tg_flower'];
                        $html['date'] = $rows['tg_date'];
                        $html = Html($html);
                        @$html['count'] += $html['flower'];
                        ?>
                        <tr><td><?php echo $html['fromuser']?></td><td><img src="images/x4.gif" alt="花朵" /> x <?php echo $html['flower']?>朵</td><td><?php echo Title($html['content'])?></td><td><?php echo $html['date']?></td><td><input name="ids[]" value="<?php echo $html['id']?>" type="checkbox" /></td></tr>
                        <?php
                    }
                ?>
                <tr><td colspan="5">共<strong><?php echo $html['count']?></strong>朵花</td></tr>
                <tr><td colspan="5"><label for="all">全选 <input type="checkbox" name="chkall" id="all" /></label> <input type="submit" value="批删除" /></td></tr>
            </table>
        </form>
        </div>
    </div>

    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>

