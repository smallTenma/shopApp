<?php
header("content-type:text/html;charset=utf-8");
require_once 'model/DbUntil.class.php';
require_once 'model/YanZMa.class.php';
class User
{
    var $id;
    var $username;
    var $password;
    var $level;
    var $db;
    /* 保存失败和成功信息 */
    var $error;
    var $success;
    var $url;
    public function __construct(){
        $this->db=new DbUntil("xukexitong");
    }
    private function create($username,$password,$level){
        $this->username=$username;
        $this->password=$password;
        $this->level=$level;
    }
    /*
     * 注册方法，传两个个参数
     * username代表用户名
     * password代表密码
     * 也可以用不传的方式  
     */
    public function register(){
        if(isset($_POST["username"])&isset($_POST["password"])){
            $username=$_POST["username"];
            $password=$_POST["password"];
            $sql="select * from `yonghu` where username=?";
            $this->db->search($sql,array($username), $con);
            if($con>0){
               // return '用户名已存在';
                $this->error="用户名已存在";
            }else{
                $dengji=0;
                if($username=="admin"){
                    $dengji=1;
                }
                $sql1="insert into `yonghu` (username,password,level) values (?,?,?)";
                $res=$this->db->addDelUpd($sql1, array($username,$password,$dengji), $con);
                //return "欢迎您".$username;
                
                /* $sql2="select id from `yonghu` where username=?";
                $d=$this->db->search($sql2,array($username),$con);
                $id=$d[0]["id"];
                session_start();
                $path=$_SESSION["path"];
                $sql3="insert into `address`(id,address) values(?,?)";
                $this->db->addDelUpd($sql3,array($id,$path), $con); */
                $path=$this->upload();
                if($path){
                    $sql2="select id from `yonghu` where username=?";
                    $d=$this->db->search($sql2,array($username),$con);
                    $id=$d[0]["id"];
                }
                if($res){
                    //"欢迎您".$username;
                    $this->success="注册成功";
                    $this->url="html/login.php";
                    if($path){
                       $sql2="select id from `yonghu` where username=?";
                       $d=$this->db->search($sql2,array($username),$con);
                       $id=$d[0]["id"];
                       $sql3="insert into `address`(id,address) values(?,?)";
                       $this->db->addDelUpd($sql3,array($id,$path), $con);
                    }
                }
            }
        }
    }
    public function login(){
       session_start();
     if($_SESSION["code"]==$_POST["yanz"]){

        if(isset($_POST["username"])&isset($_POST["password"])){
            $username=$_POST["username"];
            $password=$_POST["password"];
            $sql="select * from `tb_user` where `usernameId`=? and `password`=?";
            $arr=$this->db->search($sql,array($username,$password), $con);
            echo 'bb';
            if($con>0){
                $this->success="登录成功";
                $_SESSION["usernameId"]=$username;
                //$usernameId=$_SESSION["username"];
                $sql1="select tb_level.level from `tb_level` join `tb_user` on tb_level.user_id=tb_user.usernameId where usernameId=?";
                $id=$this->db->search($sql1,array($username),$con);
                $_SESSION["level"]=$id[0]["level"];
                  if($id[0]["level"]==1){
                    $this->url="view/index.html";
                }else if($id[0]["level"]==2){
                    $this->url="view/teacher.html";
                }else if($id[0]["level"]==3){
                    $this->url="view/student.html";
                }  
            }else{
                $this->error="用户名或者密码错误";
            }
        }
       }else {
          $this->error="验证码错误";
      }  
      
    }
    public function __call($fun,$args){
        echo "不能调用不存在的方法{$fun},"."参数是{$arg}";
    }
    public function logout(){
        session_start();
        unset($_SESSION["usernameId"]);
        unset($_SESSION["level"]);
        //setcookie("username","",time()-1);
        $this->success="退出成功";
        $this->url="view/signin.html";
    }
    /*
     * 文件上传的方法
     */
    public function upload(){
        if(is_uploaded_file($_FILES["filename"]["tmp_name"])){
           // header("Content-type:image/jpg|jpeg");
            $encode = mb_detect_encoding($_FILES["filename"]["name"],array("UTF-8","GBK","GB2312","ASCII","BIG5"));
            $path="html/up/".$_FILES["filename"]["name"];
            iconv($encode, "UTF-8", $path);
            move_uploaded_file(//将文件从临时区域移动到目标地址
                $_FILES["filename"]["tmp_name"], //临时文件地址
                $path);//目标保存地址          
                //echo $c;
                return $path;
        }else{
            return false;
        }
        
    }
}

?>