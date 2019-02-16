<?php
  include("data/DBConfig.php");
  include_once("data/sessioncheck.php");

?>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tenaui+ | Contacts</title>
    <link href="<?php echo $host;?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/animate.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/style.css" rel="stylesheet">

</head>

<body>
<?php include("includes/header.php");?>

    <div id="wrapper">
   <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-9">
                    <h2>Contacts</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo  $host;?>">Home</a>
                        </li>
                        
                        <li class="active">
                            <strong>Members of Staff</strong>
                        </li>
                    </ol>
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
        

        <div class="row">

        <?php
                $myCount = 3;

                $admins = $database->getAllAdmins();
                foreach ($admins as $admin) {
                $link = $host."profile/".$admin['id'];
         ?>
          <?php if($myCount % 3 == 0){?>
          <?php if(($myCount % 3 == 0) && $myCount != 3){?>
          </div>
        <?php }?>
          <div class="row">
        <?php }?>
           
        <div class="col-lg-4">
                <div class="contact-box">
                    <a href="<?php echo $host;?>user-profile.php?id=<?php echo $admin['id'];?>">
                    <div class="col-sm-4">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="<?php echo $host;?>img/profile_img/small-<?php echo $admin['avartar'];?>">
                            <div class="m-t-xs font-bold"><?php echo $admin['designation'];?></div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h3><strong><?php echo  ucwords(strtolower($admin['fullname']));?></strong></h3>
                        <p><i class="fa fa-envelope-open-o"></i> &nbsp;<?php echo $admin['email'];?></p>
                        <address>
                            <strong><abbr title="Phone">P:</abbr> <?php echo $admin['phoneNo'];?></strong><br>
                            
                            
                        </address>

                    </div>
                    <div class="clearfix"></div>
                        </a>
                </div>
            </div> 


             <?php $myCount++; }?>  


        </div>


        </div>
        

        </div>
        </div>

    <!-- Mainly scripts -->
    <script src="<?php echo $host;?>js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo $host;?>js/bootstrap.min.js"></script>
    <script src="<?php echo $host;?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $host;?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo $host;?>js/inspinia.js"></script>
    <script src="<?php echo $host;?>js/plugins/pace/pace.min.js"></script>


</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.7/contacts.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Feb 2017 09:12:41 GMT -->
</html>
