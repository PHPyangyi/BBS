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
                ?>
                <dl>

                    <dt><a href="photo_show.php?id=<?php echo $html['id']?>"><?php echo $img['face_html'];?></a></dt>
                    <dd><a href="photo_show.php?id=<?php echo $html['id']?>"><?php echo $html['name']?> <?php echo $html['type_html'] ?></a></dd>
                    <?php if (isset($_SESSION['admin']) && isset($_COOKIE['username'])) {?>
                        <dd>[<a href="photo_modify_dir.php?id=<?php echo $html['id']?>">修改</a>] [删除]</dd>
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
