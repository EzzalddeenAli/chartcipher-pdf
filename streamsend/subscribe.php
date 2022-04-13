<?php
/*Subscribe the user to streamsend*/

include('streamsend-api.php');

$email = htmlentities( $_POST['email'] );
$name = htmlentities( $_POST['fname'] );
$namelast = htmlentities( $_POST['lname'] );
$subcharts = htmlentities( $_POST['charts'] );
$subwire = htmlentities( $_POST['wire'] );
$subscription_date = htmlentities ( $_POST['subscription_date']);
$resp = streamsend_signup( $email, $name, $namelast, $subcharts, $subwire, $_POST );
if( !trim( $email ) ) exit;
if ( empty($resp) ) { 
	$message = 'First Name: ' . $name . "\n" . 'Last Name: ' . $namelast . "\n" . 'E-Mail: ' . $email . "\n";
	$headers = 'From: HSD Notifications';
	mail(/*'dave@hitsongsdeconstructed.com, notifications@i360m.com'*/'trahman@i360m.com','HSD Sidebar Signup', $message, $headers);
	echo '1';
}


?>