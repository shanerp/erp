<?php # CONNECT TO MySQL DATABASE.

# Connect  on 'localhost' for user 'root' with password 'zerocool' to database 'slabs'.
$dbc = @mysqli_connect ( DB_HOST, DB_USER, DB_PASS, DB_NAME )

# Otherwise fail gracefully and explain the error. 
OR die ( mysqli_connect_error() ) ;

# Set encoding to match PHP script encoding.
mysqli_set_charset( $dbc, 'utf8' ) ;
