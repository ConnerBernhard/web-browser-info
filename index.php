<?php

session_start();

	require_once 'functions.php';

//require_once 'export.php';	



	global $specs;

	if($is_link = isset($_REQUEST['specs'])) {

		$linked_specs = urldecode($_REQUEST['specs']);

		$linked_specs = explode('|', $linked_specs);



		foreach($linked_specs as $linked_spec) {

			$linked_spec = explode('=', $linked_spec);

			$specs[$linked_spec[0]] = $linked_spec[1];

		}

		$specs['os_type'] = getOS_type($specs['os']);

		$specs['wb_type'] = get_browser_type($specs['wb']);

	} else {



		$user_agent = $_SERVER['HTTP_USER_AGENT'];

		$user_agent_frags = explode(' ', $user_agent);

		$browser_name = '';

		$browser_type = 'ff';

		foreach($user_agent_frags as $user_agent_frag) {

			if(strpos($user_agent, 'MSIE') > -1 && !$browser_name) {

				$browser_name = substr($user_agent, strpos($user_agent, 'MSIE'));

				$browser_name = substr($browser_name, 0, strpos($browser_name, ';'));

				$browser_name = str_replace('MSIE', 'Internet Explorer', $browser_name);

				$browser_type = 'ie';

			}



			if(strpos($user_agent_frag, 'Opera/') > -1 && !$browser_name) {

				$browser_name = str_replace('/', ' ', $user_agent_frag);

				$browser_type = 'op';



			}



			if(strpos($user_agent_frag, 'Version/') > -1 && !$browser_name && strpos($user_agent, 'Safari') > -1) {

				$browser_name = str_replace('Version/', 'Safari ', $user_agent_frag);

				$browser_type = 'sf';

			}

			if(strpos($user_agent_frag, 'Firefox/') > -1 && !$browser_name) {

				$browser_name = str_replace('/', ' ', $user_agent_frag);

				$browser_type = 'ff';

			}

			if(strpos($user_agent_frag, 'Chrome/') > -1 && !$browser_name) {

				$browser_name = str_replace('/', ' ', $user_agent_frag);

				$browser_type = 'cr';

			}

		}



		$CurrOS = getOS();



		$specs['os'] = $CurrOS;

		$specs['os_type'] = getOS_type($CurrOS);

		$specs['wb'] = $browser_name;

		$specs['wb_type'] = $browser_type;

		$specs['ia'] = Find_IP(); //$_SERVER['REMOTE_ADDR'];

	}

?>

<!DOCTYPE HTML>

<head>

<meta http-equiv="content-type" content="text/html" />

<title>What Am I Using?</title>

<link href='http://fonts.googleapis.com/css?family=Roboto:400,300|Oswald:700,400|Titillium+Web:900' rel='stylesheet' type='text/css' />

<link rel="stylesheet" href="style.css" />

<script type="text/javascript" src="http://java.com/js/deployJava.js"></script>

<script type="text/javascript" src="scripts/jquery.min.js"></script>

<script type="text/javascript" src="scripts/flash_detect_min.js"></script>

<script type="text/javascript" src="scripts/SilverlightVersion.js"></script>

<script type="text/javascript" src="scripts/app.js"></script>

<script type="text/javascript" src="scripts/jquery.zclip.js"></script>



<script type="text/javascript">

	jQuery(document).ready(function() {



	<?php if(!$is_link) { ?>

			// Screen Resolution



			jQuery('#specs > li.sr .spec span').html(screen.width+' x '+screen.height);

			jQuery.post('ajax.php','sr='+screen.width+' x '+screen.height)

			// Web Browser



			if(jQuery('#specs > li.wb .spec span').html() == '')



				jQuery('#specs > li.wb .spec span').html(navigator.appCodeName);



			// Browser Size



			jQuery('#specs > li.bs .spec span').html(jQuery(window).width()+' x '+jQuery(window).height());



			jQuery.post('ajax.php','bs='+jQuery(window).width()+' x '+jQuery(window).height());



			// Color Depth



			jQuery('#specs > li.cd .spec span').html(screen.pixelDepth+' bit');



			jQuery.post('ajax.php','cd='+screen.pixelDepth+' bit');

			// Javascript



			jQuery('#specs > li.js .spec span').html(navigator.javaEnabled() ? 'Enabled' : 'Disabled');

			var	java_enable='Disabled';

			var java_enable=navigator.javaEnabled() ? 'Enabled' : 'Enabled';



			jQuery.post('ajax.php','js='+java_enable);



			// Java



			jQuery('#specs > li.jv .spec span').html(deployJava.getJREs().length == 0 ? 'Not installed' : deployJava.getJREs());



			var jv_enable=deployJava.getJREs().length == 0 ? 'Not installed' : deployJava.getJREs()



			jQuery.post('ajax.php','jv='+jv_enable);



			// Cookies



			jQuery('#specs > li.ck .spec span').html(navigator.cookieEnabled ? 'Enabled' : 'Disabled');



			var ck_enable=navigator.cookieEnabled ? 'Enabled' : 'Disabled';



			jQuery.post('ajax.php','ck='+ck_enable);



			// Silverlight



			jQuery('#specs > li.sl .spec span').html(isSilverlightInstalled() ? isSilverlightInstalled() : 'Not installed');



			var sl_enable=isSilverlightInstalled() ? isSilverlightInstalled() : 'Not installed';



			jQuery.post('ajax.php','sl='+sl_enable);

			// Flash Version



			var flash_version = 'Not installed';



			if(FlashDetect.installed) {



				flash_version = FlashDetect.major+'.'+FlashDetect.minor+(FlashDetect.revision ? '.'+FlashDetect.revision : '');



			}



			jQuery('#specs > li.fv .spec span').html(flash_version);



			jQuery.post('ajax.php','fv='+flash_version);



	<?php } ?>

			generate_link();

			

			jQuery('#specs > li.sh .spec a:not(.pdf)').click(function(e) { e.preventDefault(); jQuery('#share .share.'+jQuery(this).attr('class')).slideToggle('medium'); })

			jQuery('#share .share.link input[type=text]').click(function() { jQuery(this).select(); });

			

			



		});



		function isSilverlightInstalled() {

			var isSilverlightInstalled = false;

			try {

				try	{

					var slControl = new ActiveXObject('AgControl.AgControl');

					isSilverlightInstalled = 'v'+GetSilverlightVersion();

				}

				catch (e) {

					if(navigator.plugins["Silverlight Plug-In"]) {

						if(navigator.plugins["Silverlight Plug-In"].version)

							isSilverlightInstalled = 'v'+navigator.plugins["Silverlight Plug-In"].version;

						else if(navigator.plugins["Silverlight Plug-In"].description)

							isSilverlightInstalled = 'v'+navigator.plugins["Silverlight Plug-In"].description;

						else

							isSilverlightInstalled = 'Enabled';

					}

				}

			}

			catch (e) {

			}

			return isSilverlightInstalled;

		}



		function generate_link() {

			var request_uri = new Array(),

			spec_elements = jQuery('#specs li[data-spec]');



			for(var x = 0; x < spec_elements.length; x++)

				request_uri.push(jQuery(spec_elements[x]).attr('data-spec')+'='+jQuery(spec_elements[x]).find('.spec span').html());



		request_uri = request_uri.join('|');

		request_uri = request_uri.replace('<noscript>Disabled</noscript>', '');

		request_uri = '?specs='+escape(request_uri);

			var long_url= 'http://www.whatamiusing.connerb.com'+request_uri;

			$.post('shortner.php','long_url='+long_url,function(response){

			//return response;

			jQuery('#share .share.link input[type=text]').val(response);

			/* Clippy location (hosted on Github) */

			//var clippy_swf = "scripts/clippy.swf";

			//jQuery('#change_this').clippy({'text': response, clippy_path: clippy_swf });
			
			// jQuery("#change_this").zclip({path:"scripts/ZeroClipboard.swf",copy:function(){return response;}});

			});

		}

$(document).ready(function(){
 jQuery("#change_this").zclip({path:"scripts/ZeroClipboard.swf",copy:function(){return $('#change_me').val();}});
 jQuery("#change_this").click(function() { jQuery("#change_this").addClass('hover').html('Copied!'); setTimeout("jQuery('#change_this').removeClass('hover').html('COPY');", 2000); })
 });

</script>

<style>

#change_me {
	font-size: 15px;
	height: 28px;
	width: 357px;
}

</style>

<script>
    /* jQuery(document).ready(function(){
       jQuery("#change_this").zclip({
           path:"scripts/ZeroClipboard.swf",
           copy:function(){return $("input#change_me").val();}
        });
    }); */
</script>
</head>
<body>

<div id="header">

  <div class="container relative">

    <div class="header-info">

      <h1>What Am I Using?</h1>

      <p>View local web browser support details of any computer. You can optionally share your results with a generated link, or send an email with the results enclosed. If you would like to print your results there is a PDF export option.</p>

    </div>

    <div class="clear"></div>

  </div>

</div>

<div id="content">

  <div class="container">

    <?php if($is_link) { ?>

    <center style=" text-decoration: underline; color: blue; ">

      <strong>Note: This is not a Live Preview<br />

      <br />

      </strong>

    </center>

    <?php } ?>

    <ul id="specs">

      <li data-spec="os" class="os <?php echo $specs['os_type']; ?>">

        <div class="spec">

          <h3>Operating System</h3>

          <span><?php echo $specs['os']; ?></span> </div>

      </li>

      <li data-spec="sr" class="sr">

        <div class="spec">

          <h3>Screen Resolution</h3>

          <span><?php echo $specs['sr']; ?></span> </div>

      </li>

      <li data-spec="wb" class="wb <?php echo $specs['wb_type']; ?>">

        <div class="spec">

          <h3>Web Browser</h3>

          <span><?php echo $specs['wb']; ?></span> </div>

      </li>

      <li data-spec="bs" class="bs">

        <div class="spec">

          <h3>Browser Size</h3>

          <span><?php echo $specs['bs']; ?></span> </div>

      </li>

      <li data-spec="ia" class="ia">

        <div class="spec">

          <h3>IP Address</h3>

          <span><?php echo $specs['ia']; ?></span> </div>

      </li>

      <li data-spec="cd" class="cd">

        <div class="spec">

          <h3>Color Depth</h3>

          <span><?php echo $specs['cd']; ?></span> </div>

      </li>

      <li data-spec="js" class="js">

        <div class="spec">

          <h3>Javascript</h3>

          <span><?php echo $specs['js']; ?>

          <noscript>

          Disabled

          </noscript>

          </span> </div>

      </li>

      <li data-spec="jv" class="jv">

        <div class="spec">

          <h3>Java Version</h3>

          <span><?php echo $specs['jv']; ?></span> </div>

      </li>

      <li data-spec="ck" class="ck">

        <div class="spec">

          <h3>Cookies</h3>

          <span><?php echo $specs['ck']; ?></span> </div>

      </li>

      <li data-spec="sl" class="sl">

        <div class="spec">

          <h3>Silverlight</h3>

          <span><?php echo $specs['sl']; ?></span> </div>

      </li>

      <li data-spec="fv" class="fv">

        <div class="spec">

          <h3>Flash Version</h3>

          <span><?php echo $specs['fv']; ?></span> </div>

      </li>

      <li class="sh">

        <div class="spec">

          <h3>Share</h3>

          <span> <a href="#" class="email">Email</a> | <a href="javascript: void(0)" class="link">Link</a> | <a href="export.php?print=pdf" class="pdf">PDF</a> </span>

          

          <?php



						$_SESSION['specs']['os']=$specs['os'];



						$_SESSION['specs']['os_type']=$specs['os_type'];



						$_SESSION['specs']['wb']=$specs['wb'];

						$_SESSION['specs']['wb_type']=$specs['wb_type'];



						$_SESSION['specs']['ia']=$specs['ia'];



						?>

        </div>

      </li>

    </ul>

    <?php // print_r($_SESSION['specs']);?>

    <div class="clear"></div>

  </div>

</div>

<div id="share">

  <div class="container">

    <div class="share email">

      <form id="ajax-contact" method="post" action="mailer.php">

        <button type="submit">SEND</button>

        <input type="text" id="name" name="name" placeholder="Your Name" required />

        <input type="email" id="email" name="email" placeholder="Your Email" required />

        <input type="email" id="remail" name="remail" placeholder="Recipient's Email" required />

      </form>

      <div id="form-messages"></div>

      <div class="clear"></div>

    </div>
    
    <div class="share link">
    <a id="change_this" href="javascript:void(0)">COPY</a>
      <input type="text" id="change_me" value=""/>
      
      <div class="clear"></div>

    </div>

  </div>

</div>

<div id="footer">

  <div class="container">

    <ul class="nav">
	  
	  <li><a href="http://www.connerb.com">About Me</a></li>
	  
    </ul>

    <div class="copyright">Copyright &copy; 2014 Conner Bernhard</div>

  </div>

</div>

</body>

<!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
var sc_project=9745222; 
var sc_invisible=1; 
var sc_security="d7dc929b"; 
var scJsHost = (("https:" == document.location.protocol) ?
"https://secure." : "http://www.");
document.write("<sc"+"ript type='text/javascript' src='" +
scJsHost+
"statcounter.com/counter/counter.js'></"+"script>");
</script>
<noscript><div class="statcounter"><a title="web analytics"
href="http://statcounter.com/" target="_blank"><img
class="statcounter"
src="http://c.statcounter.com/9745222/0/d7dc929b/1/"
alt="web analytics"></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->

</html>