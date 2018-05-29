<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/27
     * Time: 15:41
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','member_message_detail');
    require dirname(__FILE__).'/includes/common.inc.php';
    //login
    if (!isset($_COOKIE['username'])) {
        alertBack('请先登录！');
    }
    //delete
    if (@$_GET['action'] == 'delete' && isset($_GET['id'])) {
        include ROOT_PATH.'includes/check_func.php';
        if ($rows = fetchArray("SELECT tg_id FROM tg_message WHERE tg_id='{$_GET['id']}' LIMIT  1")) {
            if ($rows = fetchArray("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT  1")) {
                checkUniqid($rows['tg_uniqid'],$_COOKIE['uniqid']);
                //delete
                query("DELETE FROM tg_message WHERE  tg_id='{$_GET['id']}' LIMIT 1");
                if (affectedRow() == 1) {
                    mysqlClose();
                    //session_unset();
                    //session_destroy();
                    alertLocation('短信删除成功','member_message.php');

                } else {
                    mysqlClose();
                    //session_unset();
                    //session_destroy();
                    alertBack('短信删除失败');
                }
            } else {
                alertBack('非法登录！');
            }
        } else {
            alertBack('此短信不存在！');
        }
    }



    if (isset($_GET['id'])) {
        $rows = fetchArray("SELECT 
															tg_id,tg_state,tg_fromuser,tg_content,tg_date
												FROM 
															tg_message 
											 WHERE 
															tg_id='{$_GET['id']}' 
												 LIMIT 
															1
										");
        if ($rows) {
            if (empty($rows['tg_state'])) {
                query("UPDATE 
											tg_message 
								 SET 
											tg_state=1 
							WHERE 
											tg_id='{$_GET['id']}' 
								LIMIT 
											1
		");
                if (!affectedRow()) {
                    alertBack('异常！');
                }
            }
            $html= array();
            $html['id']= $rows['tg_id'];
            $html['fromuser'] = $rows['tg_fromuser'];
            $html['content'] = $rows['tg_content'];
            $html['date'] = $rows['tg_date'];
            $html = Html($html);
        } else {
            alertBack('此短信不存在！');
        }
    } else {
        alertBack('非法登录');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $system['webname'] ?>--短信列表</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
    <script type="text/javascript" src="js/member_message_detail.js"></script>
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>

    <div id="member">
        <?php
            require ROOT_PATH.'includes/member.inc.php';
        ?>
        <div id="member_main">
            <h2>短信详情</h2>
            <dl>
                <dd>发 信 人：<?php echo $html['fromuser']?></dd>
                <dd>内　　容：<strong><?php echo $html['content']?></strong></dd>
                <dd>发信时间：<?php echo $html['date']?></dd>
                <dd class="button"><input type="button"  value="返回列表" id="return" /> <input type="button" id="delete" name="<?php echo $html['id']?>" value="删除短信" /></dd>
            </dl>
        </div>
    </div>
    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>
