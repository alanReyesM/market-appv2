<?php
  //step1. get database Access(llamar el acceso) 
    require('../config/database.php');

    //create or start session
    session_start();
    if(isset($_SESSION['session_user_id'])){
      header('refresh:0;url=index.php');
    }else{
      header('refresh:0;url=error_403.html');
    }
  //step2. get form-data
    $e_mail    = trim($_POST['email']);
    $p_wd      = trim($_POST['passwd']);      //contraseña
    
   //$enc_pass = password_hash($p_wd, PASSWORD_DEFAULT);
   /*jamas usar */$enc_pass = md5($p_wd);

    //step 3 query to validate data
    $sql_check_user = "
    select 
    u.id,
    u.firstname || ' ' || u.lastname as fullname,
	  u.email,
	  u.password,
    u.url_photo
    from users u where u.email = '$e_mail' and
    u.password = '$enc_pass'
    limit 1
    ";
//step 4. execute query 
    $res_check = pg_query($conn_local, $sql_check_user);
   
    $row=pg_fetch_assoc($res_check);
    $_SESSION['session_user_id']=$row['id'];
    $_SESSION['session_user_fulname']=$row['fullname'];
    $_SESSION['session_user_url_photo']=$row['url_photo'];


    if(pg_num_rows($res_check)>0){
      // echo "user exisrs. go to main page";
      header('refresh:0;url=index.php');
    } else {
        echo "verify data";
    }
    ?> 