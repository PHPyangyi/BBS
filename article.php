<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/28
     * Time: 11:21
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','article');
    require dirname(__FILE__).'/includes/common.inc.php';
    $i=1;
    //回复
    if (@$_GET['action'] == 'rearticle') {
        include ROOT_PATH.'includes/check_func.php';
        checkCode($_POST['code'],$_SESSION['code']);
        if ($rows = fetchArray("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
            checkUniqid($rows['tg_uniqid'],$_COOKIE['uniqid']);
            $clean = array();
            $clean['reid'] = $_POST['reid'];
            $clean['type'] = $_POST['type'];
            $clean['title'] = $_POST['title'];
            $clean['content'] = $_POST['content'];
            $clean['username'] = $_COOKIE['username'];
            $clean = mysqlString($clean);
            query("INSERT INTO tg_article (
																	tg_reid,
																	tg_username,
																	tg_title,
																	tg_type,
																	tg_content,
																	tg_date
																)
												 VALUES (
												 					'{$clean['reid']}',
												 					'{$clean['username']}',
												 					'{$clean['title']}',
												 					'{$clean['type']}',
												 					'{$clean['content']}',
												 					NOW()
												 				)"
            );
            if (affectedRow() == 1) {
                //$clean['id']=@mysql_insert_id();
                mysqlClose();
                //session_unset();
                //session_destroy();
                alertLocation('帖子发表成功！','article.php?id='.$clean['reid']);

            } else {
                mysqlClose();
                //session_unset();
                //session_destroy();
                alertBack('回帖发表失败！');
            }
        }

    }

    //
    if (isset($_GET)) {
        if ($rows = fetchArray("SELECT * FROM  tg_article WHERE  tg_id ='{$_GET['id']}' LIMIT 1 ")) {
            query("UPDATE tg_article SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'");
            $content=array();
            $html = array();
            $html['username'] = $rows['tg_username'];
            $html['reid'] = $rows['tg_id'];
            $html['title'] = $rows['tg_title'];
            $html['type'] = $rows['tg_type'];
            $content['content'] = $rows['tg_content'];
            $html['readcount'] = $rows['tg_readcount'];
            $html['last_modify_date'] = $rows['tg_last_modify_date'];
            $html['commendcount'] = $rows['tg_commendcount'];
            $html['date'] = $rows['tg_date'];
            if ($rowsUser = fetchArray("SELECT * FROM tg_user WHERE tg_username='{$html['username']}' LIMIT  1 ")) {
                $html['userid'] = $rowsUser['tg_id'];
                $html['sex'] = $rowsUser['tg_sex'];
                $html['face'] = $rowsUser['tg_face'];
                $html['email'] = $rowsUser['tg_email'];
                $html['url'] = $rowsUser['tg_url'];
                $html['switch'] = $rowsUser['tg_switch'];
                $html['autograph'] = $rowsUser['tg_autograph'];
                $html = Html($html);

                global $_id;
                $_id = 'id='.$html['reid'].'&';

                if ($html['username'] == @$_COOKIE['username']) {
                    $html['subject_modify'] = '[<a href="article_modify.php?id='.$html['reid'].'">修改</a>]';
                }

                //读取最后修改信息
                if ($html['last_modify_date'] != '0000-00-00 00:00:00') {
                    $html['last_modify_date_string'] = '本贴已由['.$html['username'].']于'.$html['last_modify_date'].'修改过！';
                }
                //个性签名
                //个性签名
                if ($html['switch'] == 1) {
                    $html['autograph_html'] = '<p class="autograph">'.$html['autograph'].'</p>';
                }


                //读取回帖
                page("SELECT COUNT(tg_id) as NUM  FROM tg_article WHERE tg_reid='{$html['reid']}'",10);


                $result=query("SELECT 
                                tg_username,tg_type,tg_title,tg_content,tg_date 
                        FROM
                                tg_article
                        WHERE 
                                 tg_reid='{$html['reid']}'  
                        ORDER BY
                               tg_date ASC 
                        LIMIT 
                                $pagenum,$pagesize                         
                                  
                  ");

            } else {
                alertBack('此用户不存在');
            }
        } else {
           //alertBack('error');
        }
    } else {
        alertBack('非法操作');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统——发表详情</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
    <script type="text/javascript" src="js/modernizr.min.js"></script>
    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="ueditor/lang/zh-cn/zh-cn.js"></script>

</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>
    <div id="article">
        <h2>帖子详情</h2>
        <?php
            if ($page == 1) {
        ?>
        <div id="subject">
            <dl>
                <dd class="user"><?php echo $html['username']?>(<?php echo $html['sex']?>)[楼主]</dd>
                <dt><img src="<?php echo $html['face']?>" alt="<?php echo $html['username']?>" /></dt>
                <dd class="message"><a href="javascript:;" name="message" title="<?php echo $html['userid']?>">发消息</a></dd>
                <dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $html['userid']?>">加为好友</a></dd>
                <dd class="guest">写留言</dd>
                <dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $html['userid']?>">给他送花</a></dd>
                <dd class="email">邮件：<a href="mailto:<?php echo $html['email']?>"><?php echo $html['email']?></a></dd>
                <dd class="url">网址：<a href="<?php echo $html['url']?>" target="_blank"><?php echo $html['url']?></a></dd>
            </dl>
            <div class="content">
                <div class="user">
                    <span><?php echo @$html['subject_modify']?>楼主</span><?php echo $html['username']?> | 发表于：<?php echo $html['date']?>
                </div>
                <h3>主题：<?php echo $html['title']?> <img src="images/icon<?php echo $html['type']?>.gif" alt="icon" /></h3>
                <div class="detail">
                    <?php echo $content['content']?>
                    <?php echo @$html['autograph_html']?>
                </div>
                <div class="read">
                    <p><?php echo $html['last_modify_date_string']?></p>
                    阅读量：(<?php echo $html['readcount']?>) 评论量：(<?php echo $html['commendcount']?>)
                </div>
            </div>
        </div>
            <?php }?>
        <p class="line"></p>
        <?php
            while (!!$_rows = fetchArrayList($result)) {
            $yangyi=array();
            $_html['username'] = $_rows['tg_username'];
            $_html['type'] = $_rows['tg_type'];
            $_html['title'] = $_rows['tg_title'];
            $yangyi['content'] = $_rows['tg_content'];
            $_html['date'] = $_rows['tg_date'];
            $_html = Html($_html);

            if (!!$_rows = fetchArray("SELECT 
																			tg_id,
																			tg_sex,
																			tg_face,
																			tg_email,
																			tg_url 
															  FROM 
															  				tg_user 
															WHERE 
																			tg_username='{$_html['username']}'")) {
                //提取用户信息
                $_html['userid'] = $_rows['tg_id'];
                $_html['sex'] = $_rows['tg_sex'];
                $_html['face'] = $_rows['tg_face'];
                $_html['email'] = $_rows['tg_email'];
                $_html['url'] = $_rows['tg_url'];
                $_html = Html($_html);
            } else {
            }

        ?>
                <div class="re">
                    <dl>
                        <dd class="user"><?php echo $_html['username']?>(<?php echo $_html['sex']?>)</dd>
                        <dt><img src="<?php echo $_html['face']?>" alt="<?php echo $_html['username']?>" /></dt>
                        <dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['userid']?>">发消息</a></dd>
                        <dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['userid']?>">加为好友</a></dd>
                        <dd class="guest">写留言</dd>
                        <dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['userid']?>">给他送花</a></dd>
                        <dd class="email">邮件：<a href="mailto:<?php echo $_html['email']?>"><?php echo $_html['email']?></a></dd>
                        <dd class="url">网址：<a href="<?php echo $_html['url']?>" target="_blank"><?php echo $_html['url']?></a></dd>
                    </dl>
                    <div class="content">
                        <div class="user">
                            <span><?php echo @$i + (($page-1) * $pagesize);?>楼</span><?php echo $_html['username']?> | 发表于：<?php echo $_html['date']?>
                        </div>
                        <h3>回复：<?php echo $_html['title']?> <img src="images/icon<?php echo $_html['type']?>.gif" alt="icon" /></h3>
                        <div class="detail">
                            <?php echo  $yangyi['content']?>
                        </div>
                    </div>
                </div>
                <p class="line"></p>
            <?php
                @$i ++;
            }
            paging(1);
        ?>


        <p class="line"></p>
        <?php if (isset($_COOKIE['username'])) {?>
            <form method="post" action="?id=<?php echo $_GET['id']?> & action=rearticle">
                <input type="hidden" name="reid" value="<?php echo $html['reid']?>" />
                <input type="hidden" name="type" value="<?php echo $html['type']?>" />
                <dl>
                    <dd>标　　题：<input id="yangyi" type="text" name="title" class="text" value="RE:<?php echo $html['title']?>" /> (*必填，2-40位)</dd>
                    <dd>
                        <textarea name="content" class="common-textarea" id="content" cols="30" style="width: 98%; margin-left: -220px " rows="10"></textarea>
                    </dd>
                    <dd>验 证 码：<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" onclick="this.src='code.php?tm='+Math.random() " /> <input type="submit" class="submit" value="发表帖子" /></dd>
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