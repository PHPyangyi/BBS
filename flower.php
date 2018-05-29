<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/27
     * Time: 14:44
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','flower');
    require dirname(__FILE__).'/includes/common.inc.php';
    if (!$_COOKIE['username']) {
        alertClose('请登录');
    }

    if (@$_GET['action'] == 'send') {
        include ROOT_PATH.'includes/check_func.php';
        if (!empty($system['code'])) {
            checkCode($_POST['code'], $_SESSION['code']);
        }
        if ($rows = fetchArray("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
            checkUniqid($rows['tg_uniqid'],$_COOKIE['uniqid']);
            $clean = array();
            $clean['touser'] = $_POST['touser'];
            $clean['fromuser'] = $_COOKIE['username'];
            $clean['flower'] = $_POST['flower'];
            $clean['content'] = checkMessageContent($_POST['content']);
            $clean = mysqlString($clean);
            //send
            query("INSERT INTO tg_flower (
																		tg_touser,
																		tg_fromuser,
																		tg_flower,
																		tg_content,
																		tg_date
																	)
												    	VALUES (
													 					'{$clean['touser']}',
													 					'{$clean['fromuser']}',
													 					'{$clean['flower']}',
													 					'{$clean['content']}',
													 					NOW()
													 				)
		                                        ");
        }
        if (affectedRow() == 1) {
            mysqlClose();
            //session_unset();
            //session_destroy();
            alertClose('短信发送成功');

        } else {
            mysqlClose();
            //session_unset();
            //session_destroy();
            alertClose('短信发送失败');
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
    <title><?php echo $system['webname'] ?>--送花</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
    <script type="text/javascript" src="js/message.js"></script>
</head>
<body>
    <div id="message">
        <h3>送花</h3>
        <form method="post" action="?action=send">
            <input type="hidden" name="touser" value="<?php echo $html['touser']?>" />
            <dl>
                <dd>
                    <input type="text" readonly="readonly" value="TO:<?php echo $html['touser']?>" class="text" />
                    <select name="flower">
                        <?php
                            foreach (range(1,100) as $num) {
                                echo '<option value="'.$num.'"> x'.$num.'朵</option>';
                            }
                        ?>
                    </select>
                </dd>
                <?php if (!empty($system['code'])) {?>
                    <dd>验 证 码：<input type="text" name="code" class="text code"  /> <img src="code.php" id="code" onclick="this.src='code.php?tm='+Math.random() " /></dd>
                <?php }?>
            </dl>
        </form>
    </div>
</body>
</html>
