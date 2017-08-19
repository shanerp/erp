<?php
	session_start();
	include '../includes/settings.php';
	if( !isset($_SESSION['userId']) )
	{
		header('Location: '.$site_path);
		exit();
	}
	$current_page_menu = "unit";
	$randStr = rand();
?>

<!DOCTYPE html>
    <html>
        <head>
            <title>Add Units</title>
            <?php include_once 'includes/header-files.php'; ?>
            <link rel="stylesheet" href="../css/form-fields.css?randStr=<?php echo $randStr; ?>">
			
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
								<span>Add Units</span>
								<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
							</div>
						</div>
                    </div>	<!-- .row -->
                </div>	<!-- .container-fluid -->
				
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="formWrapper">
                                <form method="post" action="<?PHP $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group no_padd">
                                        <label>Symbol : <em class="small errorText"></em></label>
                                        <input type="text" class="form_input" name="unit_symbol" placeholder="Symbol">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group no_padd">
                                        <label>Full form: <em class="small errorText"></em></label>
                                        <input type="text" class="form_input" name="unit_full_form" placeholder="Full form">
                                    </div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group no_padd">
                                        <input type="submit" class="btn btn-primary form_submit_btn" name="submit" value="Save">
                                    </div>
                                </form>
                            </div>
                        </div>
					</div>
					
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="formWrapper">
                                <form method="post" action="<?PHP $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                    <label>Conversions <em class="small errorText"></em></label>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group no_padd">
                                        <input type="text" class="form_input" name="unit_symbol" placeholder="Symbol">
                                    </div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group no_padd">
                                        <select class="form_input" name="unit_symbol" id="unit_symbol">
											<option value="kg">kg</option>
										</select>
                                    </div>
									
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group no_padd">
                                        <input type="text" class="form_input" name="unit_symbol" placeholder="Symbol">
                                    </div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group no_padd">
                                        <select class="form_input" name="unit_symbol" id="unit_symbol">
											<option value="grams">grams</option>
										</select>
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
            
            <script type="text/javascript" src="../js/jquery.min.js"></script>
            <script type="text/javascript" src="../js/bootstrap.min.js"></script>
            <script type="text/javascript" src="../js/dashboard-layout.js?ver=<?php echo $randStr; ?>"></script>
        </body>
    </html>