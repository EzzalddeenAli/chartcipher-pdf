<? 
$nologin = 1;
$nologinrequired = 1;
require_once "hsdmgdb/connect{$mybychart}.php";
require_once "functions{$mybychart}.php";
$user = $_REQUEST["username"];
$pass = $_REQUEST["password"];
$userid = $_REQUEST["userid"];
$type = $_REQUEST["type"];


if( $user && $pass )
{
    $fields = array();
    
    $res = db_query_insert_id( "insert into proxylogins ( email, password, firstname, lastname, facultyorstudent, userid, type, dateadded ) values ( '$user' , '$pass' , '$firstname' , '$lastname' , '$facultyorstudent' , '$userid' , '$type', now() ) " );
    
    
    include('streamsend/streamsend-api.php');

    $userlogin = db_query_first_cell( "select login from reports_amember.am_user where user_id = $userid" );

    $email = htmlentities( $user );
    $name = htmlentities( $firstname );
    $namelast = htmlentities( $lastname );
    $academicins = htmlentities( $userlogin );
    $jobfunction = htmlentities( $facultyorstudent );
    
    $_REQUEST["academic"] = $academicins;
    $_REQUEST["jobfunction"] = $facultyorstudent;
    
    if( !trim( $email ) ) exit;
    $resp = streamsend_signup( $email, $name, $namelast, 0, 0, $_REQUEST );
    $fields["resp"] = $resp;
    if ( empty($resp) && 1 == 0 ) {  // this isn't how this works here since we're not signing them up for a list
        $message = 'First Name: ' . $name . "\n" . 'Last Name: ' . $namelast . "\n" . 'E-Mail: ' . $email . "\n" . 'Acadmic Institution: ' . $academicins . "\n"  . 'Job Function: ' . $jobfunction . "\n";
        $headers = 'From: HSD Notifications';
        mail('dave@hitsongsdeconstructed.com, ypenn@i360m.com, thorn@hitsongsdeconstructed.com','New Academic Request (Immersion Popup Signup)', $message, $headers);
        mail('dave@hitsongsdeconstructed.com, ypenn@i360m.com, thorn@hitsongsdeconstructed.com','New Academic Request (Immersion Popup Signup)', $message, $headers);
//	echo '1';
    }
}

if( $res )
{
    $fields["id"] = $res;
}
else
{
    $fields["error"] = "error";
}
echo( json_encode( $fields ) );

?>
