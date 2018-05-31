<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/29
     * Time: 14:11
     */
    session_start();
    define('IN_TG',true);
    define('SCRIPT','photo');
    require dirname(__FILE__).'/includes/common.inc.php';
    //

    if (@$_GET['action'] == 'delete' && isset($_GET['id'])) {
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
            //删除目录
            if (!!$rows = fetchArray("SELECT 
																		tg_dir
															FROM 
																		tg_dir 
														 WHERE 
																		tg_id='{$_GET['id']}' 
															 LIMIT 
																		1"
            )) {
                $html = array();
                $html['url'] = $rows['tg_dir'];
                $html = Html($html);
                //3.删除磁盘的目录
                if (file_exists($html['url'])) {
                    if (removeDir($html['url'])) {
                        //1.删除目录里的数据库图片
                        query("DELETE FROM tg_photo WHERE tg_sid='{$_GET['id']}'");
                        //2.删除这个目录的数据库
                        query("DELETE FROM tg_dir WHERE tg_id='{$_GET['id']}'");
                        mysqlClose();
                        alertLocation('目录删除成功!','photo.php');
                    } else {
                        mysqlClose();
                        alertBack('目录删除失败!');
                    }
                }
            }  else {
                alertBack('不存在此目录！');
            }
        } else {
            alertBack('非法登录！');
        }
    }

    //display
    page("SELECT   COUNT(tg_id) as NUM FROM tg_dir",$system['photo']);
    $result = query("SELECT 
												 *
									FROM 
												tg_dir 
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
    <title><?php echo  $system['webname'] ?>--相册 </title>
    <?php require ROOT_PATH.'includes/title.inc.php'; ?>
</head>
<body>
    <?php require ROOT_PATH.'includes/header.inc.php'; ?>
    <div id="photo">
        <h2>相册列表</h2>
        <?php
            $html = array();
            $img=array();
            while (!!$rows = fetchArrayList($result)) {
                $html['id'] = $rows['tg_id'];
                $html['name'] = $rows['tg_name'];
                $html['type'] = $rows['tg_type'];
                $img['face'] = $rows['tg_face'];
                $html = Html($html);
                if (empty($html['type'])) {
                    $html['type_html'] = '(公开)';
                } else {
                    $html['type_html'] = '(私密)';
                }

                if (empty($img['face'])) {
                    $img['face_html'] = '<img src="images/photo.jpg"  style="width:93px;height: 92px;"  />';
                } else {
                    $img['face_html'] = '<img src="'.$img['face'].'" style="width:93px;height: 92px"  />';
                }
                $html['photo'] = fetchArray("SELECT COUNT(*) AS count FROM tg_photo WHERE tg_sid={$html['id']}");
                ?>
                <dl>

                    <dt><a href="photo_show.php?id=<?php echo $html['id']?>"><?php echo $img['face_html'];?></a></dt>
                    <dd><a href="photo_show.php?id=<?php echo $html['id']?>"><?php echo $html['name']?><?php echo '['.$html['photo']['count'].']'.$html['type_html'] ?></a></dd>
                    <?php if (isset($_SESSION['admin']) && isset($_COOKIE['username'])) {?>
                        <dd>[<a href="photo_modify_dir.php?id=<?php echo $html['id']?>">修改</a>] [<a href="photo.php?action=delete&id=<?php echo $html['id']?>">删除</a>]</dd>
                    <?php }?>
                </dl>
            <?php }?>

        <?php if (isset($_SESSION['admin']) && @isset($_COOKIE['username'])) {?>
            <p><a href="photo_add_dir.php">添加目录</a></p>
        <?php }?>
    </div>
    <?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>
