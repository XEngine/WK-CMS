<?php
  /**
   * Footer
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
 
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<!-- Footer -->
<footer id="footer">
  <div class="footer-top">
    <div class="container">
      <div class="row sidebar">
		<aside class="col-xs-12 col-sm-6 col-md-3 widget social">
		  <div class="title-block">
			<h3 class="title">Follow Us</h3>
		  </div>
          <p>Follow us in social media</p>
          <div class="social-list">
			<a class="icon rounded icon-facebook" href="#"><i class="fa fa-facebook"></i></a>
			<a class="icon rounded icon-twitter" href="#"><i class="fa fa-twitter"></i></a>
			<a class="icon rounded icon-google" href="#"><i class="fa fa-google"></i></a>
			<a class="icon rounded icon-linkedin" href="#"><i class="fa fa-linkedin"></i></a>
		  </div>
		  <div class="clearfix"></div>
        </aside>

		<aside class="col-xs-12 col-sm-6 col-md-3 widget newsletter">
		  <div class="title-block">
			<h3 class="title">Newsletter Signup</h3>
		  </div>
		  <div>
			<p>Sign up for newsletter</p>
			<div class="clearfix"></div>
			<form class="subscribe-form" method="post" action="http://template.progressive.itembridge.com/php/subscribe.php">
			  <input class="form-control email" type="email" name="subscribe">
			  <button class="submit">
				<span class="glyphicon glyphicon-arrow-right"></span>
			  </button>
			  <span class="form-message" style="display: none;"></span>
			</form>
		  </div>
		</aside><!-- .newsletter -->
		
		<aside class="col-xs-12 col-sm-6 col-md-3 widget links">
		  <div class="title-block">
			<h3 class="title">Information</h3>
		  </div>
		  <nav>
			<ul>
			  <li><a href="#">About us</a></li>
			  <li><a href="#">Privacy Policy</a></li>
			  <li><a href="#">Terms &amp; Condotions</a></li>
			  <li><a href="#">Secure payment</a></li>
			</ul>
		  </nav>
        </aside>
		
		<aside class="col-xs-12 col-sm-6 col-md-3 widget links">
		  <div class="title-block">
			<h3 class="title">My account</h3>
		  </div>
		  <nav>
			<ul>
			  <li><a href="#">My account</a></li>
			  <li><a href="#">Order History</a></li>
			  <li><a href="#">Wish List</a></li>
			  <li><a href="#">Newsletter</a></li>
			</ul>
		  </nav>
        </aside>
      </div>
    </div>
  </div><!-- .footer-top -->
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="copyright col-xs-12 col-sm-3 col-md-3">
		  Copyright © Webkokteyli, <?php echo date('Y'); ?>
		</div>
		
        <div class="phone col-xs-6 col-sm-3 col-md-3">
          <div class="footer-icon">
			<svg x="0" y="0" width="16px" height="16px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
			  <path fill="#c6c6c6" d="M11.001,0H5C3.896,0,3,0.896,3,2c0,0.273,0,11.727,0,12c0,1.104,0.896,2,2,2h6c1.104,0,2-0.896,2-2
			   c0-0.273,0-11.727,0-12C13.001,0.896,12.105,0,11.001,0z M8,15c-0.552,0-1-0.447-1-1s0.448-1,1-1s1,0.447,1,1S8.553,15,8,15z
				M11.001,12H5V2h6V12z"></path>
			</svg>
		  </div>
          <strong class="title">Bizi Arayın :</strong> +1 (877) 123-45-67 <br>
          <strong>or</strong> +1 (777) 123-45-67
        </div>
		
        <div class="address col-xs-6 col-sm-3 col-md-3">
          <div class="footer-icon">
			<svg x="0" y="0" width="16px" height="16px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
			  <g>
				<g>
				  <path fill="#c6c6c6" d="M8,16c-0.256,0-0.512-0.098-0.707-0.293C7.077,15.491,2,10.364,2,6c0-3.309,2.691-6,6-6
					c3.309,0,6,2.691,6,6c0,4.364-5.077,9.491-5.293,9.707C8.512,15.902,8.256,16,8,16z M8,2C5.795,2,4,3.794,4,6
					c0,2.496,2.459,5.799,4,7.536c1.541-1.737,4-5.04,4-7.536C12.001,3.794,10.206,2,8,2z"></path>
				</g>
				<g>
				  <circle fill="#c6c6c6" cx="8.001" cy="6" r="2"></circle>
				</g>
			  </g>
			</svg>
		  </div>
          49 Archdale, 2B Charleston 5655, Excel Tower<br> OPG Rpad, 4538FH
        </div>
		
        <div class="col-xs-12 col-sm-3 col-md-3">
          <a href="#" class="up">
			<span class="glyphicon glyphicon-arrow-up"></span>
		  </a>
        </div>
      </div>
    </div>
  </div><!-- .footer-bottom -->
</footer>

<!-- Footer /-->
<?php if($core->analytics):?>
<!-- Google Analytics --> 
<?php echo cleanOut($core->analytics);?> 
<!-- Google Analytics /-->
<?php endif;?>