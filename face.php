<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/26
     * Time: 14:19
     */
    define('IN_TG',true);
    define('SCRIPT','face');

    require  dirname(__FILE__).'/includes/common.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $system['webname'] ?>--头像选择</title>
    <?php require ROOT_PATH.'/includes/title.inc.php'  ?>
    <script type="text/javascript" src="js/opener.js"></script>
<body>
    <div id="face">
        <h3>选择头像</h3>
        <dl>
            <?php for ($i=1; $i<10; $i++) {?>
                <dd><img src="face/m0<?php echo  $i ?>.gif  " alt="face/m0<?php echo  $i ?>.gif  "  title="头像<?php echo $i ?>"></dd>
            <?php }?>
        </dl>

        <dl>
            <?php for ($i=10; $i<65; $i++) {?>
                <dd><img src="face/m<?php echo  $i ?>.gif  " alt="face/m<?php echo  $i ?>.gif  "  title="头像<?php echo $i ?>"></dd>
            <?php }?>
        </dl>
        
    </div>
</body>
</html>
