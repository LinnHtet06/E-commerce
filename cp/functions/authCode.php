<?php
session_start();
include_once('../db/config.php');
include_once('myfunction.php');
if(isset($_POST['submit']))
{
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $mail=mysqli_real_escape_string($conn,$_POST['mail']);
    $phone=mysqli_real_escape_string($conn,$_POST['phone']);
    $address=mysqli_real_escape_string($conn,$_POST['address']);
    $pass=mysqli_real_escape_string($conn,$_POST['pass']);
    $cpass=mysqli_real_escape_string($conn,$_POST['cpass']);

    $checkemail="SELECT c_email FROM customer WHERE c_email='$mail' ";
    $checkemailQuery=mysqli_query($conn,$checkemail);
    if($pass==$cpass)
    {
        $sql="INSERT INTO customer (c_name,c_email,c_phone,c_address,c_password) VALUES 
        (' $name','$mail','$phone','$address','$pass')";
        $query=mysqli_query($conn,$sql);
        if($query)
        {
            redirect('loginUi.php',"Registered Successfully");
        }
        else
        {
            redirect('register.php',"something went worng");
        }
    }
    else
    {
        redirect('register.php',"Password does not match");
    }

}
//Login Code
elseif(isset($_POST['logIn']))
{
	
	$mail=mysqli_real_escape_string($conn,$_REQUEST['mail']);
	$pass=mysqli_real_escape_string($conn,$_REQUEST['pass']);
	$sql="SELECT * FROM customer WHERE c_email='$mail' AND c_password='$pass' ";
	$dataExist=mysqli_query($conn,$sql);
	
	if(mysqli_num_rows($dataExist) > 0)
			{
				//session memberId is user define $info table col name
				$_SESSION['auth']=true;
				$userData=mysqli_fetch_array($dataExist);
				$userID=$userData['c_id'];
				$userName=$userData['c_name'];
				$userEmail=$userData['c_email'];
				$_SESSION['auth_user']=[
					'c_id'=>$userID,
					'c_name'=>$userName,
					'c_email'=>$userEmail
				];
				redirect('../index.php',"login successfully");				
					
			}
	else
		{
			redirect('../loginUi.php',"Something Went wrong");
				// $_SESSION['failTime'];
				if(isset($_SESSION['failTime'])>=3)
				{
					echo "<script>
					alert('Login Fail three times,try after 10-minutes');
					document.getElementById('email').disabled=true;
					document.getElementById('password').disabled=true;
					document.getElementById('logIn').disabled=true;

					setTimeout((reOpen),600000);
					function reOpen(){
						document.getElementById('email').disabled=false;
					document.getElementById('password').disabled=false;
					document.getElementById('logIn').disabled=false;

					}
					</script>";
					unset($_SESSION['failTi me']);
				}
				else{
					
					if(isset($_SESSION['failTime']))
						$_SESSION['failTime']+=1;
					else
						$_SESSION['failTime']=1;
				}
			}
		}

		elseif(isset($_POST['AdminLogin']))
		{
			
			$mail=mysqli_real_escape_string($conn,$_REQUEST['mail']);
			$pass=mysqli_real_escape_string($conn,md5($_REQUEST['pass']));
			$sql="SELECT * FROM admin WHERE a_email='$mail' AND a_password='$pass' ";
			$dataExist=mysqli_query($conn,$sql);
			
			if(mysqli_num_rows($dataExist) == 1)
					{
						
						$userData=mysqli_fetch_array($dataExist);
       					
							$_SESSION['authenticate']=true;
							$adminID=$userData['a_id'];
							$adminName=$userData['a_name'];
							$adminEmail=$userData['a_email'];
							$_SESSION['auth_admin']=[
								'a_id'=>$adminID,
								'a_name'=>$adminName,
								'a_email'=>$adminEmail
							];
						redirect('../admin/index.php',"login successfully");				
							
					
				}
			else
				{
					redirect('../admin/adminLogin.php',"Something Went wrong");
						// $_SESSION['failTime'];
						if(isset($_SESSION['failTime'])>=3)
						{
							echo "<script>
							alert('Login Fail three times,try after 10-minutes');
							document.getElementById('email').disabled=true;
							document.getElementById('password').disabled=true;
							document.getElementById('logIn').disabled=true;
		
							setTimeout((reOpen),600000);
							function reOpen(){
								document.getElementById('email').disabled=false;
							document.getElementById('password').disabled=false;
							document.getElementById('logIn').disabled=false;
		
							}
							</script>";
							unset($_SESSION['failTime']);
						}
						else{
							
							if(isset($_SESSION['failTime']))
								$_SESSION['failTime']+=1;
							else
								$_SESSION['failTime']=1;
						}
					}
				}		
		

		 

?>