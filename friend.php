<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/27
     * Time: 14:44
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','friend');
    require dirname(__FILE__).'/includes/common.inc.php';

    if (!$_COOKIE['username']) {
        alertClose('请登录');
    }

    //添加好友
    if (@$_GET['action'] == 'add') {
        include ROOT_PATH.'includes/check_func.php';
        //checkCode($_POST['code'],$_SESSION['code']);
        if ($rows = fetchArray("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
            checkUniqid($rows['tg_uniqid'],$_COOKIE['uniqid']);
            $clean = array();
            $clean['touser'] = $_POST['touser'];
            $clean['fromuser'] = $_COOKIE['username'];
            $clean['content'] = checkMessageContent($_POST['content']);
            $clean = mysqlString($clean);
            if ($clean['touser'] == $clean['fromuser']) {
                alertClose('请不要添加自己！');
            }
            //数据库验证好友是否已经添加
            if (!!$_rows = fetchArray("SELECT 
																	tg_id 
													    FROM 
													  				tg_friend
													    WHERE
																	(tg_touser='{$clean['touser']}' AND tg_fromuser='{$clean['fromuser']}')
														OR
																	(tg_touser='{$clean['fromuser']}' AND tg_fromuser='{$clean['touser']}')
														LIMIT        1
	")) {alertClose('你们已经是好友了！或者是未验证的好友！无需添加！');} else
	    {
            query("INSERT INTO tg_friend (
																tg_touser,
																tg_fromuser,
																tg_content,
																tg_date
															 )
											 VALUES (
											 					'{$clean['touser']}',
											 					'{$clean['fromuser']}',
											 					'{$clean['content']}',
											 					NOW()
											 				)
		");
                if (affectedRow() == 1) {
                    mysqlClose();
                    //session_unset();
                    //session_destroy();
                    alertClose('好友添加成功！请等待验证！');
                } else {
                    mysqlClose();
                    //session_unset();
                    //session_destroy();
                    alertClose('好友添加失败！');
                }
            }

        }


    }



    if ($_GET['id']) {
        if ($rows = fetchArray("SELECT tg_username FROM tg_user WHERE tg_id='{$_GET['id']}' LIMIT 1")) {
            $html=array();
            $html['touser'] = $rows['tg_username'];
            $html = Html($html);
        } else {
            alertClose('不存在此用户！');
        }
    } else {
        alertClose('非法操作');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统--添加好友</title>
    <?php  require ROOT_PATH.'includes/title.inc.php'; ?>
    <script type="text/javascript" src="js/message.js"></script>
</head>
<body>
<div id="message">
    <h3>添加好友</h3>
    <form method="post" action="?action=add">
        <input type="hidden" name="touser" value="<?php echo $html['touser']?>" />
        <dl>
            <dd><input type="text" readonly="readonly" value="TO:<?php echo $html['touser']?>" class="text" /></dd>
            <dd><textarea name="content">我非常想和你交朋友！</textarea></dd>
            <dd>验 证 码：<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" onclick="this.src='code.php?tm='+Math.random() " /> <input type="submit" class="submit" value="发送信息" /></dd>
        </dl>
    </form>
</div>
</body>
</html>
