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

<script type="text/javascript">

var parent = <?php echo $database->getArrayDepartments();?>;
var child = <?php echo $database->getDepartmentsDesignation();?>;
        
    function LoadChild(){
        var i = document.getElementById("parent").selectedIndex ;
        var dp = document.getElementById("child");
        var count = child[i-1].length;
        var html = "<option value=\"\" disabled selected hidden>- select -</option>";
        for(var k = 0 ; k < count ; k ++){
            html += "<option value=\""+child[i-1][k][0]+"\">"+child[i-1][k][1]+"</option>";
        }
        
        dp.innerHTML = html;
    }
</script> 
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Register Members of Staff</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo $host;?>">Home</a>
                        </li>
                        
                        <li class="active">
                            <strong>Register Users</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

  <div class="wrapper wrapper-content">
  <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        

                        <?php 
                        $err = "";
                        $msg = "";
                        		if(isset($_POST['btnCreateUser'])){
                        			$name = $database->test_input($_POST['txtName']);
                        			$phone = $database->test_input($_POST['txtPhone']);
                        			$email = $database->test_input($_POST['txtEmail']);
                        			$dpt = $database->test_input($_POST['txtDpt']); 
                        			$designation = $database->test_input($_POST['txtDesig']);
                        			$username = $database->test_input($_POST['txtUsername']);

                        			if($name != "" && $phone != "" && $email != "" && $dpt != "" && $designation != "" && $username != "")
									{
										if($database->VerifyUsername($username)){
											$err = "This username has been taken, try another one";
										}else{
											if($database->verifyPhoneNumber($phone,1)){
												$err = "This phone has been used by another member of staff";	
											}else{
												$database->registerStaff($name, $email,$phone,$dpt,$designation,$username);
												$msg = "Member of staff has been created!";
												unset($_POST);
											}

										}
                        			}

                        		}

                        ?>
                       

                        <div class="ibox-content">
                            <form method="post" name="staff-registration" class="form-horizontal">

                             <div class="form-group">
                                <label class="col-sm-2 control-label">&nbsp;</label>
                                    <div class="col-sm-10">
                                    	<?php if($err!= ""){$database->showMsg('Error',$err,1);}
                                    	 else if($msg!=""){$database->showMsg('Success',$msg,2);}?>
                                    </div>
                                </div>
                                <div class="form-group">
                                <label class="col-sm-2 control-label">FULLNAME</label>
                                    <div class="col-sm-10">
                                    	<input type="text" value="<?php if(isset($_POST['txtName'])){echo $_POST['txtName'];}?>" name="txtName" placeholder="Enter fullname"
                                    	 required class="form-control">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
                                <div class="form-group">
                                <label class="col-sm-2 control-label">PHONE NO</label>
                                   <div class="col-sm-10">
                                        <input type="text" value="<?php if(isset($_POST['txtPhone'])){echo $_POST['txtPhone'];}?>" name="txtPhone" class="form-control" data-mask="(234) 999-999-9999" required>
                                        <span class="help-block">(234) 803-6180-3243</span>
                                    </div>
                                </div>

                                 <div class="form-group">
                                <label class="col-sm-2 control-label">EMAIL</label>
                                   <div class="col-sm-10">
                                        <input id="email" name="txtEmail" value="<?php if(isset($_POST['txtEmail'])){echo $_POST['txtEmail'];}?>" type="email" class="form-control required email">
                                       
                                    </div>
                                </div>

                                 
                                 <div class="form-group">
                                <label class="col-sm-2 control-label">DEPARTMENT</label>
                                   <div class="col-sm-4">
                                       <select class="form-control m-b" id="parent" onChange="LoadChild();" name="txtDpt" required data-validation-required-message="department is required">
                                     <option value="" disabled selected hidden>- select -</option>
                                        <script type="text/javascript">
                                            for(var i = 0 ; i < parent.length ; i ++){
                                                document.write('<option value="'+parent[i][0]+'">'+parent[i][1]+'</option>');
                                            }
                                        </script>
                                       
                                       
                                    </select>    
                                    </div>

                                    <label class="col-sm-2 control-label">DESIGNATION</label>
                                   <div class="col-sm-4">
                                       <select class="form-control m-b" name="txtDesig" id="child">
                                    
                                       
                                       
                                    </select>    
                                    </div>
                                </div>

                              <div class="form-group">
                                <label class="col-sm-2 control-label">USERNAME</label>
                                    <div class="col-sm-7">
                                    	<input type="text" value="<?php if(isset($_POST['txtUsername'])){echo $_POST['txtUsername'];}?>" name="txtUsername" placeholder="ENTER USERNAME" required class="form-control">
                                    </div>
                                </div>
                                
							<div class="hr-line-dashed"></div>

							<div class="form-group">
                                <label class="col-sm-2 control-label">&nbsp;</label>
                                    <div class="col-sm-10">
                                    	 <button name="btnCreateUser" class="btn btn-primary col-lg-12" type="submit">Create User</button>
                           
                                    </div>
                                </div>
                                </form>

                                <script type="text/javascript">
                                	$(function() {
										  // Initialize form validation on the registration form.
										  // It has the name attribute "registration"
										  $("form[name='staff-registration']").validate({
										    // Specify validation rules
										    rules: {
										      // The key name on the left side is the name attribute
										      // of an input field. Validation rules are defined
										      // on the right side
										      txtName: "required",
										      txtPhone: "required",
										      txtEmail: {
										        required: true,
										        // Specify that email should be validated
										        // by the built-in "email" rule
										        email: true
										      },
										      password: {
										        required: true,
										        minlength: 5
										      }
										    },
										    // Specify validation error messages
										    messages: {
										      txtName: "Please enter your firstname",
										      txtPhone: "Please enter your lastname",
										     
										      email: "Please enter a valid email address"
										    },
										    // Make sure the form is submitted to the destination defined
										    // in the "action" attribute of the form when valid
										    submitHandler: function(form) {
										      form.submit();
										    }
										  });
										});


                                </script>
                                
                       


 <?php include("includes/js.php");?>

  </div>