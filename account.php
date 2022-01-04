<?php 
include 'header.php';
	
$allprods = getAllAmemberProducts();
    //print_r( $allprods );
$prods = getMyImmersionProducts();
foreach( $prods as $p ){
    $pname = $allprods[$p["product_id"]];
    $pexpire = date( "m/d/Y", strtotime( $p["expire_date"] ) );
    
}
?>
	
	<div class="site-body">
		<section class="account">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
						<h1>MY ACCOUNT</h1>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
						<div class="account-header">
							<h1><?=$user["name_f"] . " " . $user["name_l"] ?></h1>
						</div><!-- /.account-header -->
						<div class="account-block account-block-1 span-3">
							<p>Subscription Level</p>
							<h2><?=$pname?></h2>
						</div><!-- /.account-block-1 -->
						<div class="account-block account-block-2 span-3">
							<p>Renewal Date</p>
							<h2><?=$pexpire?></h2>
						</div><!-- /.account-block-2 -->
						<div class="account-block account-block-3 span-3">
							<p>User Name</p>
							<h2><?=$user["login"]?></h2>
							<a class="edit-pw" href="/editpassword">Edit Password</a>
						</div><!-- /.account-block-3 -->
						<div class="account-footer">
							<p>To cancel your subscription, please email<br/><a href="mailto:customerservice@chartcipher.com">customerservice@chartcipher.com</a></p>
						</div><!-- /.account-header -->

						<?php /*
							<table width="100%">
							<tr><th>Product</th><th>Expires</th>
								<? 
								$allprods = getAllAmemberProducts();
								//print_r( $allprods );
								$prods = getMyImmersionProducts();
								foreach( $prods as $p ){
								//    print_r( $p );
								?>
								<tr><td><?=$allprods[$p["product_id"]]?></td>
								<td><?=$p["expire_date"]?></td>
								     </tr>
								<?php
								}
								?>
							</table>
						*/
						?>

					</div><!-- /search-body -->
				</div><!-- /.info-container -->
			</div>
		</section><!-- /.account -->
	</div><!-- /.site-body -->
<?php include 'footer.php';?>