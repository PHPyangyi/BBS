<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/27
     * Time: 11:05
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','member');
    require dirname(__FILE__).'/includes/common.inc.php';
    if (isset($_COOKIE['username'])) {
        $rows =fetchArray("SELECT
                                    tg_username,
                                    tg_sex,
                                    tg_face,
                                    tg_email,
                                    tg_url,
                                    tg_qq,
                                    tg_level,
                                    tg_reg_time 
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
            $html['url'] = $rows['tg_url'];
            $html['qq'] = $rows['tg_qq'];
            $html['reg_time'] = $rows['tg_reg_time'];
            switch ($rows['tg_level']) {
                case 0:
                    $html['level'] = '普通会员';
                    break;
                case 1:
                    $html['level'] = '管理员';
                    break;
                default:
                    $html['level'] = '出错';
            }
            $html=Html($html);
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
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>

    <div id="member">
        <?php require ROOT_PATH.'includes/member.inc.php'; ?>
        <div id="member_main">
            <h2>会员管理中心</h2>
            <dl>
                <dd>用 户 名：<?php echo $html['username']?></dd>
                <dd>性　　别：<?php echo $html['sex']?></dd>
                <dd>头　　像：<img src="<?php echo $html['face']?>" alt="<?php echo $html['face']?>"></dd>
                <dd>电子邮件：<?php echo $html['email']?></dd>
                <dd>主　　页：<?php echo $html['url']?></dd>
                <dd>Q 　 　Q：<?php echo $html['qq']?></dd>
                <dd>注册时间：<?php echo $html['reg_time']?></dd>
                <dd>身　　份：<?php echo $html['level']?></dd>
            </dl>
        </div>
    </div>
    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>
