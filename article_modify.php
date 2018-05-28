<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/28
     * Time: 9:56
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','post');
    require dirname(__FILE__).'/includes/common.inc.php';
    if (!isset($_COOKIE['username'])) {
        alertLocation('发帖前，必须登录','login.php');
    }
    //update
    if (@$_GET['action'] == 'modify') {
        include ROOT_PATH.'includes/check_func.php';
        checkCode($_POST['code'],$_SESSION['code']);
        if ($rows = fetchArray("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
            checkUniqid($rows['tg_uniqid'],$_COOKIE['uniqid']);
            //开始修改
            $clean = array();
            $clean['id'] = $_POST['id'];
            $clean['type'] = $_POST['type'];
            $clean['title'] = checkPostTitle($_POST['title'],2,40);
            $clean['content'] = checkPostContent($_POST['content'],10);
            $clean =  mysqlString($clean);

            //执行SQL
            query("UPDATE tg_article SET 
																tg_type='{$clean['type']}',
																tg_title='{$clean['title']}',
																tg_content='{$clean['content']}',
																tg_last_modify_date=NOW()
													WHERE
																tg_id='{$clean['id']}'
		");
            if (affectedRow() == 1) {
                mysqlClose();
                //_session_destroy();
                alertLocation('帖子修改成功！','article.php?id='.$clean['id']);
            } else {
                mysqlClose();
                //_session_destroy();
                alertBack('帖子修改失败！');
            }
        } else {
            alertBack('非法登录！');
        }
    }


    if (isset($_GET['id'])) {
        if (!!$rows =@fetchArray("SELECT 
																	tg_username,
																	tg_title,
																	tg_type,
																	tg_content
													  FROM 
																	tg_article 
													WHERE
																	tg_reid=0
															AND
																	tg_id='{$_GET['id']}'")) {
            $html = array();
            $yang=array();
            $html['id'] = $_GET['id'];
            $html['username'] = $rows['tg_username'];
            $html['title'] = $rows['tg_title'];
            $html['type'] = $rows['tg_type'];
            $yang['content'] = $rows['tg_content'];
            $html = Html($html);

            //判断权限
            if (@$_COOKIE['username'] != $html['username']) {
                alertBack('你没有权限修改！');
            }

        } else {
            alertBack('不存在此帖子！');
        }
    } else {
        alertBack('非法操作！');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>发表帖子</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
    <script type="text/javascript" src="js/post.js"></script>
    <script type="text/javascript" src="js/modernizr.min.js"></script>
    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="ueditor/lang/zh-cn/zh-cn.js"></script>

</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php'; ?>
<div id="post">
    <h2>修改帖子</h2>
    <form method="post" name="post" action="?action=modify">
        <input type="hidden" value="<?php echo $html['id']?>" name="id" />
        <dl>
            <dt>请认真修改以下内容</dt>
            <dd>
                类　　型：
                <?php
                    foreach (range(1,16) as $num) {
                        if ($num == $html['type']) {
                            echo '<label for="type'.$num.'"><input type="radio" id="type'.$num.'" name="type" value="'.$num.'" checked="checked" /> ';
                        } else {
                            echo '<label for="type'.$num.'"><input type="radio" id="type'.$num.'" name="type" value="'.$num.'" /> ';
                        }
                        echo ' <img src="images/icon'.$num.'.gif" alt="类型" /></label>';
                        if ($num == 8) {
                            echo '<br />　　　 　　';
                        }
                    }
                ?>
            </dd>
            <dd>标　　题：<input type="text" name="title" value="<?php echo $html['title']?>" class="text" /> (*必填，2-40位)</dd>
            <dd>
                <textarea name="content" class="common-textarea" id="content" cols="30" style="width: 98%; margin-left: -220px " rows="10"><?php echo $yang['content']?></textarea>
            </dd>
            <dd>验 证 码：<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" onclick="this.src='code.php?tm'+Math.random()" /> <input type="submit" class="submit" value="修改帖子" /></dd>
        </dl>
    </form>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>
<script type="text/javascript">
    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    UE.getEditor('content',{initialFrameWidth:900,initialFrameHeight:400,});
    $(".btype").hide();
    $(".btype").eq(0).show();
    $("#atype input").click(function(){
        var i=$(this).index();
        $(".btype").hide();
        $(".btype").eq(i).show();
    });

</script>