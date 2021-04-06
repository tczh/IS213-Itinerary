<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
<link href="https://fonts.googleapis.com/css?family=Alegreya+Sans:100,100i,300,300i,400,400i,500,500i,700,700i,800,800i,900,900i" rel="stylesheet">
<style>
/* start of footer css */
.site-footer
{
background-color:#11233c;
padding:45px 0 20px;
font-size:15px;
line-height:24px;
color:#fff;
}
.site-footer hr
{
border-top-color:#bbb;
opacity:0.5
}
.site-footer hr.small
{
margin:20px 0
}
.site-footer h6
{
color:#fff;
font-size:16px;
text-transform:uppercase;
margin-top:5px;
letter-spacing:2px
}
.site-footer a
{
color:#737373;
}
.site-footer a:hover
{
color:#3366cc;
text-decoration:none;
}
.footer-links
{
padding-left:0;
list-style:none
}
.footer-links li
{
display:block
}
.footer-links a
{
color:#fff
}
.footer-links a:active,.footer-links a:focus,.footer-links a:hover
{
color:#3366cc;
text-decoration:none;
}
.footer-links.inline li
{
display:inline-block
}
.site-footer .social-icons
{
text-align:right
}
.site-footer .social-icons a
{
width:40px;
height:40px;
line-height:40px;
margin-left:6px;
margin-right:0;
border-radius:100%;
background-color:#33353d
}
.copyright-text
{
margin:0
}
@media (max-width:991px)
{
.site-footer [class^=col-]
{
  margin-bottom:30px
}
}
@media (max-width:767px)
{
.site-footer
{
  padding-bottom:0
}
.site-footer .copyright-text,.site-footer .social-icons
{
  text-align:center
}
}
.social-icons
{
padding-left:0;
margin-bottom:0;
list-style:none
}
.social-icons li
{
display:inline-block;
margin-bottom:4px
}
.social-icons li.title
{
margin-right:15px;
text-transform:uppercase;
color:#96a2b2;
font-weight:700;
font-size:13px
}
.social-icons a{
background-color:#eceeef;
color:#818a91;
font-size:16px;
display:inline-block;
line-height:44px;
width:44px;
height:44px;
text-align:center;
margin-right:8px;
border-radius:100%;
-webkit-transition:all .2s linear;
-o-transition:all .2s linear;
transition:all .2s linear
}
.social-icons a:active,.social-icons a:focus,.social-icons a:hover
{
color:#fff;
background-color:#29aafe
}
.social-icons.size-sm a
{
line-height:34px;
height:34px;
width:34px;
font-size:14px
}
.social-icons a.facebook:hover
{
background-color:#3b5998
}
.social-icons a.twitter:hover
{
background-color:#00aced
}
.social-icons a.linkedin:hover
{
background-color:#007bb6
}
.social-icons a.dribbble:hover
{
background-color:#ea4c89
}
@media (max-width:767px)
{
.social-icons li.title
{
  display:block;
  margin-right:0;
  font-weight:600
}
}

/* end of footer css */

/* Start of header css */
/* .site-header {
background-color:#33353d;
color:#fff
} */

.main-menubox {
  display: none;
}

.main-menu:hover .main-menubox{
  display: block;
}


.dropdown-submenu{
  position: relative;
}
.dropdown-submenu a::after{
  transform: rotate(-90deg);
  position: absolute;
  right: 3px;
  top: 40%;
}
.dropdown-submenu:hover .dropdown-menu, .dropdown-submenu:focus .dropdown-menu{
  display: flex;
  flex-direction: column;
  position: absolute !important;
  margin-top: -30px;
  left: 100%;
}
@media (max-width: 992px) {
  .dropdown-menu{
      width: 50%;
  }
  .dropdown-menu .dropdown-submenu{
      width: auto;
  }

  .dropdown-menu{ left: -131%;}
}

.dropdown-submenu a::after {
  right: 16px;
  top: 42%;
}

.dropdown-item {
  padding: 8px 18px;
}

  .dropdown-item{white-space: normal}

  .navbar-expand-lg .navbar-nav .dropdown-menu {
  font-size: 14px;
}

.dropdown-item:focus, .dropdown-item:hover {
  color: #dcdcdc;
  text-decoration: none;
  background-color: #11233c ;
}

li.nav-item{    padding: 10px 20px;}

/* change the background color */
/* .navbar-custom .navbar .navbar-nav .navbar-expand-lg{
  background-color: #33353d !important;
} */
/* change the brand and text color */
/* .navbar-custom .navbar-brand,
.navbar-custom  .navbar-text {
  color: rgba(155, 84, 84, 0.8);
} */
/* change the link color */
/* .navbar-custom .navbar-nav .nav-link {
  color: rgba(255,255,255,.5);
} */
/* change the color of active or hovered links */
.nav-item.active .nav-link,
.nav-item:focus .nav-link,
.nav-item:hover .nav-link {
  color: #ffffff;
}

.site-header h6
{
color:#fff;
font-size:12px;
text-transform:uppercase;
margin-top:5px;
letter-spacing:2px
}

.img-responsive {
  height: auto;
  width: auto;
  max-height: 72px;
  max-width: 250px;
}

.custom-toggler.navbar-toggler {
border-color: white;
}
/* Setting the stroke to green using rgb values (0, 128, 0) */
        
.custom-toggler .navbar-toggler-icon {
 background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(220, 220, 220, 1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
}
/* End of header css */
</style>

<!-- start of header -->
<header class="site-header">
      <nav class="navbar navbar-expand-lg navbar-custom navbar-static-top" id="mainNav" style="background-color: #11233c; padding: 0;">
      <div class="container-fluid">
        <a class="navbar-brand js-scroll-trigger" href="index.html">
          <h2></h2>
         <img class="img-responsive" src="images/esd_icon.png" >
         <img class="img-responsive" src="images/esd_icon_words.png" >
        </a>
        
        <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation" >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.html"><h6>Home</h6> <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><h6>About Us</h6></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><h6>Create Itinerary</h6></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><h6>View Itinerary</h6></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><h6>Account</h6></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><h6>Cart</h6></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><h6>Signout</h6></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    </header>
    
    <!-- end of header -->

<!-- Site footer -->
<footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <h6>About</h6>
            <p class="text-justify">Odyssey's Itineraries aims to make planing for your next trip as smooth as possible.</p>
          </div>

          <!-- <div class="col-xs-6 col-md-3">
            <h6>Categories</h6>
            <ul class="footer-links">
              <li><a href="http://scanfcode.com/category/c-language/">C</a></li>
              <li><a href="http://scanfcode.com/category/front-end-development/">UI Design</a></li>
              <li><a href="http://scanfcode.com/category/back-end-development/">PHP</a></li>
              <li><a href="http://scanfcode.com/category/java-programming-language/">Java</a></li>
              <li><a href="http://scanfcode.com/category/android/">Android</a></li>
              <li><a href="http://scanfcode.com/category/templates/">Templates</a></li>
            </ul>
          </div> -->

          <div class="col-xs-6 col-md-3">
            <h6>Quick Links</h6>
            <ul class="footer-links">
              <li><a href="#">About Us</a></li>
              <li><a href="#">Contact Us</a></li>
              <li><a href="#">Contribute</a></li>
              <li><a href="#">Privacy Policy</a></li>
            </ul>
          </div>
        </div>
        <hr>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-sm-6 col-xs-12">
            <p class="copyright-text">Copyright &copy; 2021 All Rights Reserved by 
         <a href="#">Odyssey's Itineraries</a>.
            </p>
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12">
            <ul class="social-icons">
              <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
              <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
              <li><a class="dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>
              <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>   
            </ul>
          </div>
        </div>
      </div>
  </footer>