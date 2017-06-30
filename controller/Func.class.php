<?php
require_once 'model/DbUntil.class.php';
class Func
{
    var $db;
    var $sql_fenye;
    var $id;
    public function __construct(){
        $this->db=new DbUntil("xukexitong");
    }

    public function q_student(){
        $sql="select a.user_id, usernameId,password,level from `tb_user` as a join `tb_level` as b on a.usernameId=b.user_id where level=3 ";
        $arr=$this->db->search($sql,array(), $con);
        $json=json_encode($arr);
        echo $json;
    }
    public function fenye(){
        $cur_page=$_GET["cur"];$row=$_GET["row"];
        $this->sql_fenye="select u.usernameId,z.studentName,z.studentSex,z.studentBirthday,d.departmentName,m.majorName,z.politicalStatus,z.stu_id 
            from tb_student as z 
            join tb_user as u on z.studentNum=u.user_id 
            join tb_department as d on z.departmentNum=d.dept_id 
            join tb_major as m on z.majorNum=m.major_id order by u.usernameId";
        //先分页，返回总页数
        $arr1=$this->db->countPages($this->sql_fenye, $row);
        //计算总条数
        $arr2=$arr2=$this->db->countRow($this->sql_fenye);
        //再差那一页有多少条，返回查询结果
        $arr3=$this->db->TongFen($this->sql_fenye, $cur_page, $row);
        $arr=array();
        array_push($arr,$arr1,$arr2,$arr3,$cur_page);
        $json=json_encode($arr);
        echo $json;
    }
    public function edit(){
        $this->id=$_GET["id"];
        session_start();
        $_SESSION["id"]=$_GET["id"];
       /*  $sql1=$this->sql_fenye;
        $sql=$sql."where z.usernameId=?"; */
        $sql1="select u.usernameId,z.studentName,z.studentSex,z.studentBirthday,d.departmentName,m.majorName,z.politicalStatus 
            from tb_student as z 
            join tb_user as u on z.studentNum=u.user_id 
            join tb_department as d on z.departmentNum=d.dept_id 
            join tb_major as m on z.majorNum=m.major_id where z.stu_id=?";
        $arr1=$this->db->search($sql1,array($this->id), $con);
        $sql2="select dept_id,major_id 
            from tb_student as s 
            join tb_department as d on s.departmentNum=d.dept_id 
            join tb_major as m on s.majorNum=m.major_id 
            
            where stu_id=?";
        $arr2=$this->db->search($sql2,array($this->id), $con);
        $arr=array($arr1,$arr2);
        $json=json_encode($arr);
        echo $json;
    }
    public function s_update(){
       // echo 'aa';
       session_start();
       $id=$_SESSION["id"];
        if(isset($_POST["usernameId"])){
          try {  
            $usernameId=$_POST["usernameId"];
            $studentName=$_POST["studentName"];
            $studentSex=$_POST["studentSex"];
            $studentBirthday=$_POST["studentBirthday"];
            $departmentName=$_POST["departmentName"];
            $majorName=$_POST["majorName"];
            $politicalStatus=$_POST["politicalStatus"];
            $sql="UPDATE `tb_student` 
                SET `studentName` = ?, `studentSex` = ?, `studentBirthday` = ?, `departmentNum` = ?, `majorNum` = ?, `politicalStatus` = ? 
                WHERE `stu_id` = ?";
            $this->db->addDelUpd($sql, 
                array($studentName,$studentSex,$studentBirthday,
                    $departmentName,$majorName,$politicalStatus,$id), $con);
            header("location:view/Node/index.html");
          }catch (Exception $e){
              echo $e->getMessage();
          } 
        }
    }
    public function DeptMaj(){
        $sql1="SELECT dept_id,departmentName from tb_department";
        $arr1=$this->db->search($sql1,array(), $con);
        $sql2="SELECT major_id,majorName from tb_major";
        $arr2=$this->db->search($sql2,array(), $con);
        $arr=array($arr1,$arr2);
        $json=json_encode($arr);
        echo $json;
    }
    public function xuanke_search(){
        $cur_page=$_GET["cur"];$row=$_GET["row"];
        $sql="select u.usernameId,s.studentName,count(c.studentName),s.stu_id from tb_user as u join tb_student as s on s.studentNum=u.user_id join tb_chagecourse as c on c.studentName =s.stu_id group by c.studentName ";
        //$this->db->search($sql);
        //先分页，返回总页数
        $arr1=$this->db->countPages($sql, $row);
        //计算总条数
        $arr2=$arr2=$this->db->countRow($sql);
        //再差那一页有多少条，返回查询结果
        $arr3=$this->db->TongFen($sql, $cur_page, $row);
        $arr=array();
        array_push($arr,$arr1,$arr2,$arr3,$cur_page);
        $json=json_encode($arr);
        echo $json;
    }
    public function course(){
        session_start();
        if(isset($_GET['id'])){
          $id=$_GET['id'];
          $_SESSION['stu_id']=$id;
        }else{
           $id=$_SESSION['stu_id']; 
        }
        
        //$id=$_SESSION['stu_id'];
        $sql1="select c.courseName,t.teacherName,c.credit,c.courseTime,ch.change_id from tb_chagecourse as ch join tb_student as s on ch.studentName=s.stu_id join tb_course as c on ch.courseName=c.course_id join tb_teacher as t on ch.teacherName=t.teacher_id
            where s.stu_id=?";
        $sql2="select c.courseName,t.teacherName,c.course_id,t.teacher_id from tb_course as c join tb_teacher as t on c.teacherName=t.teacher_id";
        $arr1=$this->db->search($sql1,array($id), $con);
        $arr2=$this->db->search($sql2,array(), $con);
        $arr=array($arr1,$arr2);
        $json=json_encode($arr);
        echo $json;
    }
    public function course2(){
        if(isset($_GET['id'])){
           
            $id=$_GET['id'];
            $_SESSION['stu_id']=$id;
        }else{
           
            $id=$_SESSION['stu_id'];
        }
         $sql1="select c.courseName,t.teacherName,c.credit,c.courseTime,ch.change_id from tb_chagecourse as ch join tb_student as s on ch.studentName=s.stu_id join tb_course as c on ch.courseName=c.course_id join tb_teacher as t on ch.teacherName=t.teacher_id
            where s.stu_id=?";
        $sql2="select c.courseName,t.teacherName,c.course_id,t.teacher_id from tb_course as c join tb_teacher as t on c.teacherName=t.teacher_id";
        $arr1=$this->db->search($sql1,array($id), $con);
        $arr2=$this->db->search($sql2,array(), $con);
        $arr=array($arr1,$arr2);
        $json=json_encode($arr); 
        echo $json;
    }
    public function addCourse(){
        session_start();
        $stu_id=$_SESSION["stu_id"];
        
        $courseName=$_GET["courseName"];
        $teacherName=$_GET["teacherName"];
        $sql="INSERT INTO `xukexitong`.`tb_chagecourse` ( `studentName`, `courseName`, `teacherName`) VALUES (?,?,?);";
        $this->db->addDelUpd($sql, array($stu_id,$courseName,$teacherName), $con);
        // if($con){
            $this->course2();
           // header("view/Role/course.html");
       // } 
       
    }

    public function delCour(){
        $change_id=$_GET["change_id"];
        $sql="DELETE FROM `xukexitong`.`tb_chagecourse` WHERE `tb_chagecourse`.`change_id` = ?";
        $this->db->addDelUpd($sql, array($change_id), $con);
        return $con;
    }
    
    public function addStudentNum(){
        if(isset($_GET["studentNum"])){
            $studentNum=$_GET["studentNum"];
            $sql1="INSERT INTO `tb_level` (`user_id`, `level`) VALUES (?, '3');";
            $this->db->addDelUpd($sql1, array($studentNum), $con);
            $sql2="INSERT INTO `xukexitong`.`tb_user` (`usernameId`, `password`) VALUES (?,?);";
           
            if($con){
                $password=$_GET["password"];
                $this->db->addDelUpd($sql2,array($studentNum,$password), $con);
                echo $con;
            };
        }
    }
    
    public function addSmessage(){
        if(isset($_POST["studentName"])){
            $studentNum=$_POST["studentNum"];
            $studentName=$_POST["studentName"];
            $sex=$_POST["sex"];
            $departmentName=$_POST["departmentName"];
            $majorName=$_POST["majorName"];
            $birthday=$_POST["birthday"];
            $politicalStatus=$_POST["politicalStatus"];
            $sql1="select user_id from tb_user where usernameId=?";
            $arr=$this->db->search($sql1,array($studentNum), $con);
           
            
            $sql="INSERT INTO `tb_student`(`studentNum`,`studentName`,`studentSex`,`studentBirthday`,`departmentNum`,`majorNum`,`politicalStatus`) VALUES (?,?,?,?,?,?,?)";
            $this->db->addDelUpd($sql, array($arr[0][0],$studentName,$sex,$birthday,$departmentName,$majorName,$politicalStatus), $con1);
           
            if($con1){
               // print_r(array($arr[0][0],$studentName,$sex,$birthday,$departmentName,$majorName,$politicalStatus));
                header("location:view/Role/add.html");
            } 
        }
        
    }
    
    //教师管理
    public function teacher_search(){
        $cur_page=$_GET["cur"];$row=$_GET["row"];
        $sql="select u.usernameId,t.teacherName,t.teacherSex,d.departmentName,teacherBirthday,teacherTitle,teacher_id from tb_teacher as t join tb_user as u on t.teacherNum=u.user_id join tb_department as d on t.departmentNum=d.dept_id";
        //$this->db->search($sql);
        //先分页，返回总页数
        $arr1=$this->db->countPages($sql, $row);
        //计算总条数
        $arr2=$arr2=$this->db->countRow($sql);
        //再差那一页有多少条，返回查询结果
        $arr3=$this->db->TongFen($sql, $cur_page, $row);
        $arr=array();
        array_push($arr,$arr1,$arr2,$arr3,$cur_page);
        $json=json_encode($arr);
        echo $json;
    }
    
    public function teacher_xinxi(){
        $id=$_GET["id"];
        session_start();
        $_SESSION["teacher_id"]=$id;
        $sql1="select u.usernameId,t.teacherName,t.teacherSex,d.departmentName,teacherBirthday,teacherTitle,teacher_id 
            from tb_teacher as t join tb_user as u on t.teacherNum=u.user_id join tb_department as d on t.departmentNum=d.dept_id 
            where teacher_id=?";
        $arr1=$this->db->search($sql1,array($id), $con);
        $sql2="SELECT dept_id,departmentName from tb_department";
        $arr2=$this->db->search($sql2,array(), $con);
        $arr=array($arr1,$arr2);
        $json=json_encode($arr); 
        echo $json;
        
    }
    public function updateTeacher(){
        session_start();
        $id=$_SESSION["id"];
        if(isset($_POST["teacherNum"])){
            $teacherNum=$_POST["teacherNum"];
            $teacherName=$_POST["teacherName"];
            $sex=$_POST["sex"];
            $birthday=$_POST["birthday"];
            $departmentName=$_POST["departmentName"];
            $title=$_POST["title"];
            $sql="UPDATE `tb_teacher`
            SET `teacherName` = ?, `teacherSex` = ?, `teacherBirthday` = ?, `departmentNum` = ?,`teacherTitle`= ?
            WHERE `teacher_id` = ?";
            $this->db->addDelUpd($sql,
                array($teacherName,$sex,
                    $departmentName,$birthday,$title,$id), $con);
            if($con==0){
                echo'操作失败';
            }
            header("location:view/Menu/edit.html");
        }
    }
    
    public function addTeacherNum(){
        if(isset($_GET["teacherNum"])){
            $studentNum=$_GET["teacherNum"];
            $sql1="INSERT INTO `tb_level` (`user_id`, `level`) VALUES (?, '2');";
            $this->db->addDelUpd($sql1, array($studentNum), $con);
            $sql2="INSERT INTO `xukexitong`.`tb_user` (`usernameId`, `password`) VALUES (?,?);";
             
            if($con){
                $password=$_GET["password"];
                $this->db->addDelUpd($sql2,array($studentNum,$password), $con);
                echo $con;
            };
        }
    }
    
    public function addTmessage(){
        if(isset($_POST["teacherName"])){
            $teacherNum=$_POST["teacherNum"];
            $teacherName=$_POST["teacherName"];
            $sex=$_POST["sex"];
            $departmentName=$_POST["departmentName"];
            //$majorName=$_POST["majorName"];
            $birthday=$_POST["birthday"];
            $title=$_POST["title"];
            $sql1="select user_id from tb_user where usernameId=?";
            $arr=$this->db->search($sql1,array($teacherNum), $con);
            $sql="INSERT INTO `xukexitong`.`tb_teacher` (`teacherNum`, `teacherName`, `teacherSex`, `departmentNum`, `teacherBirthday`, `teacherTitle`) VALUES (?,?,?,?,?,?);";
            $this->db->addDelUpd($sql, array($arr[0][0],$teacherName,$sex,$departmentName,$birthday,$title), $con1);
             
            if($con1){
                header("location:view/Role/add.html");
            }
        }
    
    }
    
    //课程管理
    public function search_course(){
        $sql="select c.course_id,c.courseName,t.teacherName,c.credit,c.courseTime,c.courseAction,t.teacher_id 
            from tb_course as c join tb_teacher as t on t.teacher_id=c.teacherName";
        $arr=$this->db->search($sql,array(), $con);
        $json=json_encode($arr);
        echo $json;
    }
    
    public function course_xinxi(){
        $id=$_GET["id"];
        session_start();
        $_SESSION["course_id"]=$id;
        $sql1="select c.course_id,c.courseName,t.teacherName,c.credit,c.courseTime,c.courseAction,t.teacher_id 
            from tb_course as c join tb_teacher as t on t.teacher_id=c.teacherName
            where course_id=?";
        $arr1=$this->db->search($sql1,array($id), $con);
        $sql2="SELECT teacher_id,teacherName from tb_teacher";
        $arr2=$this->db->search($sql2,array(), $con);
        $arr=array($arr1,$arr2);
        $json=json_encode($arr);
        echo $json;
    }
    
    public function course_update(){
            session_start();
            $id=$_SESSION["course_id"];
            if(isset($_POST["course_id"])){
                $courseName=$_POST["courseName"];
                $teacherName=$_POST["teacherName"];
                $credit=$_POST["credit"];
                $courseTime=$_POST["courseTime"];
                $sql="UPDATE `xukexitong`.`tb_course` 
                    SET `courseName` = ?, `teacherName`=?,`credit` = ? ,`courseTime`=?
                    WHERE `tb_course`.`course_id` = ?;";
                $this->db->addDelUpd($sql,
                    array( $courseName,$teacherName,
                        $credit,$courseTime,$id), $con);
                if($con==0){
                    echo'操作失败';
                }else{
                    header("location:view/User/index.html");
                }
                
                //echo 'aa';
            }
    }
    
    public function teacher(){
        $sql="select teacher_id,teacherName from tb_teacher";
        $arr=$this->db->search($sql,array(), $con);
        $json=json_encode($arr);
        echo $json;
    }
    
    public function addkecheng(){
        if(isset($_POST["courseName"])){
            $courseName=$_POST["courseName"];
            $teacherName=$_POST["teacherName"];
            $credit=$_POST["credit"];
            $courseTime=$_POST["courseTime"];
            $sql="INSERT INTO `xukexitong`.`tb_course` (`courseName`, `teacherName`, `credit`, `courseTime`) 
                VALUES ( ?, ?, ?, ?);";
            $this->db->addDelUpd($sql, array($courseName,$teacherName,$credit,$courseTime), $con);
        }else{
            echo '123';
        }
    }
    
    //登录密码
    
    
    public function T_fenye($sql){
        $cur_page=$_GET["cur"];$row=$_GET["row"];
        $arr1=$this->db->countPages($sql, $row);
        //计算总条数
        $arr2=$this->db->countRow($sql);
        //再差那一页有多少条，返回查询结果
        $arr3=$this->db->TongFen($sql, $cur_page, $row);
        $arr=array();
        array_push($arr,$arr1,$arr2,$arr3,$cur_page);
        $json=json_encode($arr);
        echo $json;
    }
  //输入查询密码
    public function st_search(){
        if(strlen($_GET["Num"])>0){
            $Num=$_GET["Num"];
            if(isset($_GET["Num"])){
                $sql1="select l.user_id,t.teacherName,u.password,l.level
                from tb_user as u join tb_level as l on u.usernameId=l.user_id join tb_teacher as t on t.teacherNum=u.user_id where u.usernameId=?";
                $arr=$this->db->search($sql1,array($Num), $con);
                if($con==0){
                    $sql2="select l.user_id,s.studentName,u.password,l.level
                    from tb_user as u join tb_level as l on u.usernameId=l.user_id join tb_student as s on s.studentNum=u.user_id where u.usernameId=?";
                    $arr=$this->db->search($sql2,array($Num), $con1);
                    if($con1==0){
                        echo 2; 
                    }else{
                        $json=json_encode($arr);
                        echo $json;
                    }
                    
                }else{
                    $json=json_encode($arr);
                    echo $json;
                    die();
                }
            }
  
        }
        if(strlen($_GET["name"])){
            $name=$_GET["name"];
            $sql1="select l.user_id,t.teacherName,u.password,l.level
            from tb_user as u join tb_level as l on u.usernameId=l.user_id join tb_teacher as t on t.teacherNum=u.user_id where t.teacherName=?";
            $arr=$this->db->search($sql1,array($name), $con);
            if($con==0){
                $sql2="select l.user_id,s.studentName,u.password,l.level
                from tb_user as u join tb_level as l on u.usernameId=l.user_id join tb_student as s on s.studentNum=u.user_id where s.studentName=?";
                $arr=$this->db->search($sql2,array($name), $con1);
                if($con1!=0){
                    $json=json_encode($arr);
                    echo $json; 
                }else{
                    echo 2;
                }  
                
            }else{
                $json=json_encode($arr);
                echo $json;
            }
            
        }
        
    }
    
    //更改密码和权限
    public function st_update(){
        $_GET["password"];$_GET["id"];
        if(strlen($_GET["password"])>0){
            $password=$_GET["password"];
            $id=$_GET["id"];
            $sql="UPDATE `xukexitong`.`tb_user` SET `password` = ? WHERE `tb_user`.`usernameId` = ?;";
            $this->db->addDelUpd($sql, array($password,$id), $con);
            echo true;
        }else{
            echo false;
        }
    }
    
    public function s_mima(){
        $sql="select l.user_id,s.studentName,u.password,l.level 
            from tb_user as u join tb_level as l on u.usernameId=l.user_id join tb_student as s on s.studentNum=u.user_id where l.level=3";
        $this->T_fenye($sql);
    }
    
    public function t_mima(){
        $sql="select l.user_id,t.teacherName,u.password,l.level 
            from tb_user as u join tb_level as l on u.usernameId=l.user_id join tb_teacher as t on t.teacherNum=u.user_id where l.level=2";
        $this->T_fenye($sql);
    }
    
    //学生系统
    
    public function sel_course(){
        session_start();
        $usernameId=$_SESSION["usernameId"];
        $courseId=$_GET["id"];
        $teacherid=$_GET["teacher"];
        $sql1="select s.stu_id from tb_student as s join tb_user as u on s.studentNum=u.user_id where u.usernameId=?";
        $arr=$this->db->search($sql1,array($usernameId) ,$con1);//查出学生编号
        
        $_SESSION["studentNumber"]=$arr[0][0];
        $sql3="select studentName,courseName from tb_chagecourse where studentName=? and courseName=?";//查出课程编号
        $arr3=$this->db->search($sql3,array($arr[0][0],$courseId), $con3);
       /*  $json=json_encode($arr3);
        echo $json; */
        if($con3!=0){
            echo 2;
        }else{
            $sql2="INSERT INTO `xukexitong`.`tb_chagecourse` (`studentName`, `courseName`,`teacherName`)
            VALUES (?,?,?);";
            $this->db->search($sql2,array($arr[0][0],$courseId,$teacherid), $con2);
            if($con2>0){
                $sql4="UPDATE `xukexitong`.`tb_course` SET `courseAction` = courseAction+1 WHERE `tb_course`.`course_id` =?;";
                $this->db->addDelUpd($sql4, array($courseId), $con);
                echo $con2;
            }
        } 
        
    }
    public function chakan_teacher(){
         $teacherid=$_GET["teacherid"];
        $sql="select u.usernameId,t.teacherName,t.teacherSex,d.departmentName,teacherBirthday,teacherTitle,t.introduce,teacher_id
            from tb_teacher as t join tb_user as u on t.teacherNum=u.user_id join tb_department as d on t.departmentNum=d.dept_id
            where t.teacher_id=?";
        $arr=$this->db->search($sql,array($teacherid), $con);
        $json=json_encode($arr);
        echo $json; 
    }
    public function geren_course(){
        session_start();
        $usernameId=$_SESSION["usernameId"];
        $sql1="select s.stu_id from tb_student as s join tb_user as u on s.studentNum=u.user_id where u.usernameId=?";
        $arr=$this->db->search($sql1,array($usernameId) ,$con1);//查出学生编号
        $_SESSION["studentNumber"]=$arr[0][0];
        $sql="SELECT c.course_id,c.courseName,t.teacherName,c.credit,c.courseTime,c.courseAction,t.teacher_id,ch.grades 
            from tb_course as c 
            join tb_teacher as t on t.teacher_id=c.teacherName join tb_chagecourse as ch on ch.courseName=c.course_id 
            where course_id in(select ch.courseName from tb_chagecourse as ch where ch.studentName=?) 
            group by c.course_id";
        $arr=$this->db->search($sql,array($arr[0][0]), $con);
        $json=json_encode($arr);
        echo $json;
    }
    
    public function delCourse(){
        session_start();
        if(isset($_SESSION["studentNumber"])){
            $stuId=$_SESSION["studentNumber"];
            $courseId=$_GET["id"];
           // $sql="SELECT courseName, count(courseName) from tb_chagecourse group by courseName";
            $sql="DELETE FROM `xukexitong`.`tb_chagecourse` WHERE `tb_chagecourse`.`studentName` = ? and courseName=?";
            $this->db->search($sql,array($stuId,$courseId), $con);
            
            if($con){
                $sql2="UPDATE `xukexitong`.`tb_course` SET `courseAction` = courseAction-1 WHERE `tb_course`.`course_id` =?;";
                $this->db->addDelUpd($sql2, array($courseId), $con);
                echo 1;
            }
        }
    }
    
    public function geren_information(){
        session_start();
        //echo $_SESSION["usernameId"];
          if(isset($_SESSION["usernameId"])){
            $usernameId=$_SESSION["usernameId"];
            $sql="select u.usernameId,z.studentName,z.studentSex,z.studentBirthday,d.departmentName,m.majorName,z.politicalStatus,z.stu_id 
            from tb_student as z 
            join tb_user as u on z.studentNum=u.user_id 
            join tb_department as d on z.departmentNum=d.dept_id 
            join tb_major as m on z.majorNum=m.major_id where u.usernameId=?";
            $arr=$this->db->search($sql,array($usernameId), $con);
            $json=json_encode($arr);
            echo $json;
        } 
    }
    
    public function geren_update(){
       $usernameId=$_POST["usernameId"];
       $studentName= $_POST["studentName"];
       $sex= $_POST["studentSex"];
       $birthday= $_POST["studentBirthday"];
       $politicalStatus= $_POST["politicalStatus"];
       $sql2="select s.stu_id from tb_student as s join tb_user as u on s.studentNum=u.user_id where u.usernameId=?";
       $arr=$this->db->search($sql2,array($usernameId), $con);
       $sql="UPDATE `xukexitong`.`tb_student` 
           SET `studentName` = ?, `studentSex` = ?, `studentBirthday` = ?, `politicalStatus` = ?
           WHERE `tb_student`.`stu_id` = ?;";
       $this->db->addDelUpd($sql,array($studentName,$sex,$birthday,$politicalStatus,$arr[0][0]), $con2);
       if($con2){
           header("location:view/student/information.html");
       }else{
           echo "请查看内容是否正确";
           header("refresh:3;url=view/student/update.html");
       } 
    }
    
    //教师系统
    public function renke(){
        session_start();
        $usernameId=$_SESSION["usernameId"];
        $sql1="select t.teacher_id from tb_teacher as t join tb_user as u on t.teacherNum=u.user_id where u.usernameId=?";
        $arr=$this->db->search($sql1,array($usernameId) ,$con1);//查出教师编号
        $_SESSION["studentNumber"]=$arr[0][0];
        $sql="SELECT c.course_id,c.courseName,t.teacherName,c.credit,c.courseTime,c.courseAction,t.teacher_id from tb_course as c join tb_teacher as t on t.teacher_id=c.teacherName 
            where c.teacherName=?";
        $arr=$this->db->search($sql,array($arr[0][0]), $con);
        $json=json_encode($arr);
        echo $json;
    }
    
    public function course_student(){
        session_start();
        $usernameId=$_SESSION["usernameId"];
        $sql="select s.studentName,c.courseName,t.teacherName,s.stu_id,ch.grades,ch.change_id from tb_chagecourse as ch 
            join tb_student as s on ch.studentName=s.stu_id 
            join tb_teacher as t on ch.teacherName=t.teacher_id  
            join tb_course as c on ch.courseName=c.course_id
            where t.teacher_id in
            (select teacher_id from tb_teacher join tb_user on tb_teacher.teacherNum=tb_user.user_id 
                        where tb_user.usernameId=?)
            order by c.courseName";
        $arr=$this->db->search($sql,array($usernameId), $con);
        $json=json_encode($arr);
        echo $json;
    }
    
    public function teacher_sXinxi(){
       $usernameId= $_GET["usernameId"];
        $sql="select u.usernameId,z.studentName,z.studentSex,z.studentBirthday,d.departmentName,m.majorName,z.politicalStatus,z.stu_id
            from tb_student as z
            join tb_user as u on z.studentNum=u.user_id
            join tb_department as d on z.departmentNum=d.dept_id
            join tb_major as m on z.majorNum=m.major_id where z.stu_id=?";
        $arr=$this->db->search($sql,array($usernameId), $con);
        $json=json_encode($arr);
        echo $json;
    }
      
    public function teacher_information(){
        session_start();
        $usernameId=$_SESSION["usernameId"];
        $sql="select u.usernameId,t.teacherName,t.teacherSex,d.departmentName,teacherBirthday,teacherTitle,t.introduce,teacher_id 
            from tb_teacher as t join tb_user as u on t.teacherNum=u.user_id join tb_department as d on t.departmentNum=d.dept_id
            where u.usernameId=?";
        $arr=$this->db->search($sql,array($usernameId), $con);
        $json=json_encode($arr);
        echo $json;
    }
    
    public function teacher_update(){
        $usernameId=$_GET["teacherid"];
        $sql="select u.usernameId,t.teacherName,t.teacherSex,d.departmentName,teacherBirthday,teacherTitle,t.introduce,teacher_id
            from tb_teacher as t join tb_user as u on t.teacherNum=u.user_id join tb_department as d on t.departmentNum=d.dept_id
            where u.usernameId=?";
        $arr=$this->db->search($sql,array($usernameId), $con);
        $json=json_encode($arr);
        echo $json;
        
    }
    
    public function teacher_xiugai(){
        session_start();
        $usernameId=$_SESSION["usernameId"];
        $sql1="select teacher_id from tb_teacher as t join tb_user as u on u.user_id=t.teacherNum where u.usernameId=?";
        $arr=$this->db->search($sql1,array($usernameId), $con);
        if($con){
            if(isset($_POST["teacherName"])){
                $teacherName=$_POST["teacherName"];
                $teacherSex=$_POST["teacherSex"];
                $teacherBirthday=$_POST["teacherBirthday"];
                $introduce=$_POST["introduce"];
                $sql2="UPDATE `xukexitong`.`tb_teacher` SET `teacherName` = ?, `teacherSex` = ?, `teacherBirthday` = ?, `introduce` = ?
                WHERE `tb_teacher`.`teacher_id` = ?;";
                $this->db->addDelUpd($sql2, array($teacherName,$teacherSex,$teacherBirthday,$introduce,$arr[0][0]), $con2);
                if($con2){
                    header("location:view/teacher/information.html");
                }else{
                    echo '修改失败';
                }
            }
            
        }
        
        
    }
    
    /* public function teacher_grades(){
        $sql="";
    } */
}

?>