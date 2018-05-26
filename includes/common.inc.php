<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/26
     * Time: 13:32
     */
    //转换硬路径常量
    define('ROOT_PATH',substr(dirname(__FILE__),0,-8));


    //引入函数库
    require ROOT_PATH.'/includes/global.func.php';
    require ROOT_PATH.'/includes/mysql_func.php';

    //执行耗时
    define('START_TIME',_runtime());

    //拒绝恶意访问
    if (!defined('IN_TG')) {
        exit('error');
    }

    //拒绝php版本
    if (PHP_VERSION < '4.1.0') {
        exit('error');
    }

    //数据库连接
    define('DB_HOST','localhost');
    define('DB_USER','root');
    define('DB_PWD','root');
    define('DB_NAME','bbs');
    //连接数据库
    connect();
    selectDb();
    setName();