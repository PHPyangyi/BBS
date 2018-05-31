<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/31
     * Time: 10:35
     */
    define('IN_TG',true);
    define('SCRIPT','thumb');
    require dirname(__FILE__).'/includes/common.inc.php';
    if (isset($_GET['filename']) && isset($_GET['percent'])) {
        Thumb($_GET['filename'],$_GET['percent']);
    }
?>