<?php
  include("data/DBConfig.php");
  include_once("data/sessioncheck.php");

if($myData['changePass'] == 0){
    $database->redirect_to($host."change-password");
}
if(!isset($_GET['id'])){$database->redirect_to($host);}
$user_id = $_GET['id'];
$month = date('n');
$yr = date('Y');

$thisUser = $database->getMyUserInformation($user_id);

?>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tenaui+ User Profile</title>

    <link href="<?php echo $host;?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/animate.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/style.css" rel="stylesheet">
     <link href="<?php echo $host;?>css/plugins/footable/footable.core.css" rel="stylesheet">

</head>

<?php include("includes/header.php");?>

            
        <div class="wrapper wrapper-content animated fadeInRight">


            <div class="row m-b-lg m-t-lg">
                <div class="col-md-6">

                    <div class="profile-image">
                        <img src="<?php $host;?>img/profile_img/big-<?php echo $thisUser['avartar'];?>" class="img-circle circle-border m-b-md" alt="profile">
                    </div>
                    <div class="profile-info">
                        <div class="">
                            <div>
                                <h2 class="no-margins">
                                    <?php echo $thisUser['fullname'];?>
                                </h2>
                                <h4><?php echo $thisUser['designation'];?></h4>
                                <small>
                                   <!-- There are many variations of passages of Lorem Ipsum available, but the majority
                                    have suffered alteration in some form Ipsum available.-->
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <table class="table small m-b-xs">
                        <tbody>
                        <?php 
                        $n = 0;
                                $dpts = (array)$database->getSalesStagesPercentageOrder();
                                foreach ($dpts as $dpt) {
                         ?>

                        
                        <?php if ($n%2 == 0){ ?>
                        </tr><tr>
                        <?php }?>
                            <td>

                                <strong><?php echo $database->countMySalesStages($user_id,$dpt['percentage']);?></strong> 
                                <?php echo $dpt['stage'];?>
                            </td>
                           

                       

                    <?php $n++;}?>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3">
                    <small>Sales since joining, <?php echo $thisUser['resumeDate'];?></small>
                    <h2 class="no-margins"><?php 

                                $thismonths = (array)$database->getMyAllOrderCollected($user_id);
                                $thisMonthAmount_ = 0;
                               // if(is_array($thismonths)){
                                        foreach($thismonths as $thismonth) {
                                           $thisMonthAmount_ = $thisMonthAmount_ + $thismonth['Amount'];
                              //          }
                                }
                                $thismonths = (array)$database->getAllMPS($user_id);
                               // if(is_array($thismonths)){
                                        foreach($thismonths as $thismonth) {
                                           $thisMonthAmount_ = $thisMonthAmount_ + $thismonth['amount'];
                              //          }
                                }
                                    echo $database->convertToMoney($thisMonthAmount_);
                                   // $p = $database->calculatePercentage($thisMonthAmount_,$pTarget);
                                 
                                    
                                ?> </h2>
                    <div id="sparkline1"></div>
                </div>


            </div>
             <div class="row ibox float-e-margins ibox-content">
         <h1 class="font-bold m-b-xs"><?php echo $thisUser['fullname'];?> Monthly Sales</h1>
                                        <h3 class="font-bold no-margins">
                                            &nbsp;
                                        </h3>

                <?php 
                        $myCount = 3;
                        for ($i=1; $i < 13; $i++) {                                     

                ?>

                <?php if($myCount % 3 == 0){?>
                <?php if(($myCount % 3 == 0) && $myCount != 3){?>
                    </ul>
                  </div>
                <?php }?>
                 <div class="col-lg-3 ">
                      <ul class="stat-list">
                <?php }?>

                                        <li>
                                        <?php 
                                                    $thatMTarget =  $database->getUserMonthlyTarget($user_id,$i,$yr);
                                                     $monthName = date('F', mktime(0, 0, 0, $i, 10));            
                                                ?>
                                                 <small>Total orders in the month of <?php echo $monthName;?></small><br/>
                                            <h2 class="no-margins">


                                            <?php 
                                                 $thatmonths = (array)$database->getMonthlyOrderCollected($user_id,$i,$yr);
                                                 $thatMonthAmount_ = 0;
                                                  foreach($thatmonths as $thatmonth) {
                                                    $thatMonthAmount_ = $thatMonthAmount_ + $thatmonth['Amount'];
                                                   }
                                                    $thismonthsMps = (array)$database->getMonthlyMPS($user_id,$i,$yr);
                                                    if(count($thismonthMps > 0)){
                                                         foreach($thismonthsMps as $thismonth) {
                                                                   $thatMonthAmount_ = $thatMonthAmount_ + $thismonth['amount'];
                                                              }
                                                     }
                                                 echo $database->convertToMoney($thatMonthAmount_);

                                                 $pctn = $database->calculatePercentage($thatMonthAmount_,$thatMTarget); 
                                                
                                                
                                            ?> 
                                            </h2>
                                           
                                           
                                            <small><?php echo $monthName;?> Target : <b><?php  echo $database->convertToMoney($thatMTarget);?></b></small><br/>
                                            <div class="stat-percent"><?php echo $pctn;?>% <!--<i class="fa fa-level-up text-navy"></i>--></div>
                                            <div class="progress progress-striped active">
                                                <div style="width: <?php echo $pctn;?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $pctn;?>" role="progressbar" class="progress-bar progress-bar-<?php echo $database->returnSalesStageColor($pctn);?>">
                                                    <span class="sr-only"><?php echo $pctn;?>% Complete (success)</span>
                                                </div>
                                            </div>

                                           <!-- <div class="progress progress">
                                                <div style="width: <?php echo $pctn;?>%;" class="progress-bar "></div>
                                            </div>-->
                                        </li>

                                         <?php $myCount++; }?>  
                                        
                    </div>
                    <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Orders Collected for <?php echo $thisUser['fullname'];?> </h5>

                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">

                            <table class="footable table table-stripped toggle-arrow-tiny">
                                <thead>
                                <tr>

                                    <th data-toggle="true">Lead</th>
                                    <th>Ticket</th>
                                    <th>Amount</th>
                                    <th data-hide="all">Items</th>
                                    <th data-hide="all">Completed</th>
                                    
                                    <th>Date</th>
                                    <th>Order</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php 
                                    $orders = (array)$database->getMyAllOrderCollected($user_id);
                                    foreach ($orders as $order) {

                                        
                                ?>
                                <tr>
                                    <td><?php echo $order['companyName'];?></td>
                                    <td><?php echo $order['ticketNo'];?></td>
                                    <td><?php echo $database->convertToMoney($order['Amount']);?></td>
                                    <td>
                                    <?php 

                                $myBills = (array)$database->getLeadProductOrderOnLeadDemand($order['leadID'],$order['ticketID']);
                                foreach ($myBills as $myBill) {
                                            
                                    ?>
                                    <?php echo $myBill['productName']; ?>&nbsp;  ---  &nbsp;(<?php echo $myBill['qty']; ?>) &nbsp;  ---  &nbsp;<?php echo $myBill['Code'];?>&nbsp;  ---  &nbsp;<?php echo $database->convertToMoney($myBill['Amount']);?>&nbsp;  ---  &nbsp;<?php echo $database->convertToMoney($myBill['Amount'] * $myBill['qty']);?><br/>

                                    <?php }?>

                                    
                                    
                                    </td>
                                    <td><span class="pie">100/100</span></td>
                                   
                                    <td><?php echo $order['orderCollectedDate'];?></td>
                                    <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                                </tr>

                                <?php }?>
                                
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

                    <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                    <div>
                                    
                                        <span class="pull-right text-right">
                                        <small>Average value of sales in the past months for: <strong><?php echo $yr;?></strong></small>
                                            <br/>
                                            <!--Best Sales: 162,862-->
                                        </span>
                                        <h1 class="m-b-xs"> <?php 

                                $thismonths = (array)$database->getYearlyOrderCollected($user_id,$yr);
                                $amount_ = 0;
                               // if(is_array($thismonths)){
                                        foreach($thismonths as $thismonth) {
                                           $amount_ = $amount_ + $thismonth['Amount'];
                              //          }
                                }
                                    echo $database->convertToMoney($amount_);
                                     //$p = $database->calculatePercentage($amount_,$yTarget);
                                    
                                ?> </h1>
                                        <h3 class="font-bold no-margins">
                                            Half-year revenue margin
                                        </h3>
                                        <small>Sales marketing.</small>
                                       <!-- <div class="pull-right">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-xs btn-white active">Today</button>
                                                <button type="button" class="btn btn-xs btn-white">Monthly</button>
                                                <button type="button" class="btn btn-xs btn-white">Annual</button>
                                            </div>
                                        </div>-->
                                    </div>

                                <div>
                                    <canvas id="lineChart" height="100"></canvas>
                                </div>

                                <div class="m-t-md">
                                    <small class="pull-right">
                                        <i class="fa fa-clock-o"> </i>
                                        Update on <?php echo date("d.M.Y");?>
                                    </small>
                                   <small>
                                       <strong>Analysis of sales:</strong> The value of this graph depends solely on information supplied by sales team.
                                   </small>
                                </div>

                            </div>
                        </div>
                    </div>
</div>


            

        </div>
        

        </div>
        </div>



    <!-- Mainly scripts -->
    <script src="<?php echo $host;?>js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo $host;?>js/bootstrap.js"></script>
    <script src="<?php echo $host;?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $host;?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo $host;?>js/inspinia.js"></script>
    <script src="<?php echo $host;?>js/plugins/pace/pace.min.js"></script>

    <!-- Sparkline -->
    <script src="<?php echo $host;?>js/plugins/sparkline/jquery.sparkline.min.js"></script>
     <script src="<?php echo $host;?>js/plugins/peity/jquery.peity.min.js"></script>
    <script src="<?php echo $host;?>js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo $host;?>js/inspinia.js"></script>
    <script src="<?php echo $host;?>js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="<?php echo $host;?>js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- FooTable -->
    <script src="<?php echo $host;?>js/plugins/footable/footable.all.min.js"></script>


    <!-- Jvectormap -->
    <script src="<?php echo $host;?>js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="<?php echo $host;?>js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- Sparkline -->
    <script src="<?php echo $host;?>js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="<?php echo $host;?>js/demo/sparkline-demo.js"></script>

    <!-- ChartJS-->
    <script src="<?php echo $host;?>js/plugins/chartJs/Chart.min.js"></script>

<script>
        $(document).ready(function() {

            $('.footable').footable();
            $('.footable2').footable();

        });

    </script>
    <script>
        $(document).ready(function() {


            $("#sparkline1").sparkline([34, 43, 43, 35, 44, 32, 44, 48], {
                type: 'line',
                width: '100%',
                height: '50',
                lineColor: '#1ab394',
                fillColor: "transparent"
            });


        });
    </script>
    <script>
        $(document).ready(function() {

            var lineData = {
                labels: [
                            <?php 
                            for ($i=1; $i < 13; $i++) { 
                                 echo '"'.date('F', mktime(0, 0, 0, $i, 10)).'",';                               
                            }?>
                ],
                datasets: [
                    {
                        label: "Sales",
                        backgroundColor: "rgba(26,179,148,0.5)",
                        borderColor: "rgba(26,179,148,0.7)",
                        pointBackgroundColor: "rgba(26,179,148,1)",
                        pointBorderColor: "#fff",
                        data: 
                        [
                            <?php 
                                 for ($i=1; $i < date('m')+1; $i++) { 
                                 echo $database->getUserSumMonthlySales($user_id,$i,$yr).",";                               
                            }?>


                        ]
                    },
                    {
                        label: "Target",
                        backgroundColor: "rgba(220,220,220,0.5)",
                        borderColor: "rgba(220,220,220,1)",
                        pointBackgroundColor: "rgba(220,220,220,1)",
                        pointBorderColor: "#fff",
                        data: [
                                 <?php 
                                 for ($i=1; $i < date('m')+1; $i++) { 
                                     echo $database->getUserMonthlyTarget($user_id,$i,$yr).",";                               
                                  }
                                  ?>

                        ]
                    }

                ]
            };

            var lineOptions = {
                responsive: true
            };


            var ctx = document.getElementById("lineChart").getContext("2d");
            new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});

        });
    </script>

</body>

</html>
