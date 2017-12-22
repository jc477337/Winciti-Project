<?php
include_once 'apps/db_connect.php';
include_once 'apps/functions.php';

sec_session_start();
?>

<!DOCTYPE html>
<!-- Template by Quackit.com -->
<!-- Images by various sources under the Creative Commons CC0 license and/or the Creative Commons Zero license. 
Although you can use them, for a more unique website, replace these images with your own. -->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Winciti</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS: You can use this stylesheet to override any Bootstrap styles and/or apply your own styles -->
    <link href="css/custom.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Logo and responsive toggle -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                	<img src="images/logo.jpg" width="110" height="55">
                </a>
            </div>
            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active">
                        <a href="./">Home</a>
                    </li>
                    <li>
                        <a href="./about.php">About Winciti</a>
                    </li>
					<li>
                        <a href="./programs.php">Beauty</a>
                    </li>
					<li>
                        <a href="./courses.php">Community Courses in Winciti</a>
                    </li>
					<li>
                        <a href="./operation_team.php">Daily Care</a>
                    </li>
					<li>
                        <a href="./community.php">Baby</a>
                    </li>
					<li>
                        <a href="./contact.php">Contact</a>
                    </li>
					<li>
						<?php if (login_check($mysqli) == true) : ?>
							
							<a href="apps/logout.php"><?php echo htmlentities($_SESSION['username']); ?> | Logout</a>
						<?php else : ?>
							<a href="apps/login.php">Log in | Register</a>
						<?php endif; ?>
                    </li>
					<li>
                        <a href="apps/search.php">Search</a>
                    </li>
                    <li>
                        <a href="./chart.php"><span class="glyphicon glyphicon-shopping-cart"></span> My Cart</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container -->
    </nav>


	<div class="jumbotron feature" >
		<div class="my-container">
			<table class="wsite-multicol-table">
      <tbody class="wsite-multicol-tbody">
        <tr class="wsite-multicol-tr">
          <td class="wsite-multicol-col" style="width:73%; padding:0 15px;">
            <h2 style="text-align:left;">
              <em>
                <font color="#E0915C" size="28px">Winciti Japanses Product</font>
              </em>
            </h2>
            <div class="paragraph" style="text-align:left;">
              
                <strong>
                  <font size="8px" color="#DA8044">in everyone's life</font>
                </strong>
              
            </div>
          </td>
          <td class="wsite-multicol-col" style="width:27%; padding:0 15px;">
           <!-- <div>
              <form enctype="multipart/form-data" action="formSubmitAjax.php" method="post"
              id="form-676881350554780154" accept-charset="UTF-8" target="form-676881350554780154-target-1503736248943">
                <div id="676881350554780154-form-parent" class="wsite-form-container" style="margin-top:10px;">
                  <div style="margin-left: 2em" class="formlist" id="676881350554780154-form-list">
                    <div>
                      <div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                        <label class="wsite-form-label" for="input-603662409657566987">Email 
                        <span class="form-required">*</span></label>
                        <div class="wsite-form-input-container">
                          <input id="input-603662409657566987" class="wsite-form-input wsite-input wsite-input-width-370px"
                          type="text" name="_u603662409657566987" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
				<div align='center'>
					<a class="wsite-button">
						<span class="wsite-button-inner">Notify Me</span>
					</a>
				</div>
              </form>
            </div> -->
          </td>
        </tr>
      </tbody>
    </table>
		</div>
	</div>

	<div class="my-container">
	<div class="jumbotron full-width-picture" style="height:450px;background: center  no-repeat url('images/banner.jpg')">

    </div><!-- /.container-fluid -->
	</div>

	

		
	<!-- Footer -->
	<footer>

		<!-- Footer Links -->
		<div class="footer-info">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 footer-info-item">
						<h3>Information</h3>
						<ul class="list-unstyled">
							<li><a href="#">About Us</a></li>
							<li><a href="#">Customer Service</a></li>
							<li><a href="#">Privacy Policy</a></li>
							<li><a href="#">Sitemap</a></li>
							<li><a href="#">Orders &amp; Returns</a></li>
						</ul>
					</div>
					<div class="col-sm-4 footer-info-item">
						<h3>My Account</h3>
						<ul class="list-unstyled">
							<li><a href="#">Sign In</a></li>
							<li><a href="#">View Cart</a></li>
							<li><a href="#">My Wishlist</a></li>
							<li><a href="#">Track My Order</a></li>
							<li><a href="#">Help</a></li>
						</ul>	
					</div>
					<div class="col-sm-4 footer-info-item">
						<h3><span class="glyphicon glyphicon-list-alt"></span> Newsletter</h3>
						<p>Sign up for exclusive offers.</p>
						<div class="input-group">
							<input type="email" class="form-control" placeholder="Enter your email address">
							<span class="input-group-btn">
								<button class="btn btn-primary" type="button">
									Subscribe!
								</button>
							</span>
						</div>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
        </div>
        
        <!-- Copyright etc -->
        <div class="small-print">
        	<div class="container">
        		<p><a href="#">Terms &amp; Conditions</a> | <a href="#">Privacy Policy</a> | <a href="#">Contact</a></p>
        		<p>Copyright &copy; Team 5 </p>
        	</div>
        </div>
        
	</footer>

	
    <!-- jQuery -->
    <script src="js/jquery-1.11.3.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
	<!-- IE10 viewport bug workaround -->
	<script src="js/ie10-viewport-bug-workaround.js"></script>
	
</body>

</html>
