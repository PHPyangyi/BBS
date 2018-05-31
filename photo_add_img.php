<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/31
     * Time: 9:34
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','photo_add_img');
    require dirname(__FILE__).'/includes/common.inc.php';

    //add
    if (@$_GET['action'] == 'addimg') {
        include ROOT_PATH.'includes/check_func.php';
        if (!!$rows = fetchArray("SELECT 
                                                                    tg_uniqid 
                                                        FROM 
                                                                    tg_user 
                                                     WHERE 
                                                                    tg_username='{$_COOKIE['username']}' 
                                                         LIMIT 
                                                                    1"
        )) {
            checkUniqid($rows['tg_uniqid'], $_COOKIE['uniqid']);
            //接收数据
            $clean = array();
            $clean['name'] = $_POST['name'];
            $clean['url'] =$_POST['url'];
            $clean['content'] = $_POST['content'];
            $clean['sid'] = $_POST['sid'];
            $clean = mysqlString($clean);
            //写入数据库
            query("INSERT INTO tg_photo (
																	tg_name,
																	tg_url,
																	tg_content,
																	tg_sid,
																	tg_username,
																	tg_date
															) 
											VALUES (	
																	'{$clean['name']}',
																	'{$clean['url']}',
																	'{$clean['content']}',
																	'{$clean['sid']}',
																	'{$_COOKIE['username']}',
																	NOW()
															)"
            );
            if (affectedRow() == 1) {
                mysqlClose();
                alertLocation('图片添加成功！','photo_show.php?id='.$clean['sid']);
            } else {
                mysqlClose();
                alertBack('图片添加失败！');
            }
        } else {
            alertBack('非法登录！');
        }
    }



    if (isset($_GET['id'])) {
        if (!!$rows = fetchArray("SELECT 
																	 *
														FROM
																	tg_dir
														WHERE
																	tg_id='{$_GET['id']}'
														LIMIT
																	1
	")) {
            $html = array();
            $html['id'] = $rows['tg_id'];
            $html['dir'] = $rows['tg_dir'];
            $html = Html($html);
        } else {
            alertBack('不存在此相册！');
        }
    } else {
         alertBack('非法操作！');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>上传相片</title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
    <script type="text/javascript" src="js/photo_add_img.js"></script>
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>
    <div id="photo">
        <h2>上传图片</h2>
        <form method="post" action="?action=addimg">
            <input type="hidden" name="sid" value="<?php echo $html['id']?>" />
            <dl>
                <dd>图片名称：<input type="text" name="name" class="text" /></dd>
                <dd>图片地址：<input type="text" name="url" readonly="readonly" class="text"  id="url" /> <a href="javascript:;" title="<?php echo $html['dir']?>" id="up">上传</a></dd>
                <dd>图片描述：<textarea name="content"></textarea></dd>
                <dd><input type="submit" class="submit" value="添加图片" /></dd>
            </dl>
        </form>
    </div>
    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>

