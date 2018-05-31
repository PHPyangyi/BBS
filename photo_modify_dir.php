<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/31
     * Time: 9:11
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','photo_add_dir');
    require dirname(__FILE__).'/includes/common.inc.php';
    //update
    if (@$_GET['action'] == 'modify') {
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
            $clean = array();
            $clean['id'] = $_POST['id'];
            $clean['name'] =$_POST['name'];
            $clean['type'] = $_POST['type'];
            if (!empty($clean['type'])) {
                $clean['password'] = sha1( $_POST['password']);
            }
            $clean['face'] = $_POST['face'];
            $clean['content'] = $_POST['content'];
            $clean = mysqlString($clean);

            if (empty($clean['type'])) {
                query("UPDATE 
												tg_dir 
									SET 
												tg_name='{$clean['name']}',
												tg_type='{$clean['type']}',
												tg_password=NULL,
												tg_face='{$clean['face']}',
												tg_content='{$clean['content']}'
								WHERE
												tg_id='{$clean['id']}'
									LIMIT 
												1
			");
            } else {
                query("UPDATE 
												tg_dir 
									SET 
												tg_name='{$clean['name']}',
												tg_type='{$clean['type']}',
												tg_password='{$clean['password']}',
												tg_face='{$clean['face']}',
												tg_content='{$clean['content']}'
								WHERE
												tg_id='{$clean['id']}'
									LIMIT 
												1
			");
            }
            if (affectedRow() == 1) {
                mysqlClose();
                alertLocation('目录修改成功','photo.php');
            } else {
                mysqlClose();
                alertBack('目录修改失败！');
            }
        }
    }




    //display
    if (isset($_GET['id'])) {
        if (!!$rows = @fetchArray("SELECT 
																tg_id,
																tg_name,
																tg_type,
																tg_face,
																tg_content 
													FROM 
																tg_dir 
												  WHERE 
																tg_id='{$_GET['id']}'
													LIMIT 
																1
	")) {
            $html = array();
            $html['id'] = $rows['tg_id'];
            $html['name'] = $rows['tg_name'];
            $html['type'] = $rows['tg_type'];
            $html['face'] = $rows['tg_face'];
            $html['content'] = $rows['tg_content'];
            $html = Html($html);
        } else {
            alertBack('不能存在此相册！');
        }
    } else {
        alertBack('非法操作！');
    }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo  $system['webname'] ?>--相册修改</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
    <script type="text/javascript" src="js/photo_add_dir.js"></script>
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>
    <div id="photo">
        <h2>修改相册目录</h2>
        <form method="post" action="?action=modify">
            <dl>
                <dd>相册名称：<input type="text" name="name" class="text" value="<?php echo $html['name']?>" /></dd>
                <dd>相册类型：<input type="radio" name="type" value="0" <?php if ($html['type'] == 0) echo 'checked="checked"'?> /> 公开 <input type="radio" name="type" value="1" <?php if ($html['type'] == 1) echo 'checked="checked"'?> /> 私密</dd>
                <dd id="pass" <?php if ($html['type'] == 1) echo 'style="display:block;"'?>>相册密码：<input type="password" name="password" class="text" /></dd>
                <dd>相册封面：<input type="text" name="face" value="<?php echo $html['face']?>" class="text" /></dd>
                <dd>相册描述：<textarea name="content"><?php echo $html['content']?></textarea></dd>
                <dd><input type="submit" class="submit" value="修改目录" /></dd>
            </dl>
            <input type="hidden" value="<?php echo $html['id']?>" name="id" />
        </form>
    </div>
    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>
