
<?php
include_once('xml2array.php');

# Globals
$ss_audience = "1";


# Main function to sign someone up
# $list_id = Mailing list id.
function streamsend_signup($email, $firstname, $lastname, $charts, $wire, $extrafields = array())
{

	$xml_sent = '';
	$xml_response = '';
	$xml_status = '';
	$debug = 0;
   	
   	#If the  person exists
	$ch = init_api();
	$p_id = person_find($ch, $email);
	curl_close($ch);
	
	$html_part = '';
	$text_part = '';
	$subject = '';
	
	// Subscription Fields
	$vars = array(
  		"html" => $html_part, 
  		"text" => $text_part,
  		"subject" => $subject
  	);

	#specify streamsend vars here
	#fields associative array
	#post variable name => streamsend field name
	$fields = array(
		'email-address' => $email,
		'first-name' 	=> $firstname,
		'last-name'		=> $lastname
	);
    /* [company_name] => dsadsa */
    /* [primary_occupation] => a_r */
    /* [other_occupation] => 1111 */
    /* [company_type] => gaming */
    /* [other_company] => 1111222 */
    /* [music_is_my] => hobby */
    /* [experience] => experienced */
    /* [how_heard_about_us] => linkedin */
    /* [other_heard] => 123 */
    /* [news_website1] => a */
    /* [news_website2] => b */
    /* [news_website3] => c */
    /* [news_website4] => d */

	if( isset( $extrafields["company_name"] ) ) {
		$fields["company"] = $extrafields["company_name"];
	}
		if( isset( $extrafields["subscription_date"] ) ) {
		$fields["date-subscribed"] = $extrafields["subscription_date"];
	}
	if( isset( $extrafields["person_trigger_test"] ) ) {
		$fields["date-subscribed"] = $extrafields["person_trigger_test"];
	}
	if( isset( $extrafields["primary_occupation"] ) ) {
		$fields["primary-occupation"] = $extrafields["primary_occupation"];
	}
	if( isset( $extrafields["other_occupation"] ) ) {
		$fields["primary-occu-other"] = $extrafields["other_occupation"];
	}
	if( isset( $extrafields["company_type"] ) ) {
		$fields["company-type"] = $extrafields["company_type"];
	}
	if( isset( $extrafields["other_company"] ) ) {
		$fields["company-other"] = $extrafields["other_company"];
	}
	if( isset( $extrafields["music_is_my"] ) ){
		$fields["music-is-my"] = $extrafields["music_is_my"];
	}
	if( isset( $extrafields["experience"] ) ) {
		$fields["experience"] = $extrafields["experience"];
	}
	if( isset( $extrafields["how_heard_about_us"] ) ) {
		$fields["how-did-you-hear-about-us"] = $extrafields["how_heard_about_us"];
	}
	if( isset( $extrafields["other_heard"] ) ) {
		$fields["how-heard-other"] = $extrafields["other_heard"];
	}
	if( isset( $extrafields["ocode"] ) ) {
		$fields["offer-code"] = $extrafields["ocode"];
	}
	if( isset( $extrafields["news_website1"] ) ) {
		$fields["first-website-for-music-industry-information"] = $extrafields["news_website1"];
	}
	if( isset( $extrafields["news_website2"] ) ) {
		$fields["second-website-for-music-industry-information"] = $extrafields["news_website2"];
	}
	if( isset( $extrafields["news_website3"] ) ) {
		$fields["third-website-for-music-industry-information"] = $extrafields["news_website3"];
	}
	if( isset( $extrafields["news_website4"] ) ) {
		$fields["fourth-website-for-music-industry-information"] = $extrafields["news_website4"];
	}
	if( isset( $extrafields['academic'] ) ) {
		$fields['academic-institution'] = $extrafields['academic'];
	}
	if( isset( $extrafields['academicins'] ) ) {
		$fields['academic-institution'] = $extrafields['academicins'];
	}
	if( isset( $extrafields['wwth_form'] ) ) {
		$fields['wwth-form'] = $extrafields['wwth_form'];
	}
	if( isset( $extrafields['hsd_demo'] ) ) {
		$fields['hsd-demo'] = $extrafields['hsd_demo'];
	}
	if( isset( $extrafields['hsd_pricing'] ) ) {
		$fields['hsd-pricing'] = $extrafields['hsd_pricing'];
	}
	if( isset( $extrafields['academicdemo'] ) ) {
		$fields['hsd-demo'] = $extrafields['academicdemo'];
	}
	if( isset( $extrafields['academicpricing'] ) ) {
		$fields['hsd-pricing'] = $extrafields['academicpricing'];
	}
	if( isset( $extrafields['job'] ) ) {
		$fields['job-function'] = $extrafields['job'];
	}
	if( isset( $extrafields['jobfunction'] ) ) {
		$fields['job-function'] = $extrafields['jobfunction'];
	}
	if( isset( $extrafields['phone'] ) ) {
		$fields['phone-number'] = $extrafields['phone'];
	}
	if( isset( $extrafields['state'] ) ) {
		$fields['state'] = $extrafields['state'];
	}
	if( isset( $extrafields['country'] ) ) {
		$fields['country'] = $extrafields['country'];
	}
	if( isset( $extrafields['number-of-users'] ) ) {
		$fields['number-of-users'] = $extrafields['number-of-users'];
	}
	if( isset( $extrafields['name-of-school'] ) ) {
		$fields['name-of-school'] = $extrafields['name-of-school'];
	}
	if( isset( $extrafields['coupon'] ) ) {
		$fields['discount-code'] = $extrafields['coupon'];
	}
	if( isset( $extrafields['school-id-no'] ) ) {
		$fields['school-id-no'] = $extrafields['school-id-no'];
	}
	if( isset( $extrafields["date-subscribed"] ) ) {
		$fields["date-subscribed"] = $extrafields["date-subscribed"];
	}

	file_put_contents( "/tmp/rc", "resp-1: ".print_r( $extrafields, true )."\n\n", FILE_APPEND );
	
			
	# Create/Update The Person
	$ch = init_api();
	if( strcmp($p_id,'') == 0 ){
   		person_create($ch, $fields);
        $p_id = person_find($ch, $email);
	} else {
   		person_update($ch, $p_id, $fields);
	}
	curl_close($ch);
	
	$ch = init_api();
    file_put_contents( "/tmp/rc", "person_find results: we found $p_id\n", FILE_APPEND );
	if ( $charts ) {
		person_subscribe($ch, $p_id, 502);		
	}
	if ( $wire ) {
		person_subscribe($ch, $p_id, 584);		
	}
	if ( isset( $extrafields['sub_wire'] ) ) {
		person_subscribe($ch, $p_id, 506);		
	}
	if ( isset( $extrafields['sub_hsd_partners'] ) ) {
		person_subscribe($ch, $p_id, 19);		
	}
	if ( isset( $extrafields['sub_hsd_events'] ) ) {
		person_subscribe($ch, $p_id, 17);		
	}
	
	if ( isset( $extrafields['academic'] ) ) {
		person_subscribe($ch, $p_id, 526);
	}
	if ( isset( $extrafields['academic'] ) ) {
		person_subscribe($ch, $p_id, 593);
	}
	if ( isset( $extrafields['academicform'] ) ) {
		person_subscribe($ch, $p_id, 526);
	}
	if ( isset( $extrafields['academicform'] ) ) {
		person_subscribe($ch, $p_id, 593);
	}
	if ( isset( $extrafields['raffleform'] ) ) {
		person_subscribe($ch, $p_id, 607);
	}
	if ( isset( $extrafields['wwth_form'] ) ) {
		person_subscribe($ch, $p_id, 538);
	}
	if ( isset( $extrafields['wwth_form_sp'] ) ) {
		person_subscribe($ch, $p_id, 586);
	}
	if ( isset( $extrafields['lead_gen_form'] ) ) {
		person_subscribe($ch, $p_id, 574);
	}
	if ( isset( $extrafields['free_trial'] ) ) {
		person_subscribe($ch, $p_id, 514);
	}
	if ( isset( $extrafields['sample_form'] ) ) {
		person_subscribe($ch, $p_id, 572);
	}
	if ( isset( $extrafields['starboy_terms'] ) ) {
		person_subscribe($ch, $p_id, 669);
	}
	if ( isset( $extrafields['lid'] ) ) {
		person_subscribe($ch, $p_id, $extrafields['lid']);
	}
	
/** aMember Form Subscriptions **/
/* Free Subscription = List ID 514 */
// <input type='hidden' id='product-3-3' name='product_id_page-0[]' value='3-3' 
	if ( isset( $extrafields['sub_product'] ) && $extrafields['sub_product'] == "3-3") {
		person_subscribe($ch, $p_id, 506);		
	}
/* Pro Monthly = 516 */
// name='product_id_page-0[]' value='11-11' 
	if ( isset( $extrafields['sub_product'] ) && $extrafields['sub_product'] == "11-11") {
		person_subscribe($ch, $p_id, 516);		
	}
/* Pro Yearly = 518 */
// name='product_id_page-0[]' value='12-12'
	if ( isset( $extrafields['sub_product'] ) && $extrafields['sub_product'] == "12-12") {
		person_subscribe($ch, $p_id, 518);		
	}
/* Pro Monthly 2016 = 516 */
// name='product_id_page-0[]' value='33-33' 
	if ( isset( $extrafields['sub_product'] ) && $extrafields['sub_product'] == "33-33") {
		person_subscribe($ch, $p_id, 516);		
	}
/* Pro Yearly 2016 = 518 */
// name='product_id_page-0[]' value='34-34'
	if ( isset( $extrafields['sub_product'] ) && $extrafields['sub_product'] == "34-34") {
		person_subscribe($ch, $p_id, 518);		
	}	
/* Pro Monthly = 516 */
// name='product_id_page-0[]' value='11-11' 
	if ( isset( $extrafields['sub_product'] ) && $extrafields['sub_product'] == "30-30") {
		person_subscribe($ch, $p_id, 516);		
	}
/* Pro Yearly = 518 */
// name='product_id_page-0[]' value='12-12'
	if ( isset( $extrafields['sub_product'] ) && $extrafields['sub_product'] == "31-31") {
		person_subscribe($ch, $p_id, 518);		
	}
/* Free One Month = 520 */
// <input type='hidden' id='product-4-4' name='product_id_page-0[]' value='4-4' 
	if ( isset( $extrafields['sub_product'] ) && $extrafields['sub_product'] == "4-4") {
		person_subscribe($ch, $p_id, 520);		
	}
/* Free Three Month = 524 */
// <input type='hidden' id='product-5-5' name='product_id_page-0[]' value='5-5' 
	if ( isset( $extrafields['sub_product'] ) && $extrafields['sub_product'] == "5-5") {
		person_subscribe($ch, $p_id, 524);		
	}
/* Student Subscription = XXX */
// <input type='hidden' id='product-15-15' name='product_id_page-0[]' value='15-15' 
	if ( isset( $extrafields['sub_product'] ) && $extrafields['sub_product'] == "15-15") {
		person_subscribe($ch, $p_id, 528);		
	}
	/* Student Subscription = Fall 2014 */
// <input type='hidden' id='product-15-15' name='product_id_page-0[]' value='16-16' 
	if ( isset( $extrafields['sub_product'] ) && $extrafields['sub_product'] == "16-16") {
		person_subscribe($ch, $p_id, 530);		
	}
	/* Student Subscription = Middle Tennesee Fall */
// <input type='hidden' id='product-18-18' name='product_id_page-0[]' value='18-18' 
	if ( isset( $extrafields['sub_product'] ) && $extrafields['sub_product'] == "18-18") {
		person_subscribe($ch, $p_id, 534);		
	}
	/* Student Subscription = Vanderbilt Fall */
// <input type='hidden' id='product-19-19' name='product_id_page-0[]' value='19-19' 
	if ( isset( $extrafields['sub_product'] ) && $extrafields['sub_product'] == "19-19") {
		person_subscribe($ch, $p_id, 560);		
	}
	/* Student Subscription = MTSU 2015 */
// <input type='hidden' id='product-19-19' name='product_id_page-0[]' value='19-19' 
	if ( isset( $extrafields['sub_product'] ) && $extrafields['sub_product'] == "27-27") {
		person_subscribe($ch, $p_id, 562);		
	}
	

	curl_close($ch);
	$escaped_response = htmlentities($xml_response);
	return $escaped_response;
}


function init_api(){
	# Customized variables ####################################
	# Streamsend API Key
	$login_id = "pv8LDMV0i2Gq";
	$key = "bWUadWa6yl9vpVax";

	# initialize a new curl session
	$headers = array(
		'Accept: application/xml',       # any data returned should be XML
		'Content-Type: application/xml'  # any data we send will be XML
		# include any additional headers here
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_FAILONERROR, false);
	//curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "${login_id}:${key}");
	return $ch;
}

// XML Entity Mandatory Escape Characters
function xmlentities($string) {
	return str_replace ( array ( '&', '"', "'", '<', '>', '�' ), array ( '&amp;' , '&quot;', '&apos;' , '&lt;' , '&gt;', '&apos;' ), $string );
}


// Or just do: curl -i -H 'Accept: application/xml' -u login_id:key "https://ssapi.campaigner.com/audiences.xml"
function get_audience($ch){
	$audience_url = "https://ssapi.campaigner.com/audiences.xml";
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	# execute the session and receive its response
  	$GLOBALS['xml_response'] = curl_exec($ch);
  	$GLOBALS['xml_status'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);

 	 # return all options into an associative array
  	$info = curl_getinfo($ch);
  	//print "audience reponse=" . $GLOBALS['xml_response'] . "<br/>\n";
  	//print "audience status=" . $GLOBALS['xml_status'] . "<br/>\n";
}


function person_create($ch, $fields){
	global $ss_audience;
	file_put_contents( "/tmp/rc", "person creating2222!!! \n", FILE_APPEND );
	
	$person_xml = "<person>";
	foreach($fields as $ssVar => $postVar){
	  if(isset($postVar)){ $person_xml .= xml_add_tagval($ssVar,$postVar); }
	}	
	$person_xml .= "<activate>true</activate>" . 
    "<email_content_format>Both</email_content_format>" . 
    "<deliver-activation>false</deliver-activation>" . 
    "<deliver-welcome>false</deliver-welcome>" . 
    "</person>";

	$person_create_url = "https://ssapi.campaigner.com/audiences/$ss_audience/people.xml";

	curl_setopt($ch, CURLOPT_URL, $person_create_url);

	# Post the xml
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_POSTFIELDS, $person_xml);

	# execute the session and receive its response
	$resp = curl_exec($ch);
	$stat = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$sent = htmlentities($person_xml);

	# return all options into an associative array
	$info = curl_getinfo($ch);
	file_put_contents( "/tmp/rc",  "person reponse=" . $resp . "<br/>\n", FILE_APPEND );
	file_put_contents( "/tmp/rc",  "person status=" . $stat . "<br/>\n", FILE_APPEND );
	file_put_contents( "/tmp/rc", "XML=" . $person_xml . "<br/>\n", FILE_APPEND );

	$GLOBALS['xml_response'] = $resp;
	$GLOBALS['xml_status'] = $stat;
	$GLOBALS['xml_sent'] = $sent;
}

function xml_add_tagval($tag, $value){
	$xml = "<$tag>" . xmlentities($value) . "</$tag>";
	return $xml;
}

function person_update($ch, $p_id, $fields){
  
	global $ss_audience;	  
  
	$person_xml = "<person>";
	
	foreach($fields as $ssVar => $postVar){
	  if(isset($postVar)){ $person_xml .= xml_add_tagval($ssVar,$postVar); }
	}	

	# Always setting these because we actually want 'not set' to opt them out
  	//$person_xml .= xml_add_tagval('dmpulseoptin',$_POST['dmpulseoptin']);
  	//$person_xml .= xml_add_tagval('productoptin',$_POST['productoptin']);
  	//$person_xml .= xml_add_tagval('thirdpartyoptin',$_POST['thirdpartyoptin']);
  	  
  	$person_xml .= "<activate>true</activate>" . 
    "<email_content_format>Both</email_content_format>" . 
    "<deliver-activation>false</deliver-activation>" . 
    "<deliver-welcome>false</deliver-welcome>" . 
    "</person>";	  

	$person_update_url = "https://ssapi.campaigner.com/audiences/$ss_audience/people/$p_id";
	# $person_delete_url = "https://ssapi.campaigner.com/audiences/1/people/17.xml";	

	curl_setopt($ch, CURLOPT_URL, $person_update_url);

	# Post the xml
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($ch, CURLOPT_POSTFIELDS, $person_xml);

	# execute the session and receive its response
	$GLOBALS['xml_response'] = curl_exec($ch);
	$GLOBALS['xml_status'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$GLOBALS['xml_sent'] = htmlentities($person_xml);	

	# return all options into an associative array
	#$info = curl_getinfo($ch);

}

function get_fields(){

}



function person_subscribe($ch, $id, $list_id){
  global $ss_audience;

  $person_subscribe_url = "https://ssapi.campaigner.com/audiences/$ss_audience/memberships.xml";
  $subscribe_xml = "<membership><list-id>$list_id</list-id><person-id>$id</person-id></membership>";

  curl_setopt($ch, CURLOPT_URL, $person_subscribe_url);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $subscribe_xml);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

  # execute the session and receive its response
  $GLOBALS['xml_response'] = curl_exec($ch);
  $GLOBALS['xml_status'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}


function person_show($ch, $id){
  global $ss_audience;
  	  
  $person_get_url = "https://ssapi.campaigner.com/audiences/$ss_audience/people/$id";
  curl_setopt($ch, CURLOPT_URL, $person_get_url);

  # execute the session and receive its response
  $GLOBALS['xml_response'] = curl_exec($ch);
  $GLOBALS['xml_status'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
 
  #Return the id of the person
  preg_match('/<id>(.+?)<\/id>/', $GLOBALS['xml_response'], $matches);
  return $matches[0];
}
	
	
# Find a person by email
function person_find($ch, $email){
	global $ss_audience;
    file_put_contents( "/tmp/rc", "1about to look for {$email} in ssapi\n", FILE_APPEND );
	$person_get_url = "https://ssapi.campaigner.com/audiences/$ss_audience/people.xml?email_address=$email";
    file_put_contents( "/tmp/rc", "a2bout to look for {$email} in ssapi $person_get_url\n", FILE_APPEND );
	curl_setopt($ch, CURLOPT_URL, $person_get_url);

    file_put_contents( "/tmp/rc", "before find: " . $email . "\n", FILE_APPEND );
	# execute the session and receive its response
	$response = curl_exec($ch);
    file_put_contents( "/tmp/rc", "after find: " . $email . "\n", FILE_APPEND );
	$GLOBALS['xml_status'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    file_put_contents( "/tmp/rc", "response for find: " . $response . "\n", FILE_APPEND );

	#Return the id of the person
	preg_match('/<id.*?>(.+?)<\/id>/', $response, $matches);
	if(count($matches) > 1){
        file_put_contents( "/tmp/rc", "results for search: " . print_r( $matches, true ) . "\n", FILE_APPEND );
		return $matches[1];
	} else {
		return null;
	}
}
	
?>