<?php
  include("data/DBConfig.php");
  include_once("data/sessioncheck.php");

?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tenaui + | Mailbox</title>

    <link href="<?php echo $host;?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/animate.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/style.css" rel="stylesheet">

</head>

<body>

   <?php include("includes/header.php"); ?>

        <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content mailbox-content">
                     
                     <?php include('includes/mailinfo.php');?>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 animated fadeInRight">
            <div class="mail-box-header">

                <form method="get" action="" class="pull-right mail-search">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm" name="search" placeholder="Search email">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary">
                                Search
                            </button>
                        </div>
                    </div>
                </form>
                <h2>
                    Inbox (<?php echo $database->countTotalMessages($myData['id']);?>)
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
                    <div class="btn-group pull-right">
                        <button class="btn btn-white btn-sm"><i class="fa fa-arrow-left"></i></button>
                        <button class="btn btn-white btn-sm"><i class="fa fa-arrow-right"></i></button>

                    </div>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="left" title="Refresh inbox"><i class="fa fa-refresh"></i> Refresh</button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as read"><i class="fa fa-eye"></i> </button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as important"><i class="fa fa-exclamation"></i> </button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>

                </div>
            </div>
                <div class="mail-box">

                <table class="table table-hover table-mail">
                <tbody>

                <?php 
                        $msgs = (array)$database->getMyInbox($myData['id']);
                        foreach ($msgs as $msg) {
                            $read = "";
                         if($msg['read'] == 1){$read = 'read';}else{$read = 'unread';}
                         $link = $host.'mail-details/'.$msg['id'];
                ?>

                <tr class="<?php echo $read;?>">
                    <td class="check-mail">
                        <input type="checkbox" class="i-checks">
                    </td>
                    <td class="mail-ontact"><a href="<?php echo $link;?>"><?php echo $msg['senderName'];?> <!--<span class="label label-warning pull-right">Clients</span>--></a></td>
                    <td class="mail-subject"><a href="<?php echo $link;?>"><?php echo substr($msg['subject'], 0, 52) ;?></a></td>
                    <td class=""><i class="fa fa-clock"></i><?php echo $msg['date'] ;?></td>
                    <td class="text-right mail-date"><?php echo $database->time_elapsed_string($msg['timestamp']);?></td>
                </tr>

                <?php }?>
                
                </tbody>
                </table>


                </div>
            </div>
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

    <!-- iCheck -->
    <script src="<?php echo $host;?>js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
</body>
</html>
