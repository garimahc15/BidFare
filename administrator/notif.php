<?php
	session_start();
	if($_SESSION['isvalid'] != "true"){
		header("location:index.php");
	}
	require('functions.php');
	require('htmls.php');
	headhtml();
	categoryadd($conn);
?>
<body>
	<div id="container">
		<div id="bgwrap">
			<div id="primary_left">
        
				<!-- <div id="logo">
				 	<a href="http://hello.amnesio.com/dashboard.html" title="Dashboard"><img src="./assets/logo.png" alt="" /></a>  
					</div> 	 -->
				<!-- logo end -->

				<div id="menu"> <!-- navigation menu -->
					<ul>
						<li class="current"><a href="notif.php"><img src="icons/73.png" alt /><span>Notifications</span></a></li>
                        <li><a href="bids.php" class="dashboard"><img src="icons/2.png" alt /><span class="current">Bids</span></a></li>						
						<li class='showme'><a href="#"><img src="icons/36.png" alt /><span>Products</span></a>
							<ul class='showoff'>
								<li><a href="add_prodven.php">New Product</a></li>
								<li><a href="addcategory.php">New Product Category</a></li>
							</ul>
						</li>						
                        <li class='showme'><a href="#"><img src="./assets/icons/small_icons_3/settings.png" alt /><span>Account</span></a>
							<ul class='showoff'>
								<li><a href="logout.php">Logout</a></li>
							</ul>
						</li>	
					</ul>
				</div> <!-- navigation menu end -->
			</div> <!-- sidebar end -->

			<div id="primary_right">
			<center><h1><br />Welcome Administrator</h1></center>
				<div class="inner">
				<!--join member and products-->
				<?php 
				
				$bidnum = mysqli_query($conn, "SELECT * FROM bidreport LEFT JOIN member ON member.memberid = bidreport.bidder LEFT JOIN products ON products.productid = bidreport.productid WHERE bidreport.status = 0") or die(mysqli_error());
						$count = 0;
						WHILE($stat = mysqli_fetch_array($bidnum)){
							$count++;
						}
				?>
				<!--end query-->
				
				<!--query for msgs-->
				<?php 
				
				$msgnum = mysqli_query($conn, "SELECT * FROM msgnotifs WHERE (toid = 'admin' AND status = 0)") or die(mysqli_error());
						$counter = 0;
						WHILE($stat = mysqli_fetch_array($msgnum)){
							$counter++;
						}
				?>
				<!--end query-->
				<!--query for msgs-->
				<?php 
				$datenow = date('l,F d,Y');
				$endedsum = mysqli_query($conn, "SELECT * FROM products WHERE status = 1") or die(mysqli_error());
						$counters = 0;
						WHILE($stat = mysqli_fetch_array($endedsum)){
							$counters++;
						}
				?>
				<!--end query-->
				
					<!--for notifications-->
					<ul><div id="number"><img src="./assets/icons/notif.png" alt = "0" width='94' height='92'/><br />Notifications<div id="num_result"><?php echo $count; ?></div></div></ul>
					<!--end for notifications-->
					
					<!--for messages-->
					<ul><div id="wew"><img src="./assets/icons/notif.png" alt = "0" width='94' height='92'/><br />Messages<div id="msg_result"><?php echo $counter; ?></div></div>
					<div class="nota"></ul>
					<!--end for messages-->
					
					<!--for notifications-->
					<ul><div id="numberee"><img src="./assets/icons/notif.png" alt = "0" width='94' height='92'/><br />Ended Products<div id="end_result"><?php echo $counters; ?></div></div></ul>
					<!--end for notifications-->
					
					<!--query for notifications-->
					<?php $bids_stat = mysqli_query($conn, "SELECT * FROM bidreport LEFT JOIN member ON member.memberid = bidreport.bidder LEFT JOIN products ON products.productid = bidreport.productid WHERE bidreport.status = 0") or die(mysqli_error());
						WHILE($stat = mysqli_fetch_array($bids_stat)){
					?> 
							<div class="notif id<?php echo $stat['bidid']; ?>" id="<?php echo $stat['bidid']; ?>">
							<p>
							<span><?php echo $stat['lastname'].", " .$stat['firstname']; ?></span>
							Has Placed <strong>Rs <?php echo $stat['bidamount']; ?></strong> On <?php echo $stat['prodname']; ?> last <strong><?php echo $stat['biddatetime']; ?></strong>
							</p>
							</div>
							<?php } ?>
					<!--end of notification-->
					
					<!--query for notifications-->
					<?php
					
					$endcheck = mysqli_query($conn, "SELECT * FROM products WHERE status = 1") or die(mysqli_error());
						WHILE($static = mysqli_fetch_array($endcheck)){
						$prodid = $static['productid'];
						$prodname = $static['prodname'];
						$query2 = mysqli_query($conn, "SELECT * FROM bidreport WHERE productid = '$prodid'") or die (mysqli_error());
						$numberOfRows = MYSQLI_NUM_ROWS($query2);
						if ($numberOfRows == 0)
							{
							$noofbidders = "none";
							$higestbid = "0";
							}
							else if ($numberOfRows > 0)
							{
							$initialize = 0;
							while($row2 = mysqli_fetch_array($query2)){
								if ($row2['bidamount'] >= $initialize){
									$initialize = $row2['bidamount'];
									}
								}
								$higestbid = $initialize;
								$noofbidders = $numberOfRows;
								$query3 = mysqli_query($conn, "SELECT * FROM bidreport WHERE bidamount = '$higestbid' AND productid = '$prodid' ") or die (mysqli_error());
								$winner=mysqli_fetch_array($query3);
								$hewins=$winner['bidder'];
								mysqli_query($conn, "UPDATE products SET status = 0 WHERE productid = '$prodid' ") or die (mysqli_error());
								$rows = mysqli_query($conn, "SELECT * needtopay WHERE memberid = '$hewins' AND productid = '$prodid'");
								$numrows1 = MSQL_NUMROWS($rows);
								if ($numrows1 == 0){
								mysqli_query($conn, "INSERT INTO needtopay(memberid,productid,status,payment,declined,dateadded) VALUES('$hewins','$prodid','0','$higestbid','0',NOW()) ") or die (mysqli_error());
								}
							}
					?> 
							
							<div class="ended id<?php echo $static['productid']; ?>" id="<?php echo $static['productid']; ?>">
							<p>
							<br /><span><?php echo $prodname; ?></span>
							Item Has Ended This <strong><?php echo $datenow; ?></strong> With <strong><?php 
								echo ''.$higestbid.'</strong> Bid';
								if($higestbid > 0){
									echo '</strong>, winner is Member '.$hewins.'';
								}
							?>
							</p>
							</div>
							<?php } ?>
					<!--end of notification-->
					
					
					<div id="result_bid">
					
					</div>
                        </div>
						</div>

						<div class="one_third last column">
						  <h5></h5>
						</div>
						<hr />
						<HR>
						<HR/>
						  <div class="clearboth"></div>
						</div><!-- three_fourth last -->
					</div>
					<div class="clearboth" style="padding-bottom:20px;"></div>
				</div> <!-- inner -->
				<div id="inner2">
					
				</div>
			</div> <!-- primary_right -->
		</div> <!-- bgwrap -->
	</div> <!-- container -->
</body>
</html>

<script type='text/javascript'>
	jQuery(document).ready( function() {
			jQuery('.notif').hide();
		jQuery('#number').click( function() {
			jQuery('.notif').toggle('slow');
			jQuery('.weee').hide();
		});
			
			jQuery(".notif").click( function() {
				var id = $(this).attr("id");
				
				jQuery.ajax({
					type: "POST",
					data: ({id: id}),
					url: "bidupdate.php",
					success: function(response) {
					jQuery(".id" + id).hide();
					jQuery("#num_result").fadeIn().html(response);
					}
				});
				
			})
			jQuery('.weee').hide();
		jQuery('#wew').click( function() {
			jQuery('.weee').toggle('slow');
			jQuery('.notif').hide();
		});
			
			jQuery(".weee").click( function() {
				var id = $(this).attr("id");
				
				jQuery.ajax({
					type: "POST",
					data: ({id: id}),
					url: "wew.php",
					success: function(response) {
					jQuery(".id" + id).hide();
					jQuery("#msg_result").fadeIn().html(response);
					}
				});
				
			})
			jQuery('.ended').hide();
		jQuery('#numberee').click( function() {
			jQuery('.ended').toggle('slow');
			jQuery('.notif').hide();
			jQuery('.weee').hide();
		});
			
			jQuery(".ended").click( function() {
				var id = $(this).attr("id");
				
				jQuery.ajax({
					type: "POST",
					data: ({id: id}),
					url: "weweee.php",
					success: function(response) {
					jQuery(".id" + id).hide();
					jQuery("#end_result").fadeIn().html(response);
					}
				});
				
			})
			jQuery(document).ready( function() {
			jQuery('.showoff').hide();
		jQuery('.showme').click( function() {
			jQuery('.showoff').hide();
			jQuery(this).find('ul').toggle('slow');
		});

	});
		
	});
</script>