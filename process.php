<?php 
require_once('dbconnect.php');
session_start();
    if(isset($_POST['Login']))
    {
       if(empty($_POST['username']) || empty($_POST['password']))
       {
            header("location:index.html");
       }
       else
       {
            $sql = "SELECT Role FROM users where Email_ID='".$_POST['username']."'";
            $result = $conn->query($sql);
            $_SESSION['User']=$_POST['username'];
            if(mysqli_num_rows($result)>0)
            {
                while($row=mysqli_fetch_assoc($result))
                {
                    $role = $row["Role"];
                }
            }
            else
            {
                header("location:index.html");
            }
            if($role=="user")
            {
                header("location:users.php");
            }
            elseif($role=="admin")
            {
               header("location:admin.php");
            }
        }
    }
?>