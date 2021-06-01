<?php
	session_start();
	require ("db.php");
	require("htmls.php");
	require("functions.php");
	headhtml();
	
	if (isset($_POST['next2'])){
	
				$_SESSION['userid']=$_POST['loginid'];
				$_SESSION['email'] = $_POST['email1'];
				$_SESSION['password'] = $_POST['pass1'];
				$_SESSION['secques'] =$_POST['secques'];
				$_SESSION['secans'] =$_POST['secans'];
							
				$fname = $_SESSION['firstname'];
				$lname = $_SESSION['lastname'];
				$gender = $_SESSION['gender'];
					$caddress = $_SESSION['caddress'];
					$address = $_SESSION['address'];
				$cusaddress = "$caddress"." "."$address";
				$contactno = $_SESSION['contactno'];	
					$day = $_SESSION['day'];
					$month = $_SESSION['month'];
					$year = $_SESSION['year'];
				$birthdate = "$day"." "."$month"." "."$year";
				$email = $_SESSION['email'];
				$userid =$_SESSION['userid'];
				$password = md5($_SESSION['password']);
				$secques =$_SESSION['secques'];
				$secanswer =$_SESSION['secans'];
								
				mysqli_query($conn, "INSERT INTO member(lastname,firstname,gender,userid,password,email,contactno,birthdate,address,verification,memberimg) VALUES ('$lname','$fname','$gender','$userid','$password','$email','$contactno','$birthdate','$cusaddress','no','default.jpg')");
				$query = mysqli_query($conn, "SELECT * FROM member WHERE userid = '$userid'") or die (mysqli_error());
					$row = mysqli_fetch_array($query);
					$id= $row['memberid'];
					mysqli_query($conn, "INSERT into secretquestions(memberid,question,answer) VALUES ('$id','$secques','$secanswer')");
				$_SESSION['ID']= $id;
				$_SESSION['logged'] = "notactive";
				$_SESSION['user'] = $userid;
				/*header('location:ppactivate.php');*/
				
	}
	?>
	
	<?php
	if(isset($_POST['login'])){
				if(isset($_POST['user'])) {
					if(isset($_POST['pass'])){			
						$username = $_POST['user'];	
						$pass = md5($_POST['pass']);
						$query = mysqli_query($conn, "SELECT * FROM member WHERE userid = '$username' AND  password = '$pass'") or die (mysqli_error());
						$user = mysqli_fetch_array($query);
			
						if($user['verification'] == 'yes'){
							$_SESSION['ID'] = $user['memberid'];
							$_SESSION['logged'] = $user['memberid'];
							$_SESSION['email'] = $user['email'];
							$_SESSION['name'] = $user['firstname'] . ' ' . $user['lastname'];
							$_SESSION['user'] = $username;
							/*header('Location: myaccount.php');*/
					?>
                        <script> location.replace("myaccount.php"); </script>	
<?php						
						}
						elseif($user['verification'] == 'no')
						{
							$_SESSION['ID'] = $user['memberid'];
							$_SESSION['user'] = $user['fname'];
							$_SESSION['email'] = $user['email'];
							$_SESSION['name'] = $user['firstname'] . ' ' . $user['lastname'];
							$_SESSION['logged'] = "notactive";
							/*header('Location: myaccount.php'); */
						?>	
							<script>location.replace("myaccount.php");</script>
							
							<?php
						}
						else
						{
						echo "please check password detail";
						/* 	header("location: errorlogin.php"); */
						}
					}
					else
					{
					echo "please check your userid";
					/* 	header("location: errorlogin.php"); */
					}
				}
				else
				{
				echo "please check login detail";
				/* 	header("location: errorlogin.php"); */
				}
			}
			
?>
  <div id="main_content">
    <div id="menu_tab">
      <div class="left_menu_corner"></div>
      <ul class="menu">
        <li><a href="home.php" class="nav2"> Home</a></li>
        <li class="divider"></li>
        <li><a href="prodcateg.php" class="nav2">Products</a></li>
        <li class="divider"></li>
        <li><a href="contact.php" class="nav2">About Us</a></li>
        <li class="divider"></li>
      </ul>
      <div class="right_menu_corner"></div>
    </div>
    <!-- end of menu tab -->
    <div class="crumb_navigation"> Navigation: <a href="home.php">Home</a> &lt; <span class="current">Sign In</span> </div>
    <div class="left_content">
      <div class="title_box">Categories</div>
      <ul class="left_menu">
        <?php
			categories($conn);
		?>
      <div class="title_box">Announcements</div>
      <div class="border_box">
        <input type="text" name="newsletter" class="newsletter_input" value="your email"/>
        <a href="http://all-free-download.com/free-website-templates/" class="join">join</a> </div>
      <div class="banner_adds"> <a href="#"><img src="images/bann2.jpg" alt="" border="0" /></a> </div>
    </div>
    <!-- end of left content -->
    <div class="center_content">
      <div class="center_title_bar">User Log In</div>
      <div class="prod_box_big">
        <div class="top_prod_box_big"></div>
        <div class="center_prod_box_big">
			<div class='logreg'>
				<div class="loginb">
					<div class="top_prod_box"></div>
					<div class="center_prod_box">
					  <div class="product_title"><a>Log in as a User</a></div>
					  <div class="product_img"><a><img src="administrator/icons/53.png" alt="" border="0" /></a></div>
					</div>
				</div>
				<div class="regb">
					<div class="top_prod_box"></div>
					<div class="center_prod_box">
					  <div class="product_title"><a>Register as a User</a></div>
					  <div class="product_img"><a><img src="administrator/icons/54.png" alt="" border="0" /></a></div>
					</div>
				</div>
			</div>
			<script type='text/javascript'>
				jQuery(document).ready( function() {
					
					jQuery('.contact_form').hide();
					jQuery('.reg_form').hide();
					jQuery('.loginb').click( function() {
						jQuery('.contact_form').toggle('slow');
						jQuery('.reg_form').hide();
					});
					jQuery('.regb').click( function() {
						jQuery('.reg_form').toggle('slow');
						jQuery('.contact_form').hide();
					});
				});
			</script>
          <div class="contact_form">
            <div id="form_row1">
              <form method = "post" action="" id="logins-form" class="logins-form">
                
                <span class="blue"><strong>Username</strong></span><input type="text" name="user">
                <span class="blue"><strong>Password</strong></span><input type="password" name="pass">
                  <ul>
                  	<li><a href="#">Forgot your password?</a></li>
                    <li><a href="#">Forgot your username?</a></li>
                  </ul>
                    <input type="submit" value="Login" name="login">
              </form>
            </div>
          </div>
		  <div class="reg_form">
			<div id="regstep1">
            <form action="register2.php" method="post" name="contacts-form" id="contacts-form">
            <strong>Lastname:</strong>
              <input type="text" name="lname" class="required"/></br></br>
              <strong>Firstname:</strong>
              <input type="text" name="fname" class="required"/></br></br>
              <strong>Gender:</strong>
              <select name="gender">
				<option>Male</option>
				<option>Female</option>
			</select></br></br>
            <strong>Address:</strong> 
            <select name="city">
            	<option>City</option>
				<option>Mandi</option>
				<option>New Delhi</option>
				<option>Chandigarh</option>
				<option>Mumbai</option>
				<option>Gurgaon</option>
				<option>Bangalore</option>
				<option>Hyderabad</option>
				<option>Kolkata</option>
			</select></br></br>
            <input type="text" name="address" class="required"/></br></br>
           <strong>Contact:</strong> 
            <input type="text" name="contactno" class="required" onKeyPress="return isNumberKey(event)"/></br></br>
            <strong>Birthdate:</strong>
            <input type="text" name="day" onKeyPress="return isNumberKey(event)"/>
		</br></br>

            <select name="month">
				<option>Month</option>
				<option></option>
				<option>January</option>
				<option>Febuary</option>
				<option>March</option>
				<option>April</option>
				<option>May</option>
				<option>June</option>
				<option>July</option>
				<option>August</option>
				<option>September</option>
				<option>October</option>
				<option>November</option>
				<option>December</option>
			</select></br></br>
            
                                  
                                  <select name="year">
				  <option>Year</option>
                                  <option></option> 
					<?php
    						for ($i=1970; $i<=2003; $i++)
    						{
        						?>
            							<option><?php echo $i;?></option>
        						<?php
    						}
					?>
			</select></br></br>
            <input type="submit" name="next1" value="next step"/>
            </form>
            </div>
		  </div>
        </div>
        <div class="bottom_prod_box_big"></div>
      </div>
    </div>
    <!-- end of center content -->
    <!-- end of right content -->
  </div>
  <!-- end of main content -->
<?php foothtml(); ?>
