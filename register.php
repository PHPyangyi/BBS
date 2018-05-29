<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/26
     * Time: 13:54
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','register');
    require dirname(__FILE__).'/includes/common.inc.php';
    loginState();
    //POST
    if (@$_GET['action']=='register') {
        if (empty($system['register'])) {
            exit('不要非法注册！');
        }
    if (!empty($system['code'])) {
        checkCode($_POST['code'], $_SESSION['code']);
    }
        include ROOT_PATH.'includes/check_func.php';
        $clean=array();
        $clean['active'] =shaUniqid();
        $clean['uniqid'] = checkUniqid($_POST['uniqid'],$_SESSION['uniqid']);
        $clean['username'] = checkUsername($_POST['username'],2,20);
        $clean['password'] = checkPassword($_POST['password'],$_POST['notpassword'],6);
        $clean['question'] = checkQuestion($_POST['question'],2,20);
        $clean['answer'] = checkAnswer($_POST['question'],$_POST['answer'],2,20);
        $clean['sex'] = checkSex($_POST['sex']);
        $clean['face'] = checkFace($_POST['face']);
        $clean['email'] = checkEmail($_POST['email'],6,40);
        $clean['qq'] = checkQq($_POST['qq']);
        $clean['url'] = checkUrl($_POST['url'],40);

        $query=isRepeat("SELECT tg_username FROM tg_user WHERE tg_username='{$clean['username']}' LIMIT 1",'此用户以注册');


        query(
              "INSERT INTO tg_user (
                                        tg_uniqid,
										tg_active,
										tg_username,
										tg_password,
										tg_question,
										tg_answer,
										tg_sex,
										tg_face,
										tg_email,
										tg_qq,
										tg_url,
										tg_reg_time,
										tg_last_time,
										tg_last_ip
                                      ) VALUES (
                                      
                                      '{$clean['uniqid']}',
									  '{$clean['active']}',
									  '{$clean['username']}',
									  '{$clean['password']}',
									  '{$clean['question']}',
									  '{$clean['answer']}',
									  '{$clean['sex']}',
									  '{$clean['face']}',
									  '{$clean['email']}',
									  '{$clean['qq']}',
									  '{$clean['url']}',
									  NOW(),
									  NOW(),
									  '{$_SERVER["REMOTE_ADDR"]}'
                                      
                                      )"
        );

        if (affectedRow() == 1) {
            mysqlClose();
           // session_unset();
           // session_destroy();
            alertLocation('恭喜你，注册成功','active.php?active='.$clean['active']);

        } else {
            mysqlClose();
            //session_unset();
            //session_destroy();
            alertLocation('很遗憾，注册失败！','register.php');
        }

    }

    $_SESSION['uniqid']=$uniqid=shaUniqid();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $system['webname'] ?>--注册</title>
    <?php require ROOT_PATH.'/includes/title.inc.php ' ?>
    <script type="text/javascript" src="js/register.js"></script>
</head>
<body>
    <?php require ROOT_PATH.'/includes/header.inc.php' ?>

    <div id="register">
        <h2>会员注册</h2>
        <?php if (!empty($system['register'])) {?>
        <form action="register.php?action=register" method="post" name="register">
            <input type="hidden" name="uniqid" value="<?php echo $uniqid ?>" />
            <dl>
                <dt>请认真填写一下内容</dt>
                <dd>用 户 名 ：&nbsp<input type="text" name="username" class="text" /> (*必填，至少两位)</dd>
                <dd>密　　码：<input type="password" name="password" class="text" /> (*必填，至少六位)</dd>
                <dd>确认密码：<input type="password" name="notpassword" class="text" /> (*必填，同上)</dd>
                <dd>密码提示：<input type="text" name="question" class="text" /> (*必填，至少两位)</dd>
                <dd>密码回答：<input type="text" name="answer" class="text" /> (*必填，至少两位)</dd>
                <dd>性　　别：<input type="radio" name="sex" value="男" checked="checked" />男 <input type="radio" name="sex" value="女" />女</dd>
                <dd class="face"><input type="hidden" name="face" value="face/m01.gif" /><img src="face/m01.gif" alt="头像选择" id="faceimg" /></dd>
                <dd>电子邮件：<input type="text" name="email" class="text" /> (*必填，激活账户)</dd>
                <dd>　Q Q 　：<input type="text" name="qq" class="text" /></dd>
                <dd>主页地址：<input type="text" name="url" class="text" value="http://" /></dd>
                <?php if (!empty($system['code'])) {?>
                    <dd>验 证 码：<input type="text" name="code" class="text code"  /> <img src="code.php" id="code" onclick="this.src='code.php?tm='+Math.random() " /></dd>
                <?php }?>
                <dd><input type="submit" class="submit" value="注册" /></dd>
            </dl>
        </form>
        <?php } else {
            echo '<h4 style="text-align:center;padding:20px;">本站关闭了注册功能！</h4>';
        }?>
    </div>

    <?php require ROOT_PATH.'/includes/footer.inc.php' ?>
</body>
</html>