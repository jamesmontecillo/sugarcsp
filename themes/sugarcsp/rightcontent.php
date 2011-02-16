</div> <!-- END OF ctnContent -->
    <div class="rightCtn left">
        <div class="ctnTop">
            <div class="avatar">
            	<img src="images/profile_placeholder.png" alt="profile_pic" />
            </div>
            <div class="menu mediumFont">
                <ul>
                    <li>
                    <a class="hide top">+ <?PHP echo $_SESSION['fullname']; ?></a>
                    <!--[if lte IE 6]><a href="#"><?PHP echo $_SESSION['fullname']; ?><table><tr><td><![endif]-->
                    <ul>
                    <li><a href="index.php?module=settings&action=setting">Settings</a></li>
                    <li><a href="index.php?module=myquestions&action=myquestions">my Questions</a></li>
                    <li><a href="index.php?module=ideas&action=myideas">my Ideas</a></li>
                    <li><a href="index.php?module=myproblems&action=myproblems">my Problems</a></li>
                    <li><a href="index.php?module=Users&action=Logout">Log Out</a></li>
                    </ul>
                    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                    </li>
                </ul>
            </div>
    	</div>
        <!-- END OF RIGHT CONTENT TOP -->
        <div class="mTop30">
            <div class="sidebar">
                <h3>Additional support links</h3>
                <div class="supportlinks">
                    <img src="images/twitter-logo-square-webtreatsetc.png" alt="twitter_icon" width="25" height="25" align="left" />
                    <a href="http://www.twitter.com/remotelinkinc" target="_blank">Twitter</a>
                </div>
                <div class="supportlinks">
                    <img src="images/facebook-logo-square-webtreatsetc.png" alt="twitter_icon" width="25" height="25" align="left" />
                    <a href="http://www.facebook.com/RemoteLink" target="_blank">Facebook</a>
                </div>
                <div class="supportlinks">
                    <img src="images/gmail-logo-square2-webtreatsetc.png" alt="twitter_icon" width="25" height="25" align="left" />
                    <a href="mailto:support@remotelink.com">Email Support</a>
                </div>
                <div class="supportlinks">
                    <img src="images/wordpress-logo-square-webtreatsetc.png" alt="twitter_icon" width="25" height="25" align="left" />
                    <a href="http://www.remotelink.com" target="_blank">Website</a>
                </div>
            </div>

        </div>
    </div><!-- END OF rightCtn -->
</div><!-- END OF page -->
</div><!-- END OF contentWrapper -->