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

    //unsession
    function sessionDestroy ()
    {
        if (session_start()) {
            session_unset();
            session_destroy();
        }
    }

    //uncooike
    function unsetCookie ()
    {
        setcookie('username','',time()-1);
        setcookie('uniqid','',time()-1);
        sessionDestroy();
        alertLocation(null,'index.php');
    }

    //判断login
    function loginState ()
    {
        if (isset($_COOKIE['username'])) {
            alertBack('登录状态无法进行本操作！');
        }
    }


    //check
    function checkCode ($first,$end)
    {
        if ($first != $end) {
            alertBack('验证码不正确');
        }
    }

    //uniqid
    function shaUniqid ()
    {
       return  sha1(uniqid(rand(),true));
    }

    //过滤html
    function Html ($str)
    {
        if (is_array($str)) {
            foreach ($str as $key => $value) {
                $str[$key] = Html( $value );
            }
        } else {
            $str=htmlspecialchars($str);
        }

        return $str;
    }
    //过滤数据库信息
    //mysql_string
    function mysqlString ($str)
    {
        if  (!get_magic_quotes_gpc()) {
            if (is_array($str)) {
                foreach ($str as $key => $value) {
                    $str[$key] = mysqlString($value);
                }
            }
        } else {
                addslashes($str);
        }
        return $str;
    }

    //title
    function Title ($str) {
        if (mb_strlen($str,'utf-8') > 14) {
            $str = mb_substr($str,1,14,'utf-8').'...';
        }
        return $str;
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

    //page
    function page ($sql,$size)
    {   //用全局取出来
        global $page,$pagesize,$pagenum,$pageabsolute,$num;
        //处理
        if (isset($_GET['page'])) {
            $page =$_GET['page'];
            if (empty($page) || $page < 0 || !is_numeric($page)) {
                $page = 1;
            } else {
                $page = intval($page);
            }
        } else {
            $page = 1;
        }

        $pagesize = $size;
        $num=query($sql);
        $num=fetchArrayList($num);
        $num= $num['NUM'];

        $pageabsolute=ceil($num/$pagesize);

        if ($num == 0) {
            $pageabsolute = 1;
        } else {
            $pageabsolute = ceil($num / $pagesize);
        }
        if ($page > $pageabsolute) {
            $page = $pageabsolute;
        }
        $pagenum = ($page - 1) * $pagesize;
    }


    function paging ($type)
    {
        global $page,$pageabsolute,$num,$_id;
        if ($type == 1 ) {
            echo '<div id="page_num">';
            echo '<ul>';
            for ($i=0;$i<$pageabsolute;$i++) {
                if ($page == ($i+1)) {
                    echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($i+1).'" class="selected">'.($i+1).'</a></li>';
                } else {
                    echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($i+1).'">'.($i+1).'</a></li>';
                }
            }
            echo '</ul>';
            echo '</div>';
        } elseif ($type == 2) {
            echo '<div id="page_text">';
            echo '<ul>';
            echo '<li>'.$page.'/'.$pageabsolute.'页 | </li>';
            echo '<li>共有<strong>'.$num.'</strong>条数据 | </li>';
            if ($page == 1) {
                echo '<li>首页 | </li>';
                echo '<li>上一页 | </li>';
            } else {
                echo '<li><a href="'.SCRIPT.'.php">首页</a> | </li>';
                echo '<li><a href="'.SCRIPT.'.php?page='.($page-1).'">上一页</a> | </li>';
            }
            if ($page == $pageabsolute) {
                echo '<li>下一页 | </li>';
                echo '<li>尾页</li>';
            } else {
                echo '<li><a href="'.SCRIPT.'.php?page='.($page+1).'">下一页</a> | </li>';
                echo '<li><a href="'.SCRIPT.'.php?page='.$pageabsolute.'">尾页</a></li>';
            }
            echo '</ul>';
            echo '</div>';
        }
    }











    function Thumb($_filename,$_percent) {
        //生成png标头文件
        header('Content-type: image/png');
        $_n = explode('.',$_filename);
        //获取文件信息，长和高
        list($_width, $_height) = getimagesize($_filename);
        //生成缩微的长和高
        $_new_width = $_width * $_percent;
        $_new_height = $_height * $_percent;
        //创建一个以0.3百分比新长度的画布
        $_new_image = imagecreatetruecolor($_new_width,$_new_height);
        //按照已有的图片创建一个画布
        switch ($_n[1]) {
            case 'jpg' : $_image = imagecreatefromjpeg($_filename);
                break;
            case 'png' : $_image = imagecreatefrompng($_filename);
                break;
            case 'gif' : $_image = imagecreatefrompng($_filename);
                break;
        }
        //将原图采集后重新复制到新图上，就缩略了
        imagecopyresampled($_new_image, $_image, 0, 0, 0, 0, $_new_width,$_new_height, $_width, $_height);
        imagepng($_new_image);
        imagedestroy($_new_image);
        imagedestroy($_image);
    }










