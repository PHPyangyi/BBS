<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/27
     * Time: 14:02
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','member_modify');
    require dirname(__FILE__).'/includes/common.inc.php';
    //update
    if (@$_GET['action'] == 'modify') {
        include ROOT_PATH.'includes/check_func.php';
        checkCode($_POST['code'],$_SESSION['code']);
        if ($rows = fetchArray("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1  ")) {
            checkUniqid($rows['tg_uniqid'],$_COOKIE['uniqid']);
            $clean = array();
            $clean['password'] = checkMemberModifyPassword($_POST['password'],6);
            $clean['sex'] = checkSex($_POST['sex']);
            $clean['face'] = checkFace($_POST['face']);
            $clean['email'] = checkEmail($_POST['email'],6,40);
            $clean['qq'] = checkQq($_POST['qq']);
            $clean['url'] = checkUrl($_POST['url'],40);
            $clean['switch'] = $_POST['switch'];
            $clean['autograph'] = checkPostge($_POST['autograph'],200);


        }
        //update01
        if (empty($clean['password'])) {
            query("UPDATE tg_user SET 
																tg_sex='{$clean['sex']}',
																tg_face='{$clean['face']}',
																tg_email='{$clean['email']}',
																tg_qq='{$clean['qq']}',
																tg_url='{$clean['url']}',
																tg_switch='{$clean['switch']}',
																tg_autograph='{$clean['autograph']}'
													WHERE
																tg_username='{$_COOKIE['username']}' 
																");
        } else {
            query("UPDATE tg_user SET 
                                                                tg_password='{$clean['password']}',
																tg_sex='{$clean['sex']}',
																tg_face='{$clean['face']}',
																tg_email='{$clean['email']}',
																tg_qq='{$clean['qq']}',
																tg_url='{$clean['url']}',
																tg_switch='{$clean['switch']}',
																tg_autograph='{$clean['autograph']}'
													WHERE
																tg_username='{$_COOKIE['username']}' 
																");
        }

        if (affectedRow() == 1) {
            mysqlClose();
            //session_unset();
            //session_destroy();
            alertLocation('恭喜你，修改成功！','member_modify.php');

        } else {
            mysqlClose();
            //session_unset();
            //session_destroy();
            alertLocation('很遗憾，没有任何数据被修改！','member_modify.php');
        }
    }


    //select
    if (isset($_COOKIE['username'])) {
        $rows =fetchArray("SELECT
                                     *
                               FROM
                                    tg_user
                               WHERE
                                    tg_username='{$_COOKIE['username']}'
                               LIMIT 
                                    1
                                      ");
        if ($rows) {
            $html= array();
            $html['username'] = $rows['tg_username'];
            $html['sex'] = $rows['tg_sex'];
            $html['face'] = $rows['tg_face'];
            $html['email'] = $rows['tg_email'];
            $html['switch'] = $rows['tg_switch'];
            $html['autograph'] = $rows['tg_autograph'];
            $html['url'] = $rows['tg_url'];
            $html['qq'] = $rows['tg_qq'];
            $html['reg_time'] = $rows['tg_reg_time'];
            $html=Html($html);
            //sex
            if ($html['sex'] == '男') {
                $html['sex_html'] = '<input type="radio" name="sex" value="男" checked="checked" /> 男 <input type="radio" name="sex" value="女" /> 女';
            } else {
                $html['sex_html'] = '<input type="radio" name="sex" value="男" /> 男 <input type="radio" name="sex" value="女" checked="checked" /> 女';
            }
            //face
            $html['face_html'] =  '<select name="face">';
            for ($i=1; $i<10; $i++) {
                $html['face_html'] .= '<option value="face/m0'.$i.'.gif">face/m0'.$i.'.gif</option>';
            }
            for ($i=10; $i<65; $i++) {
                $html['face_html'] .= '<option value="face/m'.$i.'.gif">face/m'.$i.'.gif</option>';
            }
            $html['face_html'] .= '</select>';
            //
            //签名开关
            if ($html['switch'] == 1) {
                $html['switch_html'] = '<input type="radio" checked="checked" name="switch" value="1" /> 启用 <input type="radio" name="switch" value="0" /> 禁用';
            } elseif ($html['switch'] == 0) {
                $html['switch_html'] = '<input type="radio" name="switch" value="1" /> 启用 <input type="radio" name="switch" value="0" checked="checked" /> 禁用';
            }


        } else{
            alertBack('此用户不存在');
        }

    } else {
        alertBack('非法登录');
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统--个人中心</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
    <script type="text/javascript" src="js/member_modify.js"></script>
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>
    <div id="member">
        <?php require ROOT_PATH.'includes/member.inc.php'; ?>
        <div id="member_main">
            <h2>会员管理中心</h2>
            <form method="post" action="?action=modify">
                <dl>
                    <dd>用 户 名：<?php echo $html['username']?></dd>
                    <dd>密　　码：<input type="password" class="text" name="password" /> (留空则不修改)</dd>
                    <dd>性　　别：<?php echo $html['sex_html']?></dd>
                    <dd>头　　像：<?php echo $html['face_html']?></dd>
                    <dd>电子邮件：<input type="text" class="text" name="email" value="<?php echo $html['email']?>" /></dd>
                    <dd>主　　页：<input type="text" class="text" name="url" value="<?php echo $html['url']?>" /></dd>
                    <dd>Q 　 　Q：<input type="text" class="text" name="qq" value="<?php echo $html['qq']?>" /></dd>
                    <dd>个性签名：<?php echo $html['switch_html']?>(可以使用html标签)
                        <p><textarea name="autograph"><?php echo $html['autograph']?></textarea></p>
                    </dd>
                    <dd>验 证 码：<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" onclick="this.src='code.php?tm='+Math.random() " /></dd>
                    <dd><input type="submit" class="submit" value="修改资料" /></dd>
                </dl>
            </form>
        </div>
    </div>
    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>
