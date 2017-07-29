<?php
    session_start();
    include 'includes/config.php';
	include 'includes/settings.php';
        
	if( isset($_SESSION['userId']) )
	{
		header('Location:'. $site_path.'dashboard.php');
        exit();
	}
	
	$errorMsg = $uid = $pass = "";
    if( $_SERVER['REQUEST_METHOD'] == 'POST' )
    {
        $uid = $_POST['uid'];
        $pass = $_POST['pass'];
        
        $query = "SELECT userId FROM users WHERE username = '$uid' AND password = '$pass'";
        $result = $con->query($query);
        if( $result->num_rows > 0 )
        {
            $row = $result->fetch_object();
            $userId = $row->userId;
            $_SESSION['userId'] = $userId;
            header('Location:'. $site_path.'dashboard.php');
            exit();
        }
        else
        {
            $errorMsg = 'Username and password does not match';
        }
    }
?>

<!DOCTYPE html>
    <html>
        <head>
            <title>Login</title>
            <META CHARSET="UTF-8">
            <META lang="en">
            <META http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
            <style>
                .contentWrapper{
                    width: 100%;
                    max-width: 400px;
                    margin: 100px auto;
                }
                h3{
                    background-color: #000;
                    color: #fff;
                }
                .errorMsg{
                    color: red;
                    display: block;
                    width: 100%;
                    padding: 5px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="contentWrapper">
                        <form method="post" action="<?PHP $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" novalidate>
                            <h3 style="text-align: center; font-size: 18px; padding: 5px;">User Login</h3>
                            <span class="errorMsg"><?php echo $errorMsg; ?></span>
                            <div class="form-group">
                                <label class="control-label">Username:</label>
                                <input type="text" class="form-control" name="uid" value="<?php echo $uid; ?>" placeholder="Your mobile no." />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Password:</label>
                                <input type="password" class="form-control" name="pass" value="<?php echo $pass; ?>" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Login">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </body>
    </html>