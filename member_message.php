<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/27
     * Time: 15:21
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','member_message');
    require dirname(__FILE__).'/includes/common.inc.php';
    //delete
    if (@$_GET['action'] == 'delete' && isset($_POST['ids'])) {
        include ROOT_PATH.'includes/check_func.php';
        $clean = array();
        $clean['ids'] = mysqlString(implode(',',$_POST['ids']));
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
            query("DELETE FROM 
												tg_message 
								  WHERE 
												tg_id 
											IN 
												({$clean['ids']})"
            );

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
            alertBack('非法登录');
        }
    }


    //page
    page("SELECT COUNT(tg_id) as NUM  FROM tg_message WHERE tg_touser='{$_COOKIE['username']}' ",10);
    $result=query("SELECT
                                tg_id,tg_state,tg_fromuser,tg_content,tg_date
                        FROM
                                tg_message
                        WHERE
                                tg_touser='{$_COOKIE['username']}'      
                        ORDER BY
                                tg_date DESC 
                        LIMIT
                                $pagenum,$pagesize

                  ");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统--短信列表</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
    <script type="text/javascript" src="js/member_message.js"></script>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php'; ?>
<div id="member">
    <?php require ROOT_PATH.'includes/member.inc.php'; ?>
    <div id="member_main">
        <h2>短信管理中心</h2>
        <form method="post" action="?action=delete">
            <table cellspacing="1">
                <tr><th>发信人</th><th>短信内容</th><th>时间</th><th>状态</th><th>操作</th></tr>
                <?php
                    $html = array();
                    while (!!$rows = fetchArrayList($result)) {
                        $html['id'] = $rows['tg_id'];
                        $html['fromuser'] = $rows['tg_fromuser'];
                        $html['content'] = $rows['tg_content'];
                        $html['date'] = $rows['tg_date'];
                        $html = Html($html);
                        if (empty($rows['tg_state'])) {
                            $html['state'] = '<img src="images/read.gif" alt="未读" title="未读" />';
                            $html['content_html'] = '<strong>'.Title($html['content']).'</strong>';
                        } else {
                            $html['state'] = '<img src="images/noread.gif" alt="已读 title="已读" />';
                            $html['content_html'] = Title($html['content']);
                        }

                        ?>
                        <tr><td><?php echo $html['fromuser']?></td><td><a href="member_message_detail.php?id=<?php echo $html['id']?>" title="<?php echo $html['content']?>"><?php echo $html['content_html']?></a></td><td><?php echo $html['date']?></td><td><?php echo $html['state']?></td><td><input name="ids[]" value="<?php echo $html['id']?>" type="checkbox" /></td></tr>
                        <?php
                    }
                  // _free_result($result);
                ?>
                <tr><td colspan="5"><label for="all">全选 <input type="checkbox" name="chkall" id="all" /></label> <input type="submit" value="批删除" /></td></tr>
            </table>
        </form>
        <?php paging(2);?>
    </div>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>
