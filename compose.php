<?php
  include("data/DBConfig.php");
  include_once("data/sessioncheck.php");
   
    $getID ="";
    $to_id = "";
    $subject = "";
    $message = "";
if(isset($_GET['id'])){$getID = $_GET['id'];}


$msg = $database->getMyInboxDetails($getID,$myData['id']);

if($msg['reciever_id'] == $myData['id']){
    $to_id = $msg['sender_id'];
    $subject = $msg['subject'];
    $message = $msg['message'];
}

?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tenaui + | Mailbox</title>
    <link href="<?php echo $host;?>css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/animate.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/style.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/plugins/dualListbox/bootstrap-duallistbox.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/plugins/select2/select2.min.css" rel="stylesheet">

   <link href="<?php echo $host;?>css/plugins/summernote/summernote.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/plugins/summernote/summernote-bs3.css" rel="stylesheet">

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
                <div class="pull-right tooltip-demo">
                    <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to draft folder"><i class="fa fa-pencil"></i> Draft</a>
                    <a href="<?php echo $host;?>mailbox" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fa fa-times"></i> Discard</a>
                </div>
                <h2>
                    Compse mail
                </h2>
            </div>
                <div class="mail-box">
<?php 
$msg = "";
        $tal = 1;
    if(isset($_POST['btnSend'])){
        
        $to = $database->test_input($_POST['txtReciever']);
       
        $msgType = 1;
        $sub = $database->test_input($_POST['txtsubj']);
        $mesg = $_POST['txtmsg'];
        

        if($to != "" && $sub !="" && $mesg != ""){
           $database->sendPrivatemessage($myData['fullname'], $myData['id'],$to,$msgType,$sub, $mesg);
                if(isset($_POST['txtCC'])){
                    foreach ($_POST['txtCC'] as $key) {
                    $database->sendPrivatemessage($myData['fullname'], $myData['id'],$key,$msgType,$sub, $mesg);
                }
                }
                $tal = 2;
                $msg = "Message sent successfully...";
                unset($_POST);
        }else{
            $tal = 0;
            if($to == ""){$msg.= "<li>Select a recipient</li>";}
            if($sub == ""){$msg.= "<li>Enter a subject for your message</li>";}
            if($mesg == ""){$msg.= "<li>Enter a message</li>";}
        }


    }

?>

                <div class="mail-body">
                <?php if($msg!=""){echo $database->showMsg('',$msg,$tal);}?>
                    <form class="form-horizontal" method="post">
                        <div class="form-group"><label class="col-sm-2 control-label">To:</label>

                            <div class="col-sm-10 ">
                        <select data-placeholder="Choose a recipient..." name="txtReciever" class="chosen-select"  tabindex="5" required data-validation-required-message="Select a recipient" >
                                        <option value=""></option>
                                       <?php 
                                               $stfs= (array)$database->getAllAdmins();
                                               foreach ($stfs as $stf) {
                                                    if($stf['id'] == $myData['id']) continue;
                                                ?>
                                              
                                             <option value="<?php echo $stf['id'];?>" <?php if($stf['id']==$to_id){echo "selected";}?>>
                                             <?php echo $stf['fullname'];?></option>      

                                         <?php   } ?>
                                         </select>
                            </div>
                        </div>
                         <div class="form-group"><label class="col-sm-2 control-label">Cc:</label>

                        <div class="col-sm-10">
                        <select data-placeholder="Choose a Cc..." name="txtCC[]" class=" form-control chosen-select" multiple style="width:350px;" tabindex="4">
                            
                            <?php 
                                               $stfs= (array)$database->getAllAdmins();
                                               foreach ($stfs as $stf) {
                                                    if($stf['id'] == $myData['id']) continue;
                                                ?>
                                               
                                             <option value="<?php echo $stf['id'];?>"><?php echo $stf['fullname'];?></option>      

                                         <?php   } ?>
                        </select>
                          

                        </div>
                        
                        <div class="form-group"><label class="col-sm-2 control-label">Subject:</label>
                            <div class="col-sm-10"><input type="text" name="txtsubj" class="form-control" value="<?php if(isset($_POST['txtsubj'])){echo $_POST['txtsubj'];}else if (isset($subject)){echo $subject;}?>"></div>
                        </div>
             

                </div>

                    <div class="mail-text h-200">
                    <textarea class="summernote" name="txtmsg"><?php if(isset($_POST['txtmsg'])){echo $_POST['txtmsg'];}else if(isset($message)){echo "<br/><br/><br/><br/><br/><br/>".$message;}?></textarea>

                        <div >
                            

                        </div>
<div class="clearfix"></div>
                        </div>
                    <div class="mail-body text-right tooltip-demo">
                    <button class="btn btn-sm btn-primary" name="btnSend" data-toggle="tooltip" data-placement="top" title="Send"><i class="fa fa-reply"></i> Send</button>
                        <a href="<?php echo $host;?>mailbox" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fa fa-times"></i> Discard</a>
                       <!-- <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to draft folder"><i class="fa fa-pencil"></i> Draft</a>-->
                    </div>
                    <div class="clearfix"></div>

</form>

                </div>
            </div>
       
        </div>
        </div>
        
        </div>
        </div>

   <!-- Mainly scripts -->
    <script src="<?php echo $host;?>js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo $host;?>js/bootstrap.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo $host;?>js/inspinia.js"></script>
    <script src="<?php echo $host;?>js/plugins/pace/pace.min.js"></script>
    <script src="<?php echo $host;?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Chosen -->
    <script src="<?php echo $host;?>js/plugins/chosen/chosen.jquery.js"></script>

   <!-- JSKnob -->
   <script src="<?php echo $host;?>js/plugins/jsKnob/jquery.knob.js"></script>

   <!-- Input Mask-->
    <script src="<?php echo $host;?>js/plugins/jasny/jasny-bootstrap.min.js"></script>

   <!-- Data picker -->
   <script src="<?php echo $host;?>js/plugins/datapicker/bootstrap-datepicker.js"></script>

   <!-- NouSlider -->
   <script src="<?php echo $host;?>js/plugins/nouslider/jquery.nouislider.min.js"></script>

   <!-- Switchery -->
   <script src="<?php echo $host;?>js/plugins/switchery/switchery.js"></script>

    <!-- IonRangeSlider -->
    <script src="<?php echo $host;?>js/plugins/ionRangeSlider/ion.rangeSlider.min.js"></script>

    <!-- iCheck -->
    <script src="<?php echo $host;?>js/plugins/iCheck/icheck.min.js"></script>

    <!-- MENU -->
    <script src="<?php echo $host;?>js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Color picker -->
    <script src="<?php echo $host;?>js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

    <!-- Clock picker -->
    <script src="<?php echo $host;?>js/plugins/clockpicker/clockpicker.js"></script>

    <!-- Image cropper -->
    <script src="<?php echo $host;?>js/plugins/cropper/cropper.min.js"></script>

    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="<?php echo $host;?>js/plugins/fullcalendar/moment.min.js"></script>

    <!-- Date range picker -->
    <script src="<?php echo $host;?>js/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Select2 -->
    <script src="<?php echo $host;?>js/plugins/select2/select2.full.min.js"></script>

    <!-- TouchSpin -->
    <script src="<?php echo $host;?>js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

    <!-- Tags Input -->
    <script src="<?php echo $host;?>js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

    <!-- Dual Listbox -->
    <script src="<?php echo $host;?>js/plugins/dualListbox/jquery.bootstrap-duallistbox.js"></script>

    <script>
        $(document).ready(function(){

            $('.tagsinput').tagsinput({
                tagClass: 'label label-primary'
            });

            var $image = $(".image-crop > img")
            $($image).cropper({
                aspectRatio: 1.618,
                preview: ".img-preview",
                done: function(data) {
                    // Output the result data for cropping image.
                }
            });

            var $inputImage = $("#inputImage");
            if (window.FileReader) {
                $inputImage.change(function() {
                    var fileReader = new FileReader(),
                            files = this.files,
                            file;

                    if (!files.length) {
                        return;
                    }

                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function () {
                            $inputImage.val("");
                            $image.cropper("reset", true).cropper("replace", this.result);
                        };
                    } else {
                        showMessage("Please choose an image file.");
                    }
                });
            } else {
                $inputImage.addClass("hide");
            }

            $("#download").click(function() {
                window.open($image.cropper("getDataURL"));
            });

            $("#zoomIn").click(function() {
                $image.cropper("zoom", 0.1);
            });

            $("#zoomOut").click(function() {
                $image.cropper("zoom", -0.1);
            });

            $("#rotateLeft").click(function() {
                $image.cropper("rotate", 45);
            });

            $("#rotateRight").click(function() {
                $image.cropper("rotate", -45);
            });

            $("#setDrag").click(function() {
                $image.cropper("setDragMode", "crop");
            });

            $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            $('#data_2 .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "dd/mm/yyyy"
            });

            $('#data_3 .input-group.date').datepicker({
                startView: 2,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            $('#data_4 .input-group.date').datepicker({
                minViewMode: 1,
                keyboardNavigation: false,
                forceParse: false,
                forceParse: false,
                autoclose: true,
                todayHighlight: true
            });

            $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, { color: '#1AB394' });

            var elem_2 = document.querySelector('.js-switch_2');
            var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });

            var elem_3 = document.querySelector('.js-switch_3');
            var switchery_3 = new Switchery(elem_3, { color: '#1AB394' });

            var elem_4 = document.querySelector('.js-switch_4');
            var switchery_4 = new Switchery(elem_4, { color: '#f8ac59' });
                switchery_4.disable();

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            $('.demo1').colorpicker();

            var divStyle = $('.back-change')[0].style;
            $('#demo_apidemo').colorpicker({
                color: divStyle.backgroundColor
            }).on('changeColor', function(ev) {
                        divStyle.backgroundColor = ev.color.toHex();
                    });

            $('.clockpicker').clockpicker();

            $('input[name="daterange"]').daterangepicker();

            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

            $('#reportrange').daterangepicker({
                format: 'MM/DD/YYYY',
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2015',
                dateLimit: { days: 60 },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'right',
                drops: 'down',
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-primary',
                cancelClass: 'btn-default',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Cancel',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });

            $(".select2_demo_1").select2();
            $(".select2_demo_2").select2();
            $(".select2_demo_3").select2({
                placeholder: "Select a state",
                allowClear: true
            });


            $(".touchspin1").TouchSpin({
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white'
            });

            $(".touchspin2").TouchSpin({
                min: 0,
                max: 100,
                step: 0.1,
                decimals: 2,
                boostat: 5,
                maxboostedstep: 10,
                postfix: '%',
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white'
            });

            $(".touchspin3").TouchSpin({
                verticalbuttons: true,
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white'
            });

            $('.dual_select').bootstrapDualListbox({
                selectorMinimalHeight: 160
            });


        });

        $('.chosen-select').chosen({width: "100%"});

        $("#ionrange_1").ionRangeSlider({
            min: 0,
            max: 5000,
            type: 'double',
            prefix: "$",
            maxPostfix: "+",
            prettify: false,
            hasGrid: true
        });

        $("#ionrange_2").ionRangeSlider({
            min: 0,
            max: 10,
            type: 'single',
            step: 0.1,
            postfix: " carats",
            prettify: false,
            hasGrid: true
        });

        $("#ionrange_3").ionRangeSlider({
            min: -50,
            max: 50,
            from: 0,
            postfix: "°",
            prettify: false,
            hasGrid: true
        });

        $("#ionrange_4").ionRangeSlider({
            values: [
                "January", "February", "March",
                "April", "May", "June",
                "July", "August", "September",
                "October", "November", "December"
            ],
            type: 'single',
            hasGrid: true
        });

        $("#ionrange_5").ionRangeSlider({
            min: 10000,
            max: 100000,
            step: 100,
            postfix: " km",
            from: 55000,
            hideMinMax: true,
            hideFromTo: false
        });

        $(".dial").knob();

        var basic_slider = document.getElementById('basic_slider');

        noUiSlider.create(basic_slider, {
            start: 40,
            behaviour: 'tap',
            connect: 'upper',
            range: {
                'min':  20,
                'max':  80
            }
        });

        var range_slider = document.getElementById('range_slider');

        noUiSlider.create(range_slider, {
            start: [ 40, 60 ],
            behaviour: 'drag',
            connect: true,
            range: {
                'min':  20,
                'max':  80
            }
        });

        var drag_fixed = document.getElementById('drag-fixed');

        noUiSlider.create(drag_fixed, {
            start: [ 40, 60 ],
            behaviour: 'drag-fixed',
            connect: true,
            range: {
                'min':  20,
                'max':  80
            }
        });


    </script>
    <script src="<?php echo $host;?>js/plugins/summernote/summernote.min.js"></script>
    <script>
        $(document).ready(function(){

            $('.summernote').summernote();

        });

    </script>
</body>
</html>



