<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/28
     * Time: 20:37
     */
    if (!defined('IN_TG')) {
        exit('Access Defined!');
    }
?>

    <div id="member_sidebar">
        <h2>管理导航</h2>
        <dl>
            <dt>系统管理</dt>
            <dd><a href="manage.php">后台首页</a></dd>
            <dd><a href="manage_set.php">系统设置</a></dd>
        </dl>
        <dl>
            <dt>会员管理</dt>
            <dd><a href="manage_member.php">会员列表</a></dd>
            <dd><a href="manage_job.php">职务设置</a></dd>
        </dl>
    </div>
