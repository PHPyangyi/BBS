<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/27
     * Time: 20:59
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','member_friend');
    require dirname(__FILE__).'/includes/common.inc.php';
    if (!isset($_COOKIE['username'])) {
        alertBack('请先登录！');
    }

    if (@$_GET['action'] == 'check' && isset($_GET['id'])) {
        include ROOT_PATH.'includes/check_func.php';
        if (!!$rows = fetchArray("SELECT 
                                                                    tg_uniqid 
                                                        FROM 
                                                                    tg_user 
                                                     WHERE 
                                                                    tg_username='{$_COOKIE['username']}' 
                                                         LIMIT 
                                                                    1"
        )) {
            checkUniqid($rows['tg_uniqid'],$_COOKIE['uniqid']);
            query("UPDATE tg_friend SET tg_state=1 WHERE tg_id='{$_GET['id']}'");
            if (affectedRow() == 1) {
                mysqlClose();
                alertLocation('好友验证成功','member_friend.php');
            } else {
                mysqlClose();
                alertBack('好友验证失败');
            }
        } else{
            alertBack('非法登录！');
        }
    }
    //
    if (@$_GET['action'] == 'delete' && isset($_POST['ids'])) {
        $clean = array();
        $clean['ids'] = mysqlString(implode(',',$_POST['ids']));
        //危险操作，为了防止cookies伪造，还要比对一下唯一标识符uniqid()
        if (!!$rows = fetchArray("SELECT 
																tg_uniqid 
													FROM 
																tg_user 
												 WHERE 
																tg_username='{$_COOKIE['username']}' 
													 LIMIT 
																1"
        )) {
            include ROOT_PATH.'includes/check_func.php';
            checkUniqid($rows['tg_uniqid'],$_COOKIE['uniqid']);
            query("DELETE FROM 
												tg_friend 
								  WHERE 
												tg_id 
											IN 
												({$clean['ids']})"
            );
            if (affectedRow()) {
                mysqlClose();
                alertLocation('好友删除成功','member_friend.php');
            } else {
                mysqlClose();
                alertBack('好友删除失败');
            }
        } else {
            alertBack('非法登录');
        }
    }

    $result = query("SELECT 
                                tg_id,tg_state,tg_touser,tg_fromuser,tg_content,tg_date 
                           FROM
                                tg_friend
                           WHERE 
                                tg_touser='{$_COOKIE['username']}'
                           OR
                                tg_fromuser='{$_COOKIE['username']}'
                           ORDER BY 
                                 tg_date DESC       
                    ");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $system['webname'] ?>--好友列表</title>
    <?php
        require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/member_message.js"></script>
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>
    <div id="member">
        <?php
            require ROOT_PATH.'includes/member.inc.php';
        ?>
        <div id="member_main">
            <h2>好友设置中心</h2>
            <form method="post" action="?action=delete">
                <table cellspacing="1">
                    <tr><th>好友</th><th>请求内容</th><th>时间</th><th>状态</th><th>操作</th></tr>
                    <?php
                        $_html = array();
                        while (!!$rows = fetchArrayList($result)) {
                            $html['id'] = $rows['tg_id'];
                            $html['touser'] = $rows['tg_touser'];
                            $html['fromuser'] = $rows['tg_fromuser'];
                            $html['content'] = $rows['tg_content'];
                            $html['state'] = $rows['tg_state'];
                            $html['date'] = $rows['tg_date'];
                            $html = Html($html);
                            if ($html['touser'] == $_COOKIE['username']) {
                                $html['friend'] = $html['fromuser'];
                                if (empty($html['state'])) {
                                    $html['state_html'] = '<a href="?action=check&id='.$html['id'].'" style="color:red;">你未验证</a>';
                                } else {
                                    $html['state_html'] = '<span style="color:green;">通过</span>';
                                }
                            } elseif ($html['fromuser'] == $_COOKIE['username']) {
                                $html['friend'] = $html['touser'];
                                if (empty($html['state'])) {
                                    $html['state_html'] = '<span style="color:blue;">对方未验证</a>';
                                } else {
                                    $html['state_html'] = '<span style="color:green;">通过</span>';
                                }
                            }

                            ?>
                            <tr><td><?php echo $html['friend']?></td><td title="<?php echo $html['content']?>"><?php echo Title($html['content'])?></td><td><?php echo $html['date']?></td><td><?php echo $html['state_html']?></td><td><input name="ids[]" value="<?php echo $html['id']?>" type="checkbox" /></td></tr>
                            <?php
                        }

                    ?>
                    <tr><td colspan="5"><label for="all">全选 <input type="checkbox" name="chkall" id="all" /></label> <input type="submit" value="批删除" /></td></tr>
                </table>
            </form>

        </div>
    </div>
    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>

