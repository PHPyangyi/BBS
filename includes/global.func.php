<?php
    /**
     * Created by PhpStorm.
     * User: 阳毅
     * Date: 2018/5/26
     * Time: 13:46
     */

    //执行时间
    function _runtime ()
    {
        $_mtime = explode(' ',microtime());
        return $_mtime[1] + $_mtime[0];
    }

    //弹窗
    function alertBack($_info)
    {
        echo "<script type='text/javascript'>alert('$_info');history.back();</script>";
        exit();
    }

    function alertClose($_info)
    {
        echo "<script type='text/javascript'>alert('$_info');window.close();</script>";
        exit();
    }

    function alertLocation($info,$url)
    {
        if (!empty($_info)) {
            echo "<script type='text/javascript'>alert('$info');location.href='$url';</script>";
            exit();
        } else {
            header('Location:'.$url);
        }
    }

    //check
    function checkCode ($first,$end)
    {
        if ($first != $end) {
            alertBack('验证码不正确');
        }
    }

    //mysql_string
    function mysqlString ($str)
    {
        if  (!get_magic_quotes_gpc()) {
            return addslashes($str);
        } else {
            return $str;
        }
    }

    //uniqid
    function shaUniqid ()
    {
       return  sha1(uniqid(rand(),true));
    }


    //check code
    function code ()
    {

        $nmsg='';
        for ($i=0; $i<4; $i++) {
            $nmsg.=dechex(mt_rand(0,15));
        }
        $_SESSION['code']=$nmsg;
        $width=75;
        $height=25;
        $img=imagecreatetruecolor($width,$height);
        $white=imagecolorallocate($img,255,255,255);
        imagefill($img,0,0,$width);
        $blank=imagecolorallocate($img,100,100,100);
        imagerectangle($img,0,0,$width-1,$height-1,$blank);
        //随机划线
        for ($i=0; $i<6; $i++) {
            $rndColor= imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255) ,mt_rand(0,255));
            imageline($img,mt_rand(0,75),mt_rand(0,75),mt_rand(0,75),mt_rand(0,75) ,$rndColor);

        }

        //随机雪花
        for ($i=0; $i<10; $i++) {
            //imagestring($img,1,mt_rand(1,$width),mt_rand(1,$height),"*", imagecolorallocate($img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255)));
        }

        //输出验证码
        for($i=0; $i<strlen($_SESSION['code']); $i++) {
            imagestring($img,mt_rand(3,5),$i*$width/4+mt_rand(1,10), mt_rand(1,$height/2),$_SESSION['code'][$i], imagecolorallocate($img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200)));
        }

        header("Content-Type: image/png");
        imagepng($img);
        imagedestroy($img);

    }