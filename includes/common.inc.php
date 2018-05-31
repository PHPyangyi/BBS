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


    //短信提醒
    $_message =
        @fetchArray("SELECT 
																COUNT(tg_id) 
														AS 
																count 
													FROM 
																tg_message 
												 WHERE 
												 				tg_state=0
												 	   AND
												 	   			tg_touser='{$_COOKIE['username']}'
    ");
    if (empty($_message['count'])) {
        $GLOBALS['message'] = '<strong class="noread"><a href="member_message.php">(0)</a></strong>';
    } else {
        $GLOBALS['message'] = '<strong class="read"><a href="member_message.php">('.$_message['count'].')</a></strong>';
    }





    //网站系统设置初始化
    if (!!$rows = fetchArray("SELECT 
															tg_webname,
															tg_article,
															tg_blog,
															tg_photo,
															tg_skin,
															tg_string,
															tg_post,
															tg_re,
															tg_code,
															tg_register 
												FROM 
															tg_system 
											 WHERE 
															tg_id=1 
												 LIMIT 
															1"
    )) {
        $system = array();
        $system['webname'] = $rows['tg_webname'];
        $system['article'] = $rows['tg_article'];
        $system['blog'] = $rows['tg_blog'];
        $system['photo'] = $rows['tg_photo'];
        $system['skin'] = $rows['tg_skin'];
        $system['code'] = $rows['tg_code'];
        $system['register'] = $rows['tg_register'];
        $system['string'] = $rows['tg_string'];
        $system = Html($system);

        //如果有skin的cookie那么就替代系统数据库的皮肤
        if (@$_COOKIE['skin']) {
            $system['skin'] = $_COOKIE['skin'];
        }
    } else {
        exit('系统表异常，请管理员检查！');
    }

















