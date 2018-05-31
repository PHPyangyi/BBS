<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/31
     * Time: 11:05
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','photo_detail');
    require dirname(__FILE__).'/includes/common.inc.php';

    if (isset($_GET['id'])) {
        if (!!$_rows = fetchArray("SELECT 
																	tg_id,
																	tg_name,
																	tg_url,
																	tg_username,
																	tg_readcount,
																	tg_commendcount,
																	tg_content,
																	tg_date
														FROM
																	tg_photo
														WHERE
																	tg_id='{$_GET['id']}'
														LIMIT
																	1
	")) {

            //累积阅读量
            query("UPDATE tg_photo SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'");

            $_html = array();
            $_html['id'] = $_rows['tg_id'];
            $_html['name'] = $_rows['tg_name'];
            $_html['url'] = $_rows['tg_url'];
            $_html['username'] = $_rows['tg_username'];
            $_html['readcount'] = $_rows['tg_readcount'];
            $_html['commendcount'] = $_rows['tg_commendcount'];
            $_html['date'] = $_rows['tg_date'];
            $_html['content'] = $_rows['tg_content'];
            $_html = Html($_html);
        } else {
            alertBack('不存在此图片！');
        }
    } else {
        alertBack('非法操作！');
    }

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>相片详情</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
    <script type="text/javascript" src="js/modernizr.min.js"></script>
    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php'; ?>

<div id="photo">
    <h2>图片详情</h2>
    <dl class="detail">
        <dd class="name"><?php echo $_html['name']?></dd>
        <dt><img src="<?php echo $_html['url']?>" /></dt>
        <dd>浏览量(<strong><?php echo $_html['readcount'];?></strong>) 评论量(<strong><?php echo $_html['commendcount'];?></strong>) 发表于：<?php echo $_html['date']?> 上传者：<?php echo $_html['username']?></dd>
        <dd>简介：<?php echo $_html['content']?></dd>
    </dl>

    <?php if (isset($_COOKIE['username'])) {?>
        <p class="line"></p>
        <form method="post" action="?action=rephoto">
            <input type="hidden" name="reid" value="<?php echo $_html['reid']?>" />
            <input type="hidden" name="type" value="<?php echo $_html['type']?>" />
            <dl class="rephoto">
                <dd>
                    <textarea name="content" class="common-textarea" id="content" cols="30" style="width: 98%; margin-left: -220px " rows="10"></textarea>
                </dd>

                <dd>
                    验 证 码：
                    <input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" />
                    <input type="submit" class="submit" value="发表帖子" /></dd>
            </dl>
        </form>
    <?php }?>

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