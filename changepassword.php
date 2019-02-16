<?php
  include("data/DBConfig.php");
  include_once("data/sessioncheck.php");
?>
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
 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Change Password</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo $host;?>">Home</a>
                        </li>
                        
                        <li class="active">
                            <strong>Change Password</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="col-lg-1">

                </div>

             <div class="col-lg-10" style="align-self: center;">
                    <div class="ibox float-e-margins">
                     <div class="ibox-content">

                     <?php 
                     $err= $msg="";
                     		if(isset($_POST['btnEditPassword'])){
                     			$pass1 = $database->test_input($_POST['txtpass1']);
                     			$pass2 = $database->test_input($_POST['txtpass2']);
                     			$pass3 = $database->test_input($_POST['txtpass3']);
                     			

                     			if($pass1 != "" && $pass2 != "" && $pass3 != ""){
                     				if($pass2 == $pass3){

                     					if($pass1 == $myData['password']){

                     						$database->updateStaffUserPassword($myData['id'],$pass2);
                     						$msg = "Password successfully changed!";

                     					}else{
                     						$err = "Old passwords do not match";
                     					}

                     				}else{
                     					$err = "password do not match";
                     				}

                     			}else{
                     				if($pass1 == ""){$err.= "<li>Enter old password</li>";}
                     				if($pass2 == ""){$err.= "<li>Enter new password</li>";}
                     				if($pass3 == ""){$err.= "<li>re-enter old password</li>";}
                     			}

                     		}

                     ?>

                            <form method="post" name="edit_password" class="form-horizontal">

                            		<div class="form-group">
                                <label class="col-sm-2 control-label">&nbsp;</label>
                                    <div class="col-sm-10">
                                    	<?php if($err!= ""){$database->showMsg('Error',$err,1);}
                                    	 else if($msg!=""){$database->showMsg('Success',$msg,2);}?>
                                    </div>
                                </div>
                                <div class="form-group">
                                <label class="col-sm-2 control-label">Old password:</label>
                                    <div class="col-sm-10">
                                    	<input type="password" value="" name="txtpass1" placeholder="Enter old password"
                                    	 required class="form-control">
                                    </div>
                                </div>
                                 <div class="form-group">
                                <label class="col-sm-2 control-label">New Password:</label>
                                    <div class="col-sm-7">
                                    	<input type="password" value="" name="txtpass2" placeholder="Enter new password"
                                    	 required class="form-control" id="txtpass2">
                                    </div>
                                </div>
                                 <div class="form-group">
                                <label class="col-sm-2 control-label">Re-enter password</label>
                                    <div class="col-sm-7">
                                    	<input type="password" value="" name="txtpass3" placeholder="Re-enter new password"
                                    	 required class="form-control" id="txtpass3">
                                    </div>
                                </div>
                                <div class="form-group">
                                <label class="col-sm-2 control-label">&nbsp;</label>
                                    <div class="col-sm-10">
                                    	 <button name="btnEditPassword" class="btn btn-primary col-lg-12" type="submit">Edit Password</button>
                           
                                    </div>
                                </div>


							</form>
					</div>
                	

                	</div>
              </div>

