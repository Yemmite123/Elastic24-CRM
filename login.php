<?php include("data/DBConfig.php");?>
<?php
$url = "";
    if(isset($_GET['url'])){
        $url = $_GET['url'];
    }else{
        $url = $host;
    }
if(isset($_SESSION['user_id'])){
        $database->redirect_to($url);
      }
 ?>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tenaui | Login</title>

    <link href="<?php echo $host;?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/animate.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>

            <?php 
            $err = "";
            
                if(isset($_POST['btnLogin'])){
                       $username = $database->test_input($_POST['txtUsername']);
                       $password = $database->test_input($_POST['txtPassword']);

                       if($username != "" && $password != ""){
                            $login = (array)$database->authenticateStaff($username,$password);
                            if($login[0] == 0){
                                    $err = 'invalid username or password';
                                }else if($login[0] > 0){
                                        if($login[1] == 0){
                                            $err = "your account is deactivated";
                                        }else {
                                                $_SESSION['user_id'] = $login[0];
                                                setcookie("i_am2309384384304302349438933", $_SESSION['user_id'], time() + (86400),"/");
                                                $database->redirect_to($url);
                                        }
                                }



                       }else{
                            if($username == ""){$err.= "enter username";}
                            if($password == ""){$err.= "enter password";}
                       }
                }


            ?>
            
            <h3>Welcome to Tenaui+</h3>
            <p>Perfectly designed and precisely prepared to meet your needs
            </p>
            <p>Login in. To see it in action.</p>

            <?php if($err!= ""){$database->showMsg('Error', $err,1);}?>
            
            <form class="m-t" role="form" action="" method="post">
                <div class="form-group">
                    <input type="text" name="txtUsername" class="form-control" placeholder="Username" value="<?php if(isset($_POST['txtUsername'])){echo $_POST['txtUsername'];}?>" required>
                </div>
                <div class="form-group">
                    <input type="password" name="txtPassword" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" name="btnLogin" class="btn btn-primary block full-width m-b">Login</button>

               
                <a class="btn btn-sm btn-white btn-block" href="<?php echo $host;?>forgotpassword">Forgot password?</a>
            </form>
            <p class="m-t"> <small>Tenaui+ CRM &copy; <?php echo date('Y');?></small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>
