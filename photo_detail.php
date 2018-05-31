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


    if (@$_GET['action'] == 'rephoto') {
        include ROOT_PATH.'includes/check_func.php';
        if (!empty($system['code'])) {
            checkCode($_POST['code'], $_SESSION['code']);
        }
        if ($rows = fetchArray("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
            checkUniqid($rows['tg_uniqid'],$_COOKIE['uniqid']);
            //接受数据
            $clean = array();
            $clean['sid'] = $_POST['sid'];
           // $_clean['title'] = $_POST['title'];
            $clean['content'] = $_POST['content'];
            $clean['username'] = $_COOKIE['username'];
            $clean = mysqlString($clean);

            //写入数据库
            query("INSERT INTO tg_photo_commend (
																tg_sid,
																tg_username,
																tg_title,
																tg_content,
																tg_date
															)
											 VALUES (
											 					'{$clean['sid']}',
											 					'{$clean['username']}',
											 					'{$clean['title']}',
											 					'{$clean['content']}',
											 					NOW()
											 				)"
            );
            if (affectedRow() == 1) {
                query("UPDATE tg_photo SET tg_commendcount=tg_commendcount+1 WHERE tg_id='{$clean['sid']}'");
                mysqlClose();
                alertLocation('评论成功！','photo_detail.php?id='.$clean['sid']);
            } else {
                mysqlClose();
                alertBack('评论失败！');
            }
        } else {
            alertBack('非法登录！');
        }
    }


    if (isset($_GET['id'])) {
        if (!!$rows = @fetchArray("SELECT 
																	*
														FROM
																	tg_photo
														WHERE
																	tg_id='{$_GET['id']}'
														LIMIT
																	1
	")) {
            if (!isset($_SESSION['admin'])) {
                if (!!$dirs = fetchArray("SELECT tg_type,tg_id,tg_name FROM tg_dir WHERE tg_id='{$rows['tg_sid']}'")) {
                    if (!empty($dirs['tg_type']) && $_COOKIE['photo'.$dirs['tg_id']] != $dirs['tg_name']) {
                        alertBack('非法操作！');
                    }
                } else {
                    alertBack('相册目录表出错了！');
                }
            }

            //累积阅读量
            query("UPDATE tg_photo SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'");

            $html = array();
            $html['id'] = $rows['tg_id'];
            $html['name'] = $rows['tg_name'];
            $html['url'] = $rows['tg_url'];
            $html['sid'] = $rows['tg_sid'];
            $html['username'] = $rows['tg_username'];
            $html['readcount'] = $rows['tg_readcount'];
            $html['commendcount'] = $rows['tg_commendcount'];
            $html['date'] = $rows['tg_date'];
            $html['content'] = $rows['tg_content'];
            $html = Html($html);

            global $_id;
            $_id = 'id='.$html['id'].'&';
            page("SELECT COUNT(tg_id) AS NUM FROM tg_photo_commend WHERE tg_sid='{$html['id']}'",10);
            $result = query("SELECT 
											*
								FROM 
											tg_photo_commend 
								WHERE
											tg_sid='{$html['id']}'
						ORDER BY 
											tg_date ASC 
								 LIMIT 
											$pagenum,$pagesize
		");


            //上一页，取得比自己大的ID中，最小的那个即可。
            $html['preid'] = fetchArray("SELECT 
																			min(tg_id) 
																	AS 
																			id 
																FROM 
																			tg_photo 
															WHERE 
																			tg_sid='{$html['sid']}' 
																	AND 
																			tg_id>'{$html['id']}'
																LIMIT
																			1
		");

            if (!empty($html['preid']['id'])) {
                $html['pre'] = '<a href="photo_detail.php?id='.$html['preid']['id'].'#pre">上一页</a>';
            } else {
                $html['pre'] = '<span>到头了</span>';
            }

            //下一页，取得比自己小的ID中，最大的那个即可。
            $html['nextid'] = fetchArray("SELECT 
																			max(tg_id) 
																	AS 
																			id 
																FROM 
																			tg_photo 
															WHERE 
																			tg_sid='{$html['sid']}' 
																	AND 
																			tg_id<'{$html['id']}'
																LIMIT
																			1
		");

            if (!empty($html['nextid']['id'])) {
                $html['next'] = '<a href="photo_detail.php?id='.$html['nextid']['id'].'#next">下一页</a>';
            } else {
                $html['next'] = '<span>到底了</span>';
            }



        } else {
            alertBack('不存在此图片！');
        }
    } else {
        alertBack('非法操作！');
    }


    //显示评论


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>相片详情</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
    <script type="text/javascript" src="js/blog.js"></script>
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
        <dd class="name"><?php echo $html['name']?></dd>
        <dt><?php echo $html['pre']?><img src="<?php echo $html['url']?>" /><?php echo $html['next']?></dt>
        <dd>[<a href="photo_show.php?id=<?php echo $html['sid']?>">返回列表</a>]</dd>
        <dd>浏览量(<strong><?php echo $html['readcount'];?></strong>) 评论量(<strong><?php echo $html['commendcount'];?></strong>) 发表于：<?php echo $html['date']?> 上传者：<?php echo $html['username']?></dd>
        <dd>简介：<?php echo $html['content']?></dd>
    </dl>



    <?php
        $_i = 1;
        $yang=array();
        while (!!$rows = fetchArrayList($result)) {
        $html['username'] = $rows['tg_username'];
        $html['retitle'] = $rows['tg_title'];
        $yang['content'] = $rows['tg_content'];
        $html['date'] = $rows['tg_date'];
        $html = Html($html);

        if (!!$rows = fetchArray("SELECT 
																			tg_id,
																			tg_sex,
																			tg_face,
																			tg_email,
																			tg_url,
																			tg_switch,
																			tg_autograph
															  FROM 
															  				tg_user 
															WHERE 
																			tg_username='{$html['username']}'")) {
            //提取用户信息
            $html['userid'] = $rows['tg_id'];
            $html['sex'] = $rows['tg_sex'];
            $html['face'] = $rows['tg_face'];
            $html['email'] = $rows['tg_email'];
            $html['url'] = $rows['tg_url'];
            $html['switch'] = $rows['tg_switch'];
            $html['autograph'] = $rows['tg_autograph'];
            $html = Html($html);

        } else {
            //这个用户可能已经被删除了
        }


    ?>

    <p class="line"></p>


            <div class="re">
                <dl>
                    <dd class="user"><?php echo $html['username']?>(<?php echo $html['sex']?>)</dd>
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
                        <span><?php echo $_i + (($page-1) * $pagesize);?>#</span><?php echo $html['username']?> | 发表于：<?php echo $html['date']?>
                    </div>
                    <div class="detail">
                        <?php echo $yang['content']?>
                        <?php
                            if ($html['switch'] == 1) {
                                echo '<p class="autograph">'. $html['autograph'].'</p>';
                            }
                        ?>
                    </div>
                </div>
            </div>

            <?php
            $_i ++;
        }
        paging(1);
    ?>

    <?php if (isset($_COOKIE['username'])) {?>
        <p class="line"></p>
        <form method="post" action="?id=<?php echo  $html['id'] ?>&action=rephoto">
            <input type="hidden" name="sid" value="<?php echo $html['id']?>" />
            <dl class="rephoto">
                <dd>
                    <textarea name="content" class="common-textarea" id="content" cols="30" style="width: 98%; margin-left: -220px " rows="10"></textarea>
                </dd>

                <dd>

                    <?php if (!empty($system['code'])) {?>
                <dd>验 证 码：<input type="text" name="code" class="text code"  /> <img src="code.php" id="code" onclick="this.src='code.php?tm='+Math.random() " /></dd>
                <?php }?>
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