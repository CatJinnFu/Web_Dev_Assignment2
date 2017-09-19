<?php
// ===============================
// AUTHOR     : Dieter Schmid   
// CREATE DATE     : 18/09/2017 (added header)
// PURPOSE     : front page to web to website.
// SPECIAL NOTES:
// ===============================
// Change History:
//
//==================================
session_start();
require_once('php/search.php');
require_once('php/global-connect.php');
require_once('php/functions.php');
require_once('php/functions-login.php');
require_once('php/checkout.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="robots" content="all,follow">
    <meta name="googlebot" content="index,follow,snippet,archive">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Obaju Your Fashion Shop">
    <meta name="author" content="Ondrej Svestka | ondrejsvestka.cz">
    <meta name="keywords" content="">

    <title>
        Obaju : Your Fashion Shop
    </title>

    <meta name="keywords" content="">

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100' rel='stylesheet' type='text/css'>

    <!-- styles -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">

    <!-- theme stylesheet -->
    <link href="css/style.default.css" rel="stylesheet" id="theme-stylesheet">

    <!-- your stylesheet with modifications -->
    <link href="css/custom.css" rel="stylesheet">

    <script src="js/respond.min.js"></script>

    <link rel="shortcut icon" href="favicon.png">
    <script type="text/javascript"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>     
    <script src="js/search.js"> </script> 
    <script src="js/checkout.js"> </script> 

   

</head>
<!-- There are no major changes to the html templates, looking back on teh assignment it could have been done with 1 single xsl file
     However i found it very hard to track errors in the xsl. So building it this way was easier
     
-->
<body onload="loadXMLDoc('clothes.xml',sideMenuBuild,'men','none');displayResult('brands_men.xsl');listItemsNumber(6);renderPages(1)">

     <!-- *** TOPBAR ***
 _________________________________________________________ -->
    <div id="top">
        <div class="container">
            <div class="col-md-6 offer" data-animate="fadeInDown">
                <a href="#" class="btn btn-success btn-sm" data-animate-hover="shake">Offer of the day</a>  <a href="#">Get flat 35% off on orders over $500!</a>
            </div>
          <div class="col-md-6" data-animate="fadeInDown">

                <ul class="menu">
                   
                    <li><a href="register.php?action=login" data-toggle="modal" data-target="#login-modal"><?php if(getName()==' ') {echo "Login";} else {echo "Logged In";}?></a>
                    </li>
                    <li><a href="register.php"><?php if(getName() == ' ') {echo "Register";} else {echo "Register Account";}?></a>
                    </li>
                    <li><a href="contact.php">Contact</a>
                    </li>
                     <li style="color:white;">  <?php echo getName(); ?> </li>
                    
                </ul>
            </div>
        </div>
        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
            <div class="modal-dialog modal-sm">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="Login">Customer login</h4>
                    </div>
                    <div class="modal-body">
               <form action="register.php?action=login" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" id="email-modal" placeholder="email" name="email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password-modal" placeholder="password" name="password">
                            </div>

                            <p class="text-center">
                                <button class="btn btn-primary"><i class="fa fa-sign-in"></i> Log in</button>
                            </p>

                        </form>

                        <p class="text-center text-muted">Not registered yet?</p>
                        <p class="text-center text-muted"><a href="register.php"><strong>Register now</strong></a>! It is easy and done in 1&nbsp;minute and gives you access to special discounts and much more!</p>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- *** TOP BAR END *** -->

    <!-- *** NAVBAR ***
 _________________________________________________________ -->

    <div class="navbar navbar-default yamm" role="navigation" id="navbar">
        <div class="container">
            <div class="navbar-header">

                <a class="navbar-brand home" href="index.php" data-animate-hover="bounce">
                    <img src="img/logo.png" alt="Obaju logo" class="hidden-xs">
                    <img src="img/logo-small.png" alt="Obaju logo" class="visible-xs"><span class="sr-only">Obaju - go to homepage</span>
                </a>
                <div class="navbar-buttons">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-align-justify"></i>
                    </button>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#search">
                        <span class="sr-only">Toggle search</span>
                        <i class="fa fa-search"></i>
                    </button>
                    <a class="btn btn-default navbar-toggle" href="basket.php">
                        <i class="fa fa-shopping-cart"></i>  <span class="hidden-xs" id='items'></span>
                    </a>
                </div>
            </div>
            <!--/.navbar-header -->

            <div class="navbar-collapse collapse" id="navigation">

                <ul class="nav navbar-nav navbar-left">
                    <li class="active"><a href="index.php">Home</a>
                    </li>
                                                        
                    <li class="dropdown yamm-fw">
                        <a href="category-man.php?#6" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="200">Men <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <div class="col-sm-6"> <!-- col-sm-3 is changed to col-sm-6 by Shang-->
                                            <h5>Clothing</h5>
                                            <ul>
                                                <li><a href='category-man.php?cType=T-shirt' onclick='loadXMLDoc('clothes.xml',loadItems,'men','none')' >T-shirts</a>
                                                </li>
                                                <li><a href='category-man.php?cType=Shirt' onclick='loadXMLDoc('clothes.xml',loadItems,'men','none')'>Shirts</a>
                                                </li>                                               
                                                <li><a href='category-man.php?cType=Pants' onclick='loadXMLDoc('clothes.xml',loadItems,'men','none')'>Pants</a>
                                                </li>                                               
                                                
                                                <li><a href='category-man.php?cType=Accessories' onclick='loadXMLDoc('clothes.xml',loadItems,'men','none')'>Accessories</a>
                                                </li>
                                                
                                            </ul>
                                        </div>
                                        <!--<div class="col-sm-3">onclick='loadXMLDoc('clothes.xml',loadItems,'men','none')'
                                            <h5>Shoes</h5>
                                            <ul>
                                                <li><a href="category.php">Trainers</a>
                                                </li>
                                                <li><a href="category.php">Sandals</a>
                                                </li>
                                                <li><a href="category.php">Hiking shoes</a>
                                                </li>
                                                <li><a href="category.php">Casual</a>
                                                </li>
                                            </ul>
                                        </div> commented by Shang 03/07/2017-->
                                        <div class="col-sm-6"> <!-- col-sm-3 is changed to col-sm-6 by Shang-->
                                            <h5>Accessories</h5>
                                            <ul>
                                                <li><a href="category-man.php?cType=bag" onclick='loadXMLDoc('clothes.xml',loadItems,'men','none')'>Bags</a>
                                                </li>
                                                <li><a href="category-man.php?cType=belt" onclick='loadXMLDoc('clothes.xml',loadItems,'men','none')'>Belts</a>
                                                </li>
                                                <!--
                                                <li><a href="category.php">Hiking shoes</a>
                                                </li>
                                                <li><a href="category.php">Casual</a>
                                                </li>
                                                <li><a href="category.php">Hiking shoes</a>
                                                </li>
                                                <li><a href="category.php">Casual</a>
                                                </li>
                                                -->
                                            </ul>
                                        </div>
                                        <!--<div class="col-sm-3">
                                            <h5>Featured</h5>
                                            <ul>
                                                <li><a href="category.php">Trainers</a>
                                                </li>
                                                <li><a href="category.php">Sandals</a>
                                                </li>
                                                <li><a href="category.php">Hiking shoes</a>
                                                </li>
                                            </ul>
                                            <h5>Looks and trends</h5>
                                            <ul>
                                                <li><a href="category.php">Trainers</a>
                                                </li>
                                                <li><a href="category.php">Sandals</a>
                                                </li>
                                                <li><a href="category.php">Hiking shoes</a>
                                                </li>
                                            </ul>
                                        </div> commented by shang 03/07/2017-->
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown yamm-fw">
                        <a href="category-lady.php?#6" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="200">Ladies <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <div class="col-sm-6"> <!-- col-sm-3 is changed to col-sm-6 by Shang-->
                                            <h5>Clothing</h5>
                                            <ul>
                                                <li><a href='category-lady.php?cType=T-shirt'onclick='loadXMLDoc('clothes.xml',loadItems,'ladies','none')'>T-shirts</a>
                                                </li>
                                                <li><a href='category-lady.php?cType=Shirt'onclick='loadXMLDoc('clothes.xml',loadItems,'ladies','none')'>Shirts</a>
                                                </li>
                                                <li><a href='category-lady.php?cType=Pants'onclick='loadXMLDoc('clothes.xml',loadItems,'ladies','none')'>Pants</a>
                                                </li>

                                                
                                                <li><a href='category-lady.php?cType=Accessories' 
                                                onclick='loadXMLDoc('clothes.xml',loadItems,'ladies','none')'> Accessories</a>
                                                </li>
                                                <!--
                                                <li><a href="category-lady.php">Accessories</a>
                                                </li>
                                                -->
                                            </ul>
                                        </div>
                                        <!-- <div class="col-sm-3">
                                            <h5>Shoes</h5>
                                            <ul>
                                                <li><a href="category.php">Trainers</a>
                                                </li>
                                                <li><a href="category.php">Sandals</a>
                                                </li>
                                                <li><a href="category.php">Hiking shoes</a>
                                                </li>
                                                <li><a href="category.php">Casual</a>
                                                </li>
                                            </ul>
                                        </div>  commented by Shang 03/07/2017-->
                                        <div class="col-sm-6"> <!-- col-sm-3 is changed to col-sm-6 by Shang-->
                                            <h5>Accessories</h5>
                                            <ul>
                                               <li><a href="category-lady.php?cType=bag" onclick='loadXMLDoc('clothes.xml',loadItems,'ladies','none')>Bags</a>
                                                </li>
                                                <li><a href="category-lady.php?cType=belt" onclick='loadXMLDoc('clothes.xml',loadItems,'ladies','none')>Belts</a>
                                                </li>
                                                <!--
                                                <li><a href="category.php">Hiking shoes</a>
                                                </li>
                                                <li><a href="category.php">Casual</a>
                                                </li>
                                                <li><a href="category.php">Hiking shoes</a>
                                                </li>
                                                <li><a href="category.php">Casual</a>
                                                </li>
                                                -->
                                            </ul>
                                            <!--<h5>Looks and trends</h5>
                                            <ul>
                                                <li><a href="category.php">Trainers</a>
                                                </li>
                                                <li><a href="category.php">Sandals</a>
                                                </li>
                                                <li><a href="category.php">Hiking shoes</a>
                                                </li>
                                            </ul> commented by Shang 03/07/2017-->
                                        </div>
                                        <!--<div class="col-sm-3">
                                            <div class="banner">
                                                <a href="#">
                                                    <img src="img/banner.jpg" class="img img-responsive" alt="">
                                                </a>
                                            </div>
                                            <div class="banner">
                                                <a href="#">
                                                    <img src="img/banner2.jpg" class="img img-responsive" alt="">
                                                </a>
                                            </div>
                                        </div> commented by Shang 03/07/2017-->
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown yamm-fw">
                        <a href="category-man.php?#6" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="200">Site <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h5>Shop</h5>
                                            <ul>
                                                <li><a href="index.php">Homepage</a>
                                                </li>
                                                <li><a href="category-man.php">Category - men</a>
                                                </li>
                                                <li><a href="category-lady.php">Category - ladies</a>
                                                </li>                                                 
                                                <!--
                                                <li><a href="category.php">Category - sidebar left</a>
                                                </li>
                                                <li><a href="category-full.php">Category - full width</a>
                                                </li> 
                                                <li><a href="detail.php">Product detail</a>
                                                </li> 
                                                -->
                                            </ul>
                                        </div>
                                        <div class="col-sm-3">
                                            <h5>User</h5>
                                            <ul>
                                                <li><a href="register.php">Register / login</a>
                                              
                                            </ul>
                                        </div>
                                        <div class="col-sm-3">
                                            <h5>Order process</h5>
                                            <ul>
                                                <li><a href="basket.php">Shopping cart</a>
                                                </li>
                                                <!--
                                                <li><a href="checkout1.php">Checkout - step 1</a>
                                                </li>
                                                <li><a href="checkout2.php">Checkout - step 2</a>
                                                </li>
                                                <li><a href="checkout3.php">Checkout - step 3</a>
                                                </li>
                                                <li><a href="checkout4.php">Checkout - step 4</a>
                                                </li>
                                                commented by Shang 03/07/2017-->
                                            </ul>
                                        </div>
                                        <div class="col-sm-3">
                                            <h5>Information</h5>
                                            <ul>                                                
                                                <li><a href="aboutus.php">About us</a>
                                                </li>
                                                <li><a href="terms.php">Terms and conditions</a>
                                                </li>
                                                <li><a href="faq.php">FAQ</a>
                                                </li>                                                                                                
                                                <li><a href="contact.php">Contact</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
            <!--/.nav-collapse -->

            <div class="navbar-buttons">

                <div class="navbar-collapse collapse right" id="basket-overview">
                    <a href="basket.php" class="btn btn-primary navbar-btn"><i class="fa fa-shopping-cart"></i><span class="hidden-sm"><?php echo itemsCart(); ?></span></a>
                </div>
                <!--/.nav-collapse -->

                <div class="navbar-collapse collapse right" id="search-not-mobile">
                    <button type="button" class="btn navbar-btn btn-primary" data-toggle="collapse" data-target="#search">
                        <span class="sr-only">Toggle search</span>
                        <i class="fa fa-search"></i>
                    </button>
                </div>

            </div>

            <div class="collapse clearfix" id="search">

                 <form class="navbar-form" role="search">
                    <div class="input-group">
                        <input list="searches" class="form-control" placeholder="Search" id="search_content" >
                        <datalist id="searches" autocomplete="off">
                        </datalist >
                        <span class="input-group-btn">

            <button type="button" class="btn btn-primary" id="search_button" onclick="makeSearch()"><i class="fa fa-search"></i></button>

            </span>
                    </div>
                </form>

            </div>
            <!--/.nav-collapse -->

        </div>
        <!-- /.container -->
    </div>
    <!-- /#navbar -->

    <!-- *** NAVBAR END *** -->

    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="index.php">Home</a>
                        </li>
                        <li>Men</li>
                    </ul>
                </div>

                <div class="col-md-3">
                    <!-- *** MENUS AND FILTERS ***
 _________________________________________________________ -->
                    <div class="panel panel-default sidebar-menu" id='catergory_menu' />

                   <div class="panel-heading">
                            <h3 class="panel-title">Categories</h3>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked category-menu" >
                                <li class="active"  id="men_list" >
                                 <a href="category-man.php?#6" >Men <span class="pa pull-right"></span></a>
                                    <ul>
                                        <li><a href="category-man.php?cType=T-shirt">T-shirts</a>
                                        </li>
                                        <li><a href="category-man.php?cType=Shirt">Shirts</a>
                                        </li>
                                        <li><a href="category-man.php?cType=Pants">Pants</a>
                                        </li>
                                        <li><a href="category-man.php?cType=Accessories">Accessories</a>
                                        </li>
                                    </ul>
                                </li>
                                <li id="lady_list">
                                    <a href="category.php#6">Ladies  <span class="badge pull-right"></span></a>
                                    <ul>
                                        <li><a href="category-lady.php?cType=T-shirt">T-shirts</a>
                                        </li>
                                        <li><a href="category-lady.php?cType=Shirt">Shirts</a>
                                        </li>
                                        <li><a href="ccategory-lady.php?cType=Pants">Pants</a>
                                        </li>
                                        <li><a href="category-lady.php?cType=Accessories">Accessories</a>
                                        </li>
                                    </ul>
                                </li>
                                <!--
                                <li>
                                    <a href="category.php">Kids  <span class="badge pull-right">11</span></a>
                                    <ul>
                                        <li><a href="category.php">T-shirts</a>
                                        </li>
                                        <li><a href="category.php">Shirts</a>
                                        </li>
                                        <li><a href="category.php">Pants</a>
                                        </li>
                                        <li><a href="category.php">Accessories</a>
                                        </li>
                                    </ul>
                                </li>
                                commented by Shang 03/07/2017 -->

                            </ul> 
                            </div>
                        </div>
                    

                    <div class="panel panel-default sidebar-menu" id="brands_menu">

                        <div class="panel-heading" >
                            <h3 class="panel-title">Brands <a class="btn btn-xs btn-danger pull-right" href="#" onclick='clearBrands()'>
                            <i class="fa fa-times-circle"  ></i> Clear</a></h3>
                        </div>

                        <div class="panel-body" >
                        
                            <form id="brands"  >
                                <!--<div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox">Armani (10)
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox">Versace (10)
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="Carlo">
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox">Jack Honey (2)
                                        </label>
                                    </div>
                                </div>

                                <button class="btn btn-default btn-sm btn-primary"><i class="fa fa-pencil"></i> Apply</button>-->

                            </form>

                        </div>
                    </div> 

                    

                    <!-- *** MENUS AND FILTERS END *** -->

                    <div class="banner">
                        <a href="category-man.php?#6">
                            <img src="img/banner.jpg" alt="sales 2014" class="img-responsive">
                        </a>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="box">
                        <h1>Men</h1>
                        <p>In our Men department we offer wide selection of the best products we have found and carefully selected worldwide.</p>
                    </div>

                    <div class="box info-bar">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 products-showing" id='showOf'>
                                <!--Showing <strong>6</strong> of <strong>12</strong> products-->
                            </div>

                            <div class="col-sm-12 col-md-8  products-number-sort">
                                <div class="row">
                                    <form class="form-inline">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="products-number" id='showSix'>
                                                <strong>Show</strong>  <a href="category-man.php?#6" class="btn btn-default btn-sm btn-primary" onclick="listItemsNumber(6,'men')">6</a>  
                                                <a href="category-man.php?#12" class="btn btn-default btn-sm" onclick="listItemsNumber(12,'men')">12</a>  
                                                <a href="category-man.php?#All" class="btn btn-default btn-sm" onclick="listItemsNumber(0,'men')">All products</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="products-sort-by">
                                                <strong>Sort by</strong>
                                                <select name="sort-by" class="form-control" id="price" onclick="loadXMLDoc('clothes.xml',loadItems,'men','none')">
                                                    <option>Price: low-high</option>
                                                    <option>Price: high-low</option>
                                                    <!--<option>Sales first</option>-->
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row products" id="frontproduct">
                    </div>

                     
               
                    <div class="pages">

                        <!-- commented by shang 04/07/2017 
                        <p class="loadMore">
                            <a href="#" class="btn btn-primary btn-lg"><i class="fa fa-chevron-down"></i> Load more</a>
                        </p>
                         end of comment -->

                        <ul class="pagination" id="pages">
                           <!-- <li><a href="#">&laquo;</a>
                            </li>
                            <li class="active" onclick='renderPages()'><a href="#">1</a>
                            </li>
                            <li><a href="#">2</a>
                            </li>
                            <li><a href="#">3</a>
                            </li>
                            <li><a href="#">4</a>
                            </li>
                            <li><a href="#">5</a>
                            </li>
                            <li><a href="#">&raquo;</a>
                            </li>-->
                        </ul>
                    </div>


                </div>
                <!-- /.col-md-9 -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->


        <!-- *** FOOTER ***
 _________________________________________________________ -->
        <div id="footer" data-animate="fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <h4>Information</h4>

                        <ul>
                            <li><a href="aboutus.php">About us</a>
                            </li>
                            <li><a href="terms.php">Terms and conditions</a>
                            </li>
                            <li><a href="faq.php">FAQ</a>
                            </li>
                            <li><a href="contact.php">Contact us</a>
                            </li>
                        </ul>

                        <hr>

                        <h4>User section</h4>

                        <ul>
                            <li><a href="#" data-toggle="modal" data-target="#login-modal">Login</a>
                            </li>
                            <li><a href="register.php">Register</a>
                            </li>
                        </ul>

                        <hr class="hidden-md hidden-lg hidden-sm">

                    </div>
                    <!-- /.col-md-3 -->

                    <div class="col-md-3 col-sm-6">

                        <h4>Top categories</h4>

                           <h5>Men</h5>

                        <ul>
                            <li><a href="category-man.php?cType=T-shirt">T-shirts</a>
                            </li>
                            <li><a href="category-man.php?cType=Shirt">Shirts</a>
                            </li>
                            <li><a href="category-man.php?cType=Pants">Pants</a>
                            </li>
                            <li><a href="category-man.php?cType=Accessories">Accessories</a>
                            </li>
                        </ul>

                        <h5>Ladies</h5>
                        <ul>
                            <li><a href="category-lady.php?cType=T-shirt">T-shirts</a>
                            </li>
                            <li><a href="category-lady.php?cType=Shirt">Shirts</a>
                            </li>
                            <li><a href="category-lady.php?cType=Pants">Pants</a>
                            </li>
                            <li><a href="category-lady.php?cType=Accessories">Accessories</a>
                            </li>
                        </ul>

                        <hr class="hidden-md hidden-lg">

                    </div>
                    <!-- /.col-md-3 -->

                    <div class="col-md-3 col-sm-6">

                        <h4>Where to find us</h4>

                        <p><strong>Obaju Ltd.</strong>
                            <br>500 Main Street
                            <br>Geelong
                            <br>Victoria 3200
                            <br>
                            <strong>Australia</strong>
                        </p>

                        <a href="contact.php">Go to contact page</a>

                        <hr class="hidden-md hidden-lg">

                    </div>
                    <!-- /.col-md-3 -->



                    <div class="col-md-3 col-sm-6">

                        
                        <h4>Stay in touch</h4>

                        <p class="social">
                            <a href="#" class="facebook external" data-animate-hover="shake"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="twitter external" data-animate-hover="shake"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="instagram external" data-animate-hover="shake"><i class="fa fa-instagram"></i></a>
                            <a href="#" class="gplus external" data-animate-hover="shake"><i class="fa fa-google-plus"></i></a>
                            <a href="#" class="email external" data-animate-hover="shake"><i class="fa fa-envelope"></i></a>
                        </p>


                    </div>
                    <!-- /.col-md-3 -->

                </div>
                <!-- /.row -->

            </div>
            <!-- /.container -->
        </div>
        <!-- /#footer -->

        <!-- *** FOOTER END *** -->




        <!-- *** COPYRIGHT ***
 _________________________________________________________ -->
        <div id="copyright">
            <div class="container">
                <div class="col-md-6">
                    <p class="pull-left">© 2017 Obaju Ltd.</p>

                </div>
                <div class="col-md-6">
                    <p class="pull-right">Template by <a href="https://bootstrapious.com/e-commerce-templates">Bootstrapious.com</a>
                         <!-- Not removing these links is part of the license conditions of the template. Thanks for understanding :) If you want to use the template without the attribution links, you can do so after supporting further themes development at https://bootstrapious.com/donate  -->
                    </p>
                </div>
            </div>
        </div>
        <!-- *** COPYRIGHT END *** -->



    </div>
    <!-- /#all -->


    



    <!-- *** SCRIPTS TO INCLUDE ***
 _________________________________________________________ -->
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/modernizr.js"></script>
    <script src="js/bootstrap-hover-dropdown.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/front.js"></script>
    <script src="js/template.js"></script>






</body>

</html>