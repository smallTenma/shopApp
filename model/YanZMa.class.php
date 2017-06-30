<?php

class YanZMa
{
    private $codes;
    private $img;
    private $codelen=4;
    private $width=120;
    private $height=40;
    private $fontsize=20;
    private $font;//指定的字体
    private $fontcolor;
    public function __construct(){
        $this->font=dirname(__FILE__)."/../public/font/ADOBEFANHEITISTD-BOLD.OTF";
    }
    
    //生成随机码
    private function createCode(){
        $arr=range("a", "z");
        for($i=0;$i<10;$i++){
            array_push($arr, $i);
        }
        for($i=0;$i<$this->codelen;$i++){
            $this->codes.=$arr[array_rand($arr)];
        }
    }
    
    //生成背景
    private function createBg(){
        $this->img=imagecreatetruecolor($this->width, $this->height);
        $color=imagecolorallocate($this->img, mt_rand(157, 255), mt_rand(157, 255), mt_rand(157, 255));
        imagefilledrectangle($this->img, 0, $this->height, $this->width, 0, $color);
    }
    //生成文字
    private function createFont(){
        $_x=$this->width/$this->codelen;
        for($i=0;$i<$this->codelen;$i++){
            $this->fontcolor=imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imagettftext($this->img, $this->fontsize, mt_rand(-30,30),
                $_x*$i+mt_rand(1,5), $this->height/1.4, $this->fontcolor, $this->font, $this->codes[$i]);
        }
    }
    //生成线条
    private function createLine(){
        for($i=0;$i<6;$i++){
            $color=imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imageline($this->img, mt_rand(0,$this->width/2), mt_rand(0, $this->height), mt_rand($this->width/2, $this->width), mt_rand(0, $this->height), $color);
            
        }
        for($i=0;$i<50;$i++){
            $color=imagecolorallocate($this->img, mt_rand(200,255), mt_rand(200,255),mt_rand(200,255));
            imagestring($this->img, mt_rand(1, 5), mt_rand(0, $this->width), mt_rand(0, $this->height), "*", $color);
            //画点//imagesetpixel($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), $color);
        }
    }
    
    //输出
    private function outPut(){
        header('content-type:image/png');
        imagepng($this->img);
        imagedestroy($this->img);
    }
    //对外生成
    public function mkYz(){
        session_start();
        $this->createBg();
        $this->createCode();
        $this->createLine();
        $this->createFont();
        $this->outPut();
        $_SESSION["code"]=$this->codes;
        
    }
    
    //获取验证码
    public function getCode(){
        session_start();
        $c = $_SESSION["code"];
        echo strtolower($c);
    }
}
?>