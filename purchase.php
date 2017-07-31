<?php
	session_start();
	include 'includes/settings.php';
	if( !isset($_SESSION['userId']) )
	{
		header('Location: '.$site_path);
		exit();
	}
	$current_page_menu = "";
	$randStr = rand();
?>

<!DOCTYPE html>
    <html>
        <head>
            <title>Purchase</title>
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
								<span>Purchase</span>
								<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
							</div>
						</div>
                    </div>	<!-- .row -->
                </div>	<!-- .container-fluid -->
				
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="formWrapper">
                                <h2 class="formHeading">Enter Product Details</h2>
                                <form method="post" action="<?PHP $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group no_padd lg_pad_right_5">
                                        <label>Product Name : <em class="small errorText"></em></label>
                                        <input type="text" class="form_input" name="product_name" placeholder="Product Name">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group no_padd lg_pad_right_5">
                                        <label>Batch No. : <em class="small errorText"></em></label>
                                        <input type="text" class="form_input" name="batch_no" placeholder="Batch No.">
                                    </div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group no_padd">
                                        <label>Mfg Date : <em class="small errorText"></em></label>
                                        <input type="text" class="form_input" name="mfg_date" placeholder="Mfg Date">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 form-group no_padd lg_pad_right_5">
                                        <label>Item Quantity : <em class="small errorText"></em></label>
                                        <input type="text" class="form_input" name="item_quantity" placeholder="Quantity">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 form-group no_padd lg_pad_right_5">
                                        <label>Unit : <em class="small errorText"></em></label>
										<select class="form_input" name="item_unit">
											<option value="1">Kg</option>
											<option value="2">Grm</option>
										</select>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 form-group no_padd lg_pad_right_5">
                                        <label>No. of pieces : <em class="small errorText"></em></label>
                                        <input type="number" class="form_input" name="no_of_pieces" placeholder="No. Of Pieces">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 form-group no_padd lg_pad_right_5">
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