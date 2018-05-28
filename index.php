<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/26
     * Time: 12:39
     */
    define('IN_TG',true);
    define('SCRIPT','index');
    require  dirname(__FILE__).'/includes/common.inc.php';

    //帖子列表
    page("SELECT COUNT(tg_id) as NUM  FROM tg_article  ",10);
    $result=query("SELECT 
                                *
                        FROM
                                tg_article
                        WHERE  
                                tg_reid='0'      
                        ORDER BY
                                tg_date DESC        
                        LIMIT 
                                $pagenum,$pagesize                         
                                  
                  ");

    //处理新晋会员
    //可采用xml
    $vip=fetchArray("SELECT * FROM tg_user ORDER BY  tg_reg_time DESC  LIMIT 1 ");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统--首页</title>
    <?php require ROOT_PATH.'/includes/title.inc.php' ?>
    <script type="text/javascript" src="js/blog.js"></script>
</head>
<body>

    <?php require  ROOT_PATH.'/includes/header.inc.php'?>

    <div id="list">
        <h2>帖子列表</h2>
        <a href="post.php" class="post">发表帖子</a>
        <ul class="article">
            <?php
                $htmllist = array();
                while (!!$rows = fetchArrayList($result)) {
                    $htmllist['id'] = $rows['tg_id'];
                    $htmllist['type'] = $rows['tg_type'];
                    $htmllist['readcount'] = $rows['tg_readcount'];
                    $htmllist['commendcount'] = $rows['tg_commendcount'];
                    $htmllist['title'] = $rows['tg_title'];
                    $htmllist = Html($htmllist);
                    echo '<li class="icon'.$htmllist['type'].'"><em>阅读数(<strong>'.$htmllist['readcount'].'</strong>) 评论数(<strong>'.$htmllist['commendcount'].'</strong>)</em> <a href="article.php?id='.$htmllist['id'].'">'.Title($htmllist['title'],20).'</a></li>';
                }
               // _free_result($_result);
            ?>
        </ul>
        <?php paging(2);?>
    </div>

    <div id="user">
        <h2>新进会员</h2>
        <dl>
            <dd class="user"><?php echo $vip['tg_username']?>(<?php echo $vip['tg_sex']?>)</dd>
            <dt><img src="<?php echo $vip['tg_face']?>" alt="<?php echo $html['tg_username']?>" /></dt>
            <dd class="message"><a href="javascript:;" name="message" title="<?php echo $vip['tg_id']?>">发消息</a></dd>
            <dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $vip['tg_id']?>">加为好友</a></dd>
            <dd class="guest">写留言</dd>
            <dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $vip['tg_id']?>">给他送花</a></dd>
            <dd class="email">邮件：<a href="mailto:<?php echo $vip['tg_email']?>"><?php echo $vip['tg_email']?></a></dd>
            <dd class="url">网址：<a href="<?php echo $vip['tg_url']?>" target="_blank"><?php echo $vip['tg_url']?></a></dd>
        </dl>
    </div>

    <div id="pics">
        <h2>最新图片</h2>
    </div>

    <?php require ROOT_PATH.'/includes/footer.inc.php'?>



</body>
</html>