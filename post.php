<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/28
     * Time: 9:56
     */
    define('IN_TG',true);
    define('SCRIPT','post');
    require dirname(__FILE__).'/includes/common.inc.php';

    if (!isset($_COOKIE['username'])) {
        alertLocation('发帖前，必须登录','login.php');
    }

    if (@$_GET['action'] == 'post') {
        include ROOT_PATH.'includes/check_func.php';
       // checkCode($_POST['code'],$_SESSION['code']);
        if ($rows = fetchArray("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
            checkUniqid($rows['tg_uniqid'],$_COOKIE['uniqid']);
            $clean = array();
            $clean['username'] = $_COOKIE['username'];
            $clean['type'] = $_POST['type'];
            $clean['title'] = checkPostTitle($_POST['title'],2,40);
            $clean['content'] = checkPostContent($_POST['content'],10);
            $clean = mysqlString($clean);
            query("INSERT INTO tg_article (
																tg_username,
																tg_title,
																tg_type,
																tg_content,
																tg_date
															) 
											VALUES (
																'{$clean['username']}',
																'{$clean['title']}',
																'{$clean['type']}',
																'{$clean['content']}',
																NOW()
															)
		                                        ");
        }
        if (affectedRow() == 1) {
            $clean['id']=@mysql_insert_id();
            mysqlClose();
            //session_unset();
            //session_destroy();
            alertLocation('帖子发表成功！','article.php?id='.$clean['id']);

        } else {
            mysqlClose();
            //session_unset();
            //session_destroy();
            alertBack('帖子发表失败！');
        }
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
        <h2>发表帖子</h2>
        <form method="post" name="post" action="?action=post">
            <dl>
                <dt>请认真填写一下内容</dt>
                <dd>
                    类　　型：
                    <?php
                        foreach (range(1,16) as $num) {
                            if ($num == 1) {
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
                <dd>标　　题：<input type="text" name="title" class="text" /> (*必填，2-40位)</dd>

                <dd>

                    <textarea name="content" class="common-textarea" id="content" cols="30" style="width: 98%; margin-left: -220px " rows="10"></textarea>
                </dd>
                <dd>验 证 码：<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" onclick="this.src='code.php?tm'+Math.random()" /> <input type="submit" class="submit" value="发表帖子" /></dd>
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