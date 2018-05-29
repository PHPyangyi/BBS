<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/29
     * Time: 12:41
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','manage_set');
    require dirname(__FILE__).'/includes/common.inc.php';
    //update
    if (@$_GET['action'] == 'set') {
        include ROOT_PATH.'includes/check_func.php';
        if ($rows = fetchArray("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
            checkUniqid($rows['tg_uniqid'],$_COOKIE['uniqid']);
            $clean = array();
            $clean['webname'] = $_POST['webname'];
            $clean['article'] = $_POST['article'];
            $clean['blog'] = $_POST['blog'];
            $clean['photo'] = $_POST['photo'];
            $clean['skin'] = $_POST['skin'];
            $clean['code'] = $_POST['code'];
            $clean['register'] = $_POST['register'];
            $clean['string'] = $_POST['string'];
            $clean = mysqlString($clean);

            //写入数据库
            query("UPDATE tg_system SET 
																tg_webname='{$clean['webname']}',
																tg_article='{$clean['article']}',
																tg_blog='{$clean['blog']}',
																tg_photo='{$clean['photo']}',
																tg_skin='{$clean['skin']}',
																tg_code='{$clean['code']}',
																tg_register='{$clean['register']}',
																tg_string='{$clean['string']}'
												WHERE
																tg_id=1
													LIMIT 
																1
		");
            if (affectedRow() == 1) {
                mysqlClose();
                //_session_destroy();
                alertLocation('恭喜你，修改成功！','manage_set.php');
            } else {
                mysqlClose();
                //_session_destroy();
                alertLocation('很遗憾，没有任何数据被修改！','manage_set.php');
            }
        } else {
            alertBack('异常！');
        }
    }
    //select
    if ($rows = fetchArray("SELECT * FROM tg_system WHERE  tg_id=1  LIMIT 1")) {
        $html = array();
        $html['webname'] = $rows['tg_webname'];
        $html['article'] = $rows['tg_article'];
        $html['blog'] = $rows['tg_blog'];
        $html['photo'] = $rows['tg_photo'];
        $html['skin'] = $rows['tg_skin'];
        $html['string'] = $rows['tg_string'];
        $html['post'] = $rows['tg_post'];
        $html['re'] = $rows['tg_re'];
        $html['code'] = $rows['tg_code'];
        $html['register'] = $rows['tg_register'];
        $html = Html($html);

        //文章
        if ($html['article'] == 10) {
            $html['article_html'] = '<select name="article"><option value="10" selected="selected">每页10篇</option><option value="15">每页15篇</option></select>';
        } elseif ($html['article'] == 15) {
            $html['article_html'] = '<select name="article"><option value="10">每页10篇</option><option value="15" selected="selected">每页15篇</option></select>';
        }

        //博友
        if ($html['blog'] == 15) {
            $html['blog_html'] = '<select name="blog"><option value="15" selected="selected">每页15人</option><option value="20">每页20人</option></select>';
        } elseif ($_html['blog'] == 20) {
            $html['blog_html'] = '<select name="blog"><option value="20">每页15人</option><option value="20" selected="selected">每页20人</option></select>';
        }

        //相册
        if ($html['photo'] == 8) {
            $html['photo_html'] = '<select name="photo"><option value="8" selected="selected">每页8张</option><option value="12">每页12张</option></select>';
        } elseif ($html['photo'] == 12) {
            $html['photo_html'] = '<select name="photo"><option value="8">每页8张</option><option value="12" selected="selected">每页12张</option></select>';
        }

        //皮肤
        if ($html['skin'] == 1) {
            $html['skin_html'] = '<select name="skin"><option value="1" selected="selected">一号皮肤</option><option value="2">二号皮肤</option><option value="3">三号皮肤</option></select>';
        } elseif ($html['skin'] == 2) {
            $html['skin_html'] = '<select name="skin"><option value="1">一号皮肤</option><option value="2" selected="selected">二号皮肤</option><option value="3">三号皮肤</option></select>';
        } elseif ($_html['skin'] == 3) {
            $html['skin_html'] = '<select name="skin"><option value="1">一号皮肤</option><option value="2">二号皮肤</option><option value="3" selected="selected">三号皮肤</option></select>';
        }


        //验证码
        if ($html['code'] == 1) {
            $html['code_html'] =  '<input type="radio" name="code" value="1" checked="checked" /> 启用 <input type="radio" name="code" value="0" /> 禁用';
        } else {
            $html['code_html'] =  '<input type="radio" name="code" value="1" /> 启用 <input type="radio" name="code" value="0" checked="checked"  /> 禁用';
        }

        //放开注册
        if ($html['register'] == 1) {
            $html['register_html'] =  '<input type="radio" name="register" value="1" checked="checked" /> 启用 <input type="radio" name="register" value="0" /> 禁用';
        } else {
            $html['register_html'] =  '<input type="radio" name="register" value="1" /> 启用 <input type="radio" name="register" value="0" checked="checked" /> 禁用';
        }
    } else {
        alertBack('数据错误');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统--后台管理中心</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>
    <div id="member">
        <?php require ROOT_PATH.'includes/manage.inc.php'; ?>
        <div id="member_main">
            <h2>后台管理中心</h2>
            <form method="post" action="?action=set">
            <dl>
                <dd>·网 站 名 称：<input type="text" name="webname" class="text" value="<?php echo $html['webname']?>" /></dd>
                <dd>·文章每页列表数：<?php echo $html['article_html'];?></dd>
                <dd>·博客每页列表数：<?php echo $html['blog_html'];?></dd>
                <dd>·相册每页列表数：<?php echo $html['photo_html'];?></dd>
                <dd>·站点 默认 皮肤：<?php echo $html['skin_html'];?></dd>
                <dd>·非法 字符 过滤：<input type="text" name="string" class="text" value="<?php echo $html['string'];?>" /> (*请用|线隔开)</dd>
                <dd>·是否 启用 验证：<?php echo $html['code_html'];?></dd>
                <dd>·是否 开放 注册：<?php echo $html['register_html'];?></dd>
                <dd><input type="submit" value="修改系统设置" class="submit" /></dd>
            </dl>
            </form>
        </div>
    </div>

    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>

