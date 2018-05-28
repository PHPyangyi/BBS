<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/26
     * Time: 16:11
     */

    //register

    //username
    function checkUsername ($str,$min,$max)
    {
        $str=trim($str);
        if (mb_strlen($str,'utf-8') < $min || mb_strlen($str,'utf8') > $max) {
            alertBack('用户名长度不得小于'.$min.'位或者大于'.$max.'位');
        }

        //限制敏感字符
        $charPattern= '/[<>\'\"\ ]/';
        if (preg_match($charPattern,$str)) {
            alertBack('用户名不得包含敏感字符');
        }
        //限制敏感用户名

        return  mysqlString( $str);

    }

    //password
    function checkModifyPassword ($str,$min)
    {
        if (!empty($str)) {
            if (strlen($str) < $min) {
                alertBack('密码不得小于'.$min.'位！');
            }
        } else {
            return null;
        }
        return  mysqlString( $str);
    }

    function checkPassword ($firstPass, $endPass, $min)
    {
        if (strlen($firstPass) < $min) {
            alertBack('密码不得小于'.$min.'位！');
        }

        if ($firstPass != $endPass) {
            alertBack('密码和确认密码不一致！');
        }

        return sha1($firstPass);
    }

    //answer
    function checkAnswer ($ques,$answ,$min,$max)
    {
        $answ=trim($answ);
        if (mb_strlen($answ,'utf-8') < $min || mb_strlen($answ,'utf-8') > $max) {
            alertBack('密码回答不得小于'.$min.'位或者大于'.$max.'位');
        }
        if ($ques == $answ) {
            alertBack('密码提示与回答不得相同');
        }
        return  mysqlString( $answ);
    }

    //密码提示
    function checkQuestion ($str, $min, $max)
    {
        $_string = trim($str);
        //长度小于4位或者大于20位
        if (mb_strlen($_string,'utf-8') < $min || mb_strlen($_string,'utf-8') > $max) {
            alertBack('密码提示不得小于'.$min.'位或者大于'.$max.'位');
        }

        //返回密码提示
        return  mysqlString( $str);
    }


    //sex
    function checkSex ($str)
    {
        return  mysqlString( $str);
    }

    //face
    function checkFace ($str)
    {
        return  mysqlString( $str);
    }

    //email
    function checkEmail ($str,$min,$max)
    {
        if (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',$str)) {
            alertBack('邮件格式不正确！');
        }
        if (strlen($str) < $min || strlen($str) > $max) {
            alertBack('邮件长度不合法！');
        }
        return  mysqlString( $str);
    }

    //qq
    function checkQq ($str)
    {
        if (empty($str)) {
            return null;
        } else {
            if (!preg_match('/^[1-9]{1}[\d]{4,9}$/',$str)) {
                alertBack('QQ号码不正确！');
            }
        }

        return  mysqlString( $str);
    }

    //url
    function checkUrl ($str,$max)
    {
        if (empty($str) || ($str == 'http://')) {
            return null;
        } else {
            if (!preg_match('/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/',$str)) {
                _alert_back('网址不正确！');
            }
            if (strlen($str) > $max) {
                _alert_back('网址太长！');
            }
        }

        return  mysqlString( $str);
    }

    //唯一标识符
    function checkUniqid ($first, $end)
    {
        if ((strlen($first) != 40) || ($first != $end)) {
            alertBack('唯一标识符异常');
        }
        return  mysqlString( $first);
    }





    //login
    function checkLoginPassword ($str,$min)
    {
        if (strlen($str) < $min) {
            _alert_back('密码不得小于'.$min.'位！');
        }

        return sha1($str);
    }

    function checkTime ($str)
    {
        $time=array('0','1','2','3');
        if (!in_array($str,$time)) {
            alertBack('保留方式错误');
        }
        return mysqlString($str);
    }

    //cookie
    function SetCookies($username,$uniqid,$time)
    {
        switch ($time) {
            case '0':  //浏览器进程
                setcookie('username',$username);
                setcookie('uniqid',$uniqid);
                break;
            case '1':  //一天
                setcookie('username',$username,time()+86400);
                setcookie('uniqid',$uniqid,time()+86400);
                break;
            case '2':  //一周
                setcookie('username',$username,time()+604800);
                setcookie('uniqid',$uniqid,time()+604800);
                break;
            case '3':  //一月
                setcookie('username',$username,time()+2592000);
                setcookie('uniqid',$uniqid,time()+2592000);
                break;
        }
    }


    //member_modify
    function checkMemberModifyPassword ($str,$min)
    {
        if (!empty($str)) {
            if (strlen($str) < $min) {
                _alert_back('密码不得小于'.$min.'位！');
            }
        } else {
            return null;
        }
        return sha1($str);
    }





    //message

    function checkMessageContent ($str) {
        if (mb_strlen($str,'utf-8') < 10 || mb_strlen($str,'utf-8') > 200) {
            alertBack('短信内容不得小于10位或者大于200位！');
        }
        return $str;
    }



    //post

    function checkPostTitle ($str,$min,$max)
    {
        if (mb_strlen($str,'utf-8') < $min || mb_strlen($str,'utf-8') > $max) {
            alertBack('帖子标题内容不得小于'.$min.'位大于'.$max.'位！');
        }
        return $str;
    }

    function checkPostContent ($str,$number)
    {
        if (mb_strlen($str,'utf-8') < $number) {
            alertBack('帖子内容不得小于'.$number.'位！');
        }
        return $str;
    }




    function checkPostge ($str,$number)
    {
        if (mb_strlen($str,'utf-8') > $number) {
            alertBack('个性签名内容不得大于'.$number.'位！');
        }
        return $str;
    }








