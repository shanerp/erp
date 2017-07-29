<?php
	session_start();
	include 'includes/settings.php';
	if( !isset($_SESSION['userId']) )
	{
		header('Location: '.$site_path);
		exit();
	}
	$current_page_menu = "vendor";
	$randStr = rand();
?>

<!DOCTYPE html>
    <html>
        <head>
            <title>Add Vendor</title>
            <?php include_once 'includes/header-files.php'; ?>
            <link rel="stylesheet" href="css/form-fields.css?randStr=<?php echo $randStr; ?>">
        </head>
        
        <body>
			<?php include_once 'includes/header.php'; ?>
			<?php include_once 'includes/sidebar.php'; ?>
			
            <div class="dashboard-content">
                <div class="container-fluid">
                    <div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 25px;">
							<div class="content_title_wrapper">
								<span class="home-icon"></span>
								<span class="glyphicon glyphicon-menu-right right-arrow" aria-hidden="true"></span>
								<span>Add Vendor</span>
								<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
							</div>
						</div>
                    </div>	<!-- .row -->
                </div>	<!-- .container-fluid -->
				
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="formWrapper">
                                <h2 class="formHeading">Enter Vendor Details</h2>
                                <form method="post" action="<?PHP $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group no_padd">
                                        <label>Name : <em class="small errorText"></em></label>
                                        <input type="text" class="form_input" name="name" placeholder="Vendor / Firm Name">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group no_padd">
                                        <label>Phone : <em class="small errorText"></em></label>
                                        <input type="text" class="form_input" name="phone" placeholder="Vendor Phone">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group no_padd">
                                        <label>Address : <em class="small errorText"></em></label>
                                        <input type="text" class="form_input" name="address" placeholder="Vendor Address">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group no_padd">
                                        <label>City : <em class="small errorText"></em></label>
                                        <input type="text" class="form_input" name="city" placeholder="Vendor City / Town">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group no_padd">
                                        <label>Pincode : <em class="small errorText"></em></label>
                                        <input type="text" class="form_input" name="pincode" placeholder="Pincode">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group no_padd">
                                        <label>GSTIN : <em class="small errorText"></em></label>
                                        <input type="text" class="form_input" name="gst_no" placeholder="Vendor GST No.">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group no_padd">
                                        <input type="submit" class="btn btn-primary form_submit_btn" name="submit" value="Save">
                                    </div>
                                </form>
                            </div>
                        </div>
					</div>
				</div> <!-- .container-fluid -->
				
            </div>	<!-- .dashboard-content -->
            
            <script type="text/javascript" src="js/jquery.min.js"></script>
            <script type="text/javascript" src="js/bootstrap.min.js"></script>
            <script type="text/javascript" src="js/dashboard-layout.js?ver=<?php echo $randStr; ?>"></script>
        </body>
    </html>