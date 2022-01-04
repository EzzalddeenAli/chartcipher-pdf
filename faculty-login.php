<? 
$nologin = 1;
$choosing = 1;
require_once "hsdmgdb/connect{$mybychart}.php";
require_once "functions{$mybychart}.php";

$autosuggesttables = array();
?>
<? 
if( $login )
{
    if( $password == "bcm-faculty-2016" )
    {
//    mysql> create table proxylogins ( id integer primary key auto_increment, userid integer, email varchar( 255 ), type varchar( 255 ) );
        $ins = db_query_first_cell( "select id from proxylogins where email = '" . escMe( $email ) . "' and type = 'faculty' and userid = '{$user[user_id]}'" );
        
        if( !$ins )
        {
            $ins = db_query_insert_id( "insert into proxylogins ( userid, email, type, dateadded ) values ( '{$user[user_id]}', '" . escMe( $email ) . "', 'faculty', now() )" );
        }
        setcookie( "proxyloginid", "$ins", time() + 90000000, "/", ".chartcipher.com" );
        setcookie( "proxylogintype", "faculty", time() + 90000000, "/", ".chartcipher.com" );
        Header( "Location: index.php" );
    }
    else
    {
        $err = "<font color='red'>Incorrect password.</font>";
    }
}

?>
<?php include 'academic/header-login.php';?>

<link href="/assets/css/berklee.css" type="text/css" rel="stylesheet" />
	<div class="site-body site-faculty-body">
		<section class="faculty-section padding-tb">
			<div class="element-container row">
				<div class="faculty-container">
					<h1>WELCOME TO IMMERSION</h1>
					<div class="faculty-login">
						<div class="faculty-login-header">
							<h2>Faculty Login</h2>
						</div><!-- ./faculty-login-header -->
						<div class="faculty-login-body">
							<form class="search-form" method='post'>
<?=$err?>
								<p>Please enter your email address and password and agree to the terms and conditions to access the Immersion database.</p>

								<div class="form-row-full">
									<label>E-Mail Address</label>
									<input type="text" name='email' placeholder="E-Mail Address" />
								</div><!-- /.form-row-full -->
								<div class="form-row-full">
									<label>Password</label>
									<div class="remember">If you do not remember your password please contact the University library.</div>
									<input type="password" name='password' placeholder="Password" />
								</div>

								<span style="color:#ff6633;">*</span>Terms and Conditions

								<div class="i-agree">
									<input type="checkbox" name="agree" value="true" id="agree">
									I agree to the Chart Cipher <a href="https://editorial.chartcipher.com/terms" >terms and conditions.</a>
								</div>

								<div class="form-row-full">
									<input type="submit" value="Login" name='login' id="login-btn" />
								</div>
								<div class="cf"></div>
							</form>	

						</div><!-- ./faculty-login-body -->
					</div><!-- /.faculty-login -->

				</div><!-- /.faculty-login-container -->
			</div><!-- /.element-container -->
		</section>
 	</div><!-- /.site-body -->
    <script>
	jQuery(document).ready(function($){
	
	$.validator.setDefaults({
		errorElement: 'div',
		
	});
	
	$('.search-form').validate({
		
		rules: {
              'email': { required: true },
                    'password': { required: true },
			'agree': { required: true }
		}
		});
	});
	
	</script>
                                                                        
<?php include 'footer.php';?> 	