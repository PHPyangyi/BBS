<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/31
     * Time: 9:38
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','upimg');
    require dirname(__FILE__).'/includes/common.inc.php';

    if (@$_GET['action'] == 'up') {
        include ROOT_PATH.'includes/check_func.php';
        if (!!$rows = @fetchArray("SELECT 
                                                                            tg_uniqid 
                                                                FROM 
                                                                            tg_user 
                                                             WHERE 
                                                                            tg_username='{$_COOKIE['username']}' 
                                                                 LIMIT 
                                                                            1"
        )) {
            checkUniqid($rows['tg_uniqid'], $_COOKIE['uniqid']);
            $files = array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif');
            if (is_array($files)) {
                if (!in_array($_FILES['userfile']['type'],$files)) {
                    alertBack('上传图片必须是jpg,png,gif中的一种！');
                }
            }

            if ($_FILES['userfile']['error']) {
                switch ($_FILES['userfile']['error']) {
                    case 1: alertBack('上传文件超过约定值1');
                        break;
                    case 2: alertBack('上传文件超过约定值2');
                        break;
                    case 3: alertBack('部分文件被上传');
                        break;
                    case 4: alertBack('没有任何文件被上传！');
                        break;
                }
                exit;
            }
            if ($_FILES['userfile']['size'] > 1000000) {
                alertBack('上传的文件不得超过1M');
            }

            //获取文件的扩展名 1.jpg
            $_n = explode('.',$_FILES['userfile']['name']);
            $_name = $_POST['dir'].'/'.time().'.'.$_n[1];


            if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                if (!move_uploaded_file($_FILES['userfile']['tmp_name'],$_name) ) {
                    alertBack('移动失败');
                } else {
                    echo "<script>alert('上传成功！');window.opener.document.getElementById('url').value='$_name';window.close();</script>";
                }
            } else {
                alertBack('上传的临时文件不存在！');
            }

        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>上传</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
</head>
<body>
<div id="upimg" style="padding:20px;">
    <form enctype="multipart/form-data" action="upimg.php?action=up" method="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
        <input type="hidden" name="dir" value="<?php echo $_GET['dir']?>" />
        选择图片: <input type="file" name="userfile"  style="border: 1px solid #cccccc;"/>
        <input type="submit" value="上传" />
    </form>
</div>
</body>
</html>
