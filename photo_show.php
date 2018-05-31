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
    if (isset($_GET['id'])) {
        if ($rows =fetchArray("SELECT 
																	tg_id
														FROM
																	tg_dir
														WHERE
																	tg_id='{$_GET['id']}'
														LIMIT
																	1
	")) {
            $dirhtml = array();
            $dirhtml['id'] = $rows['tg_id'];
            $dirhtml = Html($dirhtml);
        } else {
            alertBack('不存在此相册！');
        }
    } else {
        alertBack('非法操作！');
    }

    $_filename = 'photo/1286182238/1286241247.jpg';
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
    <h2>图片展示</h2>
    <?php
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
        <?php }
        paging(1);
    ?>
    <p><a href="photo_add_img.php?id=<?php echo $dirhtml['id']?>">上传图片</a></p>
</div>


</div>
<?php require ROOT_PATH.'includes/footer.inc.php'; ?>
</body>
</html>
