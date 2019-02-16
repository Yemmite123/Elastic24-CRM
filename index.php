<?php
  include("data/DBConfig.php");
  include_once("data/sessioncheck.php");

if($myData['changePass'] == 0){
    $database->redirect_to($host."change-password");
}
$month = date('n');
$yr = date('Y');

?>


<script src="<?php echo $host;?>amcharts/amcharts.js" type="text/javascript"></script>
 <script src="<?php echo $host;?>amcharts/funnel.js" type="text/javascript"></script>
<script>
var chart = AmCharts.makeChart( "chartdiv", {
  "type": "funnel",
  "theme": "light",
  "dataProvider": [ <?php
                $dpts = (array)$database->getSalesStagesPercentageOrder();
                foreach ($dpts as $dpt) {
            ?>
                {
                    "title": "<?php echo $dpt['stage'];?>",
                    "value": <?php echo $database->countMySalesStages($myData['id'],$dpt['percentage']);?>
                },

            <?php } ?>],
  "balloon": {
    "fixedPosition": true
  },
  "valueField": "value",
  "titleField": "title",
  "marginRight": 240,
  "marginLeft": 50,
  "startX": -500,
  "depth3D": 100,
  "angle": 40,
  "outlineAlpha": 1,
  "outlineColor": "#FFFFFF",
  "outlineThickness": 2,
  "labelPosition": "right",
  "balloonText": "[[title]]: [[value]] leads [[description]]",
  "export": {
    "enabled": true
  }
} );
</script>



<!DOCTYPE HTML>
<html>
<head>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenaui+ :: CRM for Tenaui</title>
    <?php include("includes/styles.php");?>
</head>

<?php include("includes/header.php");?>

  <div class="wrapper wrapper-content">
        <div class="row">
         <h2>Welcome, <?php echo ucwords(strtolower($myData['fullname']));?></h2>
         <div class="row">
                  <div class="col-lg-9" id="chartdiv" style="width: 520px; height:320px;"></div>

                  <?php
                       if($myData['AccessLevel'] > 3){
                  ?>
                  <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-success pull-right">Total</span>
                                <h5>All Leads</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $all_leads = sizeof($database->getAllLeads());?></h1>
                                <!--<div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>-->
                                <small>Total number of leads</small>

                            </div>
                        </div>
                    </div>

                    <?php }?>
                     <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-warning pull-right">Leads</span>
                                <h5>Your Active Leads</h5>
                            </div>

                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $my_leads = sizeof($database->getMyLeads($myData['id'],1));?></h1>
                                <div class="stat-percent font-bold text-success">

                                </div>
                                <small><?php echo $my_leads = sizeof($database->getMyLeads($myData['id'],2));?> Suspects
                                 <?php echo $my_leads = sizeof($database->getMyLeads($myData['id'],3));?> Prospects</small>

                            </div>
                        </div>
                    </div>
                    <!--- -->
                     <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-primary pull-right">Month of <?php echo date('F');?></span>
                        <h5>Your Sales Target and Achievement</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-md-6">
                                <h1 class="no-margins"><?php
                                $pTarget =  $database->getUserMonthlyTarget($myData['id'],$month,$yr);
                                 echo $database->convertToMoney($pTarget);

                                ?></h1>
                                <div class="font-bold text-navy"><i class="fa fa-level-up"></i> <small>Target</small></div>
                            </div>
                            <div class="col-md-6">
                                <h1 class="no-margins">
                                <?php

                                $thismonths = (array)$database->getMonthlyOrderCollected($myData['id'],$month,$yr);
                                $thisMonthAmount_ = 0;
                               // if(is_array($thismonths)){
                                        foreach($thismonths as $thismonth) {
                                           $thisMonthAmount_ = $thisMonthAmount_ + $thismonth['Amount'];
                              //          }
                                }
                                $thismonthsMps = (array)$database->getMonthlyMPS($myData['id'],$month,$yr);
                                 foreach($thismonthsMps as $thismonth) {
                                           $thisMonthAmount_ = $thisMonthAmount_ + $thismonth['amount'];
                                      }


                                    echo $database->convertToMoney($thisMonthAmount_);
                                    $p = $database->calculatePercentage($thisMonthAmount_,$pTarget);


                                ?> </h1>
                                <div class="stat-percent font-bold text-<?php echo $database->returnSalesStageColor($p);?>"><?php echo $p;?>% <i class="fa fa-bolt"></i></div>
                                <small>Total income for this month</small>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            </div>
            <div class="row">
               <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-info pull-right">Annual - <?php echo date('Y');?></span>
                        <h5>Your Sales Target and Achievement</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-md-6">
                                <h1 class="no-margins">
                                <?php

                                $yTarget =  $database->getUserYearlyTarget($myData['id'],$yr);
                                 echo $database->convertToMoney($yTarget);

                                ?>

                                </h1>
                                <div class="font-bold text-navy"><i class="fa fa-level-up"></i> <small>Target</small></div>
                            </div>
                            <div class="col-md-6">
                                <h1 class="no-margins">
                                <?php

                                $thismonths = (array)$database->getYearlyOrderCollected($myData['id'],$yr);
                                $amount_ = 0;
                               // if(is_array($thismonths)){
                                        foreach($thismonths as $thismonth) {
                                           $amount_ = $amount_ + $thismonth['Amount'];
                              //          }
                                }
                                 $thismonths = (array)$database->getYearlyMPS($myData['id'],$yr);
                               // if(is_array($thismonths)){
                                        foreach($thismonths as $thismonth) {
                                           $amount_ = $amount_ + $thismonth['amount'];
                              //          }
                                }
                                    echo $database->convertToMoney($amount_);
                                     $p = $database->calculatePercentage($amount_,$yTarget);

                                ?> </h1>
                                <div class="stat-percent font-bold text-<?php echo $database->returnSalesStageColor($p);?>">
                                <?php echo $p;?>% <i class="fa fa-bolt"></i></div>
                                <small>Total income for this year</small>
                            </div>
                        </div>


                    </div>
                </div>
            </div><!-xxxx-->
               <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-primary pull-right">Since Resumption <?php echo $myData['resumeDate'];?></span>
                        <h5>Your Sales Target and Achievement</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-md-6">
                                <h1 class="no-margins"><?php
                                $pTarget =  $database->getUserAllCurrentTarget($myData['id']);
                                 echo $database->convertToMoney($pTarget);

                                ?></h1>
                                <div class="font-bold text-navy"><i class="fa fa-level-up"></i> <small>Target</small></div>
                            </div>
                            <div class="col-md-6">
                                <h1 class="no-margins">
                                <?php

                                $thismonths = (array)$database->getMyAllOrderCollected($myData['id']);
                                $thisMonthAmount_ = 0;
                               // if(is_array($thismonths)){
                                        foreach($thismonths as $thismonth) {
                                           $thisMonthAmount_ = $thisMonthAmount_ + $thismonth['Amount'];
                              //          }
                                }
                                $thismonths = (array)$database->getAllMPS($myData['id']);
                               // if(is_array($thismonths)){
                                        foreach($thismonths as $thismonth) {
                                           $thisMonthAmount_ = $thisMonthAmount_ + $thismonth['amount'];
                              //          }
                                }
                                    echo $database->convertToMoney($thisMonthAmount_);
                                    $p = $database->calculatePercentage($thisMonthAmount_,$pTarget);


                                ?> </h1>
                                <div class="stat-percent font-bold text-<?php echo $database->returnSalesStageColor($p);?>"><?php echo $p;?>% <i class="fa fa-bolt"></i></div>
                                <small>Total income for this month</small>
                            </div>
                        </div>


                    </div>
                </div>
            </div><!-xxxx-->

           </div>

                <?php

                        $thismonths = $database->getTeamMonthlyOrderCollected($month,$yr);
                        $thisMonthAmount_ = 0;
                         foreach($thismonths as $thismonth) {
                                   $thisMonthAmount_ = $thisMonthAmount_ + $thismonth['Amount'];
                        }

                        if($myData['AccessLevel'] > 3){

                ?>
                    <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-primary pull-right">Total Target for <?php echo date('F');?></span>
                        <h5>Sales team Target and Achievement</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-md-6">
                                <h1 class="no-margins">
                                <?php
                                        $teamTarget =  $database->getMonthlyTarget($month,$yr);
                                 echo $database->convertToMoney($teamTarget);
                                ?>

                                </h1>
                                <div class="font-bold text-navy"><i class="fa fa-level-up"></i> <small>Target</small></div>
                            </div>
                            <div class="col-md-6">
                                <h1 class="no-margins">


                                <?php
                                    echo $database->convertToMoney($thisMonthAmount_);

                                ?>

                                </h1>
                                <div class="font-bold text-navy">
                                <?php echo $database->calculatePercentage($thisMonthAmount_,$teamTarget);?>%
                                <small>Current Achievement</small></div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <?php }?>





        </div>
        <div class="row ibox float-e-margins ibox-content">
         <h1 class="font-bold m-b-xs">Your Monthly Sales</h1>
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
                                                    $thatMTarget =  $database->getUserMonthlyTarget($myData['id'],$i,$yr);
                                                     $monthName = date('F', mktime(0, 0, 0, $i, 10));
                                                ?>
                                                 <small>Total orders in the month of <?php echo $monthName;?></small><br/>
                                            <h2 class="no-margins">


                                            <?php
                                                 $thatmonths = (array)$database->getMonthlyOrderCollected($myData['id'],$i,$yr);
                                                 $thatMonthAmount_ = 0;
                                                  foreach($thatmonths as $thatmonth) {
                                                    $thatMonthAmount_ = $thatMonthAmount_ + $thatmonth['Amount'];
                                                   }
                                                    $thismonthsMps = (array)$database->getMonthlyMPS($myData['id'],$i,$yr);
                                                     foreach($thismonthsMps as $thismonth) {
                                                               $thatMonthAmount_ = $thatMonthAmount_ + $thismonth['amount'];
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
                                           <hr>

                    </div>

<?php  if($myData['AccessLevel'] > 5){?>


<div class="row">
                    <div class="col-lg-12">
                          <hr>
                      <form action="" method="POST">
          <div class="row">



                <div class="col-md-6"><select name="txtYear" class="form-control" id="">
                    <?php
                    $yr = date("Y");
                            for ($i=$yr; $i > $yr - 2; $i--) {?>
                                <option value="<?php echo $i;?>" <?php if(isset($_POST['txtYear']) && ($_POST['txtYear'] == $i) ){echo "selected";}?>> <?php echo $i; ?>   </option>
                    <?php  }?>
                    <option></option>
                </select>
            </div>
                <div class="col-md-6"><input type="submit" name="yearlySalesGraph" value="VIEW" class="btn btn-success col-md-12" /></div>
            </div>                    

  </form>


                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                    <div>
                                    <?php
                                     if (isset($_POST['yearlySalesGraph'])) {
                                        
                                         $month = 12;

                                         $yr = $_POST['txtYear'];

                                         $totalSalesThisYear = 0;
                                             for ($i=1; $i < $month + 1; $i++) {
                                             $totalSalesThisYear +=$database->getTeamSumMonthlySales($i,$yr)+$database->getTeamMPSMonthlySales($i,$yr);
                                    }

                                    }


                                    else{

                                     
                                    $totalSalesThisYear = 0;
                                             for ($i=1; $i < date('m')+1; $i++) {
                                             $totalSalesThisYear +=$database->getTeamSumMonthlySales($i,$yr)+$database->getTeamMPSMonthlySales($i,$yr);
                                    }}?>
                                        <span class="pull-right text-right">
                                        <small>Average value of sales in the past months for: <strong><?php echo $yr;?></strong></small>
                                            <br/>
                                            <!--Best Sales: 162,862-->
                                        </span>
                                        <h1 class="m-b-xs"><?php echo $database->convertToMoney($totalSalesThisYear);?></h1>
                                        <h3 class="font-bold no-margins">
                                           Gross revenue margin
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

<?php } ?>
<br/>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Activities</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                           <!-- <div class="ibox-content ibox-heading">
                                <h3><i class="fa fa-envelope-o"></i> New messages</h3>
                                <small><i class="fa fa-tim"></i> You have 22 new messages and 16 waiting in draft folder.</small>
                            </div>-->
                            <div class="ibox-content">
                                <div class="feed-activity-list">
                                <?php
                                $n = 0;
                                        $acts = (array)$database->getActivitiesNotifications();
                                        foreach ($acts as $act) {
                                            if($n == 16){break;}

                                ?>
                                    <div class="feed-element">
                                        <div>
                                            <small class="pull-right text-navy"><?php echo $database->time_elapsed_string($act['timeStamp']);?></small>
                                            <strong><?php echo $act['admin'];?></strong>
                                            <div><?php echo $act['activities'];?></div>
                                            <small class="text-muted"><?php echo $act['dateTime'];?></small>
                                        </div>
                                    </div>
<?php  $n++;}?>
    <?php if(count($act) > 10){?>
                                    <a href="" class="btn btn-white col-lg-12"><i class="fa fa-chevron-down"></i> View More Activities</a><?php }?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Sales Ranking for the month of <?php echo date('F');?></h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                            <a class="close-link">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <table class="table table-hover no-margins">
                                            <thead>
                                            <tr>
                                            <th style="width: 1%" class="text-center">No.</th><th>Admin</th>
                                                <th>Amount</th>
                                                  <th>Target</th>
                                                  <th>Percentage</th>
                                                  <th>Contribution</th>
                                               
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php

                                                $ranking = $database->getMonthlyOrderCollectedRanking2($month,$yr);
                                                $n = 1;
                                                foreach ($ranking as $rank) {

                                            ?>
                                            <tr>
                                            <th><?php echo $n;?>.</th>
                                             <td><?php echo  $rank['admin'];?> <?php   $user_id = $rank['staffId'];?></td>
                                                <td><span class="label label-primary">
                                                <?php echo $database->convertToMoney($rank['totalAmount']);?></span>
                                                </td>

                                                 <td><span class="label label-primary"><?php
                                               
                                        $month = date('m');
                                        $year = date('Y');
                                        $target =  $database->getUsersMonthlyTarget($user_id,$month,$year);
                                        if (is_array($target) || is_object($target))
                                        {
                                        foreach ($target as $getTarget)
                                        {
                                        echo $database->convertToMoney($getTarget['amount']);
                                        }
                                        }else{
                                          echo $database->convertToMoney(0.00);
                                        }
                                              
                                               
                                                ?></span></td>

                                               
                                                <td class="text-navy">

                                                 <i class="fa fa-level-up"></i>


                                                <?php echo $database->calculatePercentage($rank['totalAmount'],$getTarget['amount']);?>%</td>

                                                  <td class="text-navy">

                                                 <i class="fa fa-level-up"></i>


                                                <?php echo $database->calculatePercentage($rank['totalAmount'],$thisMonthAmount_);?>%</td>

                                               
                                            </tr>
                                            <?php $n++; }?>

                                            </tbody>
                                        </table>
                                         <a href="<?php echo $host;?>monthly-sales?txtMonth=<?php echo $month;?>&txtYear=<?php echo $yr;?>&Submit=VIEW" class="btn btn-warning col-lg-12"><i class="fa fa-area-chart"></i> View Graph</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                         <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Sales Ranking for the Year of <?php echo date('Y');?></h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                            <a class="close-link">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <table class="table table-hover no-margins">
                                            <thead>
                                            <tr>
                                            <th style="width: 1%" class="text-center">No.</th>
                                                <th>Amount</th>

                                                <th>Admin</th>
                                               <!--  <th>Contribution</th> -->
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php

                                                $ranking = $database->getYearlyOrderCollectedRanking($yr);
                                                $n = 1;
                                                foreach ($ranking as $rank) {

                                            ?>
                                            <tr>
                                            <th><?php echo $n;?>.</th>
                                                <td><span class="label label-primary">
                                                <?php echo $database->convertToMoney($rank['Amount']);?></span>
                                                </td>

                                                <td><?php echo $rank['admin'];?></td>

                                            </tr>
                                            <?php $n++; }?>

                                            </tbody>
                                        </table>
                                         <!--<a href="<?php echo $host;?>yearly-sales" class="btn btn-warning col-lg-12"><i class="fa fa-area-chart"></i> View Graph</a>-->
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Top 10 Highest Single Transaction Made</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                            <a class="close-link">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-hover margin bottom">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 1%" class="text-center">No.</th>
                                                        <th>CompanyName</th>
                                                        <th class="text-center">Amount</th>
                                                         <th class="text-center">Admin</th>
                                                        <th class="text-center">Date</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        $n = 1;
                                                        $trans = (array)$database->getTransactionRanking($yr);
                                                        foreach ($trans as $tran) {
                                                            if($n == 11){break;}
                                                           ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $n;?></td>
                                                        <td> <?php echo $tran['companyName'];?> </td>
                                                        <td class="text-center">
                                                        <span class="label label-primary">
                                                        <?php echo $database->convertToMoney($tran['Amount']);?>
                                                        </span>
                                                        </td>
                                                        <td class="text-center small"><?php echo $tran['admin'];?></td>
                                                        <td class="text-center small"><?php echo $tran['ocMonth']."-".$tran['ocYear'];?></td>


                                                    </tr>
                                                    <?php $n++;}?>

                                                    </tbody>
                                                </table>

    <?php if(count($trans) > 5){?>
                                    <a href="" class="btn btn-info col-lg-12"><i class="fa fa-chevron-down"></i> View More Transaction ranking</a><?php }?>

                                            </div>

                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
                </div>

        </div>
        <?php //include("includes/chats.php");?>
        <?php //include("includes/activities.php");?>





    <!-- Mainly scripts -->
    <script src="<?php echo $host;?>js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo $host;?>js/bootstrap.min.js"></script>
    <script src="<?php echo $host;?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $host;?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="<?php echo $host;?>js/plugins/flot/jquery.flot.js"></script>
    <script src="<?php echo $host;?>js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="<?php echo $host;?>js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="<?php echo $host;?>js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="<?php echo $host;?>js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="<?php echo $host;?>js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="<?php echo $host;?>js/plugins/flot/curvedLines.js"></script>

    <!-- Peity -->
    <script src="<?php echo $host;?>js/plugins/peity/jquery.peity.min.js"></script>
    <script src="<?php echo $host;?>js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo $host;?>js/inspinia.js"></script>
    <script src="<?php echo $host;?>js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="<?php echo $host;?>js/plugins/jquery-ui/jquery-ui.min.js"></script>

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

                            if (isset($_POST['yearlySalesGraph'])) {
                                        
                                         $month = 12;

                                         $yr = $_POST['txtYear'];

                                         for ($i=1; $i < $month + 1; $i++) {
                                 echo $database->getTeamSumMonthlySales($i,$yr)+$database->getTeamMPSMonthlySales($i,$yr).",";
                                     }}else{

                                 for ($i=1; $i < date('m')+1; $i++) {
                                 echo $database->getTeamSumMonthlySales($i,$yr)+$database->getTeamMPSMonthlySales($i,$yr).",";

                                     }

                                
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
                                 if (isset($_POST['yearlySalesGraph'])) {
                                        
                                         $month = 12;

                                         $yr = $_POST['txtYear'];

                                 for ($i=1; $i < $month+1; $i++) {
                                     echo $database->getMonthlyTarget($i,$yr).",";

                                 }
                                  }else{

                                   for ($i=1; $i < date('m')+1; $i++) {
                                     echo $database->getMonthlyTarget($i,$yr).",";

                                  }
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
