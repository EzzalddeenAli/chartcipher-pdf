<?php
/*Subscribe the user to streamsend*/

include('streamsend-api.php');

$email = htmlentities( $_POST['email'] );
$name = htmlentities( $_POST['fname'] );
$namelast = htmlentities( $_POST['lname'] );
$company = htmlentities( $_POST['company'] );
$jobfunction = htmlentities( $_POST['jobfunction'] );
$phone = htmlentities( $_POST['phone'] );
$state = htmlentities( $_POST['state'] );
$country = htmlentities( $_POST['country'] );
$raffleform = htmlentities( $_POST['raffleform'] );
$academicdemo = htmlentities( $_POST['academicdemo'] );
$academicpricing = htmlentities( $_POST['academicpricing'] );
$ocode = htmlentities( $_POST['ocode'] );
if( !trim( $email ) ) exit;
$resp = streamsend_signup( $email, $name, $namelast, 0, 0, $_POST );
if ( empty($resp) ) { 
	$message = 'First Name: ' . $name . "\n" . 'Last Name: ' . $namelast . "\n" . 'E-Mail: ' . $email . "\n" . 'Company: ' . $company . "\n"  . 'Job Function: ' . $jobfunction . "\n" . 'Phone: ' . $phone . "\n" . 'State: ' . $state . "\n" . 'Country: ' . $country . "\n" . 'Ocode: ' . $ocode . "\n";
	$headers = 'From: HSD Notifications';
	mail('dave@hitsongsdeconstructed.com, ypenn@i360m.com, thorn@hitsongsdeconstructed.com','Immersion Raffle', $message, $headers);
	echo '1';
}


?>