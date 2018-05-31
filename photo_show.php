<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/31
     * Time: 9:28
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','photo_show');
    require dirname(__FILE__).'/includes/common.inc.php';

    if (@$_GET['action'] == 'delete' && isset($_GET['id'])) {
        include ROOT_PATH.'includes/check_func.php';
        if (!!$rows =@fetchArray("SELECT 
																	tg_uniqid
														FROM 
																	tg_user 
													 WHERE 
																	tg_username='{$_COOKIE['username']}' 
														 LIMIT 
																	1"
        )) {
            checkUniqid($rows['tg_uniqid'], $_COOKIE['uniqid']);
            //取得这张图片的发布者
            if (!!$rows = @fetchArray("SELECT 
																		tg_username,
																		tg_url,
																		tg_id,
																		tg_sid
															FROM 
																		tg_photo 
														 WHERE 
																		tg_id='{$_GET['delid']}' 
															 LIMIT 
																		1"
            )) {
                $html = array();
                $html['id'] = $rows['tg_id'];
                $html['sid'] = $rows['tg_sid'];
                $html['username'] = $rows['tg_username'];
                $html['url'] = $rows['tg_url'];
                $html = Html($html);
                //判断删除图片的身份是否合法
                if ($html['username'] == $_COOKIE['username'] || isset($_SESSION['admin'])) {
                    //首先删除图片的数据库信息
                    query("DELETE FROM tg_photo WHERE tg_id='{$html['id']}'");
                    if (affectedRow() == 1) {
                        //删除图片物理地址
                        if (file_exists($html['url'])) {
                            unlink($html['url']);
                        } else {
                            alertBack('磁盘里已不存在此图！');
                        }
                        mysqlClose();
                        alertLocation('图片删除成功！','photo_show.php?id='.$html['sid']);
                    } else {
                        mysqlClose();
                        alertBack('删除失败！');
                    }
                } else {
                    alertBack('非法操作！');
                }
            } else {
                alertBack('不存在此图片！');
            }
        } else {
            alertBack('非法登录！');
        }
    }


    if (isset($_GET['id'])) {
        if ($rows =fetchArray("SELECT 
																	 *
														FROM
																	tg_dir
														WHERE
																	tg_id='{$_GET['id']}'
														LIMIT
																	1
	")) {
            $dirhtml = array();
            $dirhtml['id'] = $rows['tg_id'];
            $dirhtml['name']=$rows['tg_name'];
            $dirhtml['type'] = $rows['tg_type'];
            $dirhtml = Html($dirhtml);

            if (@$_POST['password']) {
                if (!!$rows = fetchArray("SELECT 
																tg_id
													FROM
																tg_dir
													WHERE
																tg_password='".sha1($_POST['password'])."'
													LIMIT
																1
			")) {
                    //生成cookie
                    setcookie('photo'.$dirhtml['id'],$dirhtml['name']);
                    //重定向
                    alertLocation(null,'photo_show.php?id='.$dirhtml['id']);
                } else {
                    alertBack('相册密码不正确!');
                }
            }



        } else {
            alertBack('不存在此相册！');
        }
    } else {
        alertBack('非法操作！');
    }

    //$_filename = 'photo/1286182238/1286241247.jpg';
    $percent = 0.3;

    //display
    $_id = 'id='.$dirhtml['id'].'&';
    page("SELECT COUNT(tg_id) as NUM  FROM tg_photo WHERE tg_sid='{$dirhtml['id']}'",$system['photo']);
    $result = query("SELECT
												*
									FROM
												tg_photo
									WHERE
												tg_sid='{$dirhtml['id']}'
							ORDER BY
												tg_date DESC
									 LIMIT
												$pagenum,$pagesize
							");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>上传图片</title>
    <?php require ROOT_PATH.'includes/title.inc.php';  ?>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php'; ?>
<div id="photo">
    <h2><?php echo $dirhtml['name']?></h2>
    <?php
        if (empty($dirhtml['type']) || @$_COOKIE['photo'.$dirhtml['id']] == $dirhtml['name'] || isset($_SESSION['admin'])) {

        $html = array();
        while (!!$rows = fetchArrayList($result)) {
            $html['id'] = $rows['tg_id'];
            $html['username'] = $rows['tg_username'];
            $html['name'] = $rows['tg_name'];
            $html['url'] = $rows['tg_url'];
            $html = Html($html);
            ?>
            <dl>
                <dt><a href="photo_detail.php?id=<?php echo $html['id']?>"><img src="thumb.php?filename=<?php echo $html['url']?>&percent=<?php echo $percent?>" style="width: 150px; height: 220px;" /></a></dt>
                <dd><a href="photo_detail.php?id=<?php echo $html['id']?>"><?php echo $html['name']?></a></dd>
                <dd>阅(<strong>0</strong>) 评(<strong>0</strong>) 上传者：<?php echo $html['username']?></dd>
            </dl>
            <?php
            if ($html['username'] == $_COOKIE['username'] || isset($_SESSION['admin'])) {
                ?>
                <dl style="display:inline; width: 40px;height: 20px; margin:240px 10px 240px -80px;" ><a href="photo_show.php?action=delete&id=<?php echo $_GET['id'] ?> &delid=<?php echo $html['id']?>">删除</a></dl>
            <?php }?>
        <?php }
        paging(1);
    ?>
    <p><a href="photo_add_img.php?id=<?php echo $dirhtml['id']?>">上传图片</a></p>
</div>

<?php
	} else {
		echo '<form method="post" action="photo_show.php?id='.$dirhtml['id'].'">';
		echo '<p>请输入密码：<input type="password" name="password" /> <input type="submit" value="确认" /></p>';
		echo '</form>';
	}
	?>

</div>
<?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>
