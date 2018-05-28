<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/27
     * Time: 9:35
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','blog');
    require dirname(__FILE__).'/includes/common.inc.php';

    page("SELECT COUNT(tg_id) as NUM  FROM tg_user ",10);


    $result=query("SELECT 
                                tg_id,tg_username,tg_sex,tg_face
                        FROM
                                tg_user
                        ORDER BY
                                tg_reg_time DESC
                        LIMIT 
                                $pagenum,$pagesize                         
                                  
                  ");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统--博友</title>
    <?php require ROOT_PATH.'includes/title.inc.php';  ?>
    <script type="text/javascript" src="js/blog.js"></script>
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php';  ?>
    <div id="blog">
        <h2>博友列表</h2>
        <?php
            $html=array();
            while ($rows = fetchArrayList($result)) {
                $html['id'] = $rows['tg_id'];
                $html['username'] = $rows['tg_username'];
                $html['face'] = $rows['tg_face'];
                $html['sex'] = $rows['tg_sex'];


        ?>
        <dl>
            <dd class="user"><?php echo $html['username']?>(<?php echo $html['sex']?>)</dd>
            <dt><img src="<?php echo $html['face']?>" alt="<?php echo $html['username'] ?> " /></dt>
            <dd class="message"><a href="javascript:;" name="message" title="<?php echo $html['id']?>">发消息</a></dd>
            <dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $html['id']?>">加为好友</a></dd>
            <dd class="guest">写留言</dd>
            <dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $html['id']?>">给他送花</a></dd>
        </dl>
        <?php  }
                    //page
                    paging(1);
        ?>
    </div>
    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>
