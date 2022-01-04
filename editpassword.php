<?php 
include 'header.php';

if( $go )
{
//	echo( "updating password to: $newpassword" );
	$newpassword = Am_Lite::getInstance()->updateUserPass( $newpassword );
	$coo =  sha1($user["user_id"] . $user["login"] . md5($newpassword) );
    setcookie('amember_rp', $coo,
              time() + 60 * 3600 * 24, '/', ".chartcipher.com", false, false );

	$err = "<font color='red'>Password successfully updated.</font><br>";
}
?>
	
	<div class="site-body">
		<section class="account">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
						<h1>UPDATE PASSWORD</h1>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
<?=$err?>
					<form method='post'>
New Password: <input type='password' name='newpassword'> <input type='submit' name='go' value='Update'>
</form>
					</div><!-- /search-body -->
				</div><!-- /.info-container -->
			</div>
		</section><!-- /.account -->
	</div><!-- /.site-body -->
<?php include 'footer.php';?>