<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/26
     * Time: 18:09
     */
    function connect ()
    {
        global $conn;
        $conn=@mysql_connect(DB_HOST,DB_USER,DB_PWD) or die('数据库连接错误'. @mysql_error());
    }

    function selectDb ()
    {
        if (@!mysql_select_db(DB_NAME)) {
            exit('找不到指定的数据库');
        }
    }

    function setName ()
    {
        if (@!mysql_query('SET NAMES UTF8')) {
            exit('字符集错误');
        }
    }


    function freeResult ($result)
    {
        @mysql_free_result($result);
    }

    function mysqlClose ()
    {
        if (@!mysql_close()) {
            exit('关闭异常');
        }
    }

    function affectedRow ()
    {
        return @mysql_affected_rows();
    }

    function isRepeat ($sql,$info)
    {
        if (fetchArray($sql,MYSQL_ASSOC)) {
            alertBack($info);
        }
    }
    //////
    ///
    function query ($sql)
    {
        if (!$result = @mysql_query($sql)) {
            exit('SQL执行失败'.@mysql_error());
        }
        return $result;
    }


    function fetchArray ($sql)
    {
        return @mysql_fetch_array(query($sql,MYSQL_ASSOC));
    }

    function insertId ()
    {
        return @mysql_insert_id();
    }




















