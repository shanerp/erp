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
            <title>Dashboard</title>
            <?php include_once 'includes/header-files.php'; ?>
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
								<span>Dashboard</span>
								<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
							</div>
						</div>
                    </div>	<!-- .row -->
                </div>	<!-- .container-fluid -->
				
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h2>Hello</h2>
						</div>
					</div>
				</div>
				
            </div>	<!-- .dashboard-content -->
			
            
            <script type="text/javascript" src="js/jquery.min.js"></script>
            <script type="text/javascript" src="js/bootstrap.min.js"></script>
            <script type="text/javascript" src="js/dashboard-layout.js?ver=<?php echo $randStr; ?>"></script>
        </body>
    </html>