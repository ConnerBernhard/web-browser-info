<?php
	
	require_once 'includes/PHPMailer/PHPMailerAutoload.php';
	
    // Only process POST reqeusts.

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Get the form fields and remove whitespace.

        $name = strip_tags(trim($_POST["name"]));

				$name = str_replace(array("\r","\n"),array(" "," "),$name);

        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);

		$remail = filter_var(trim($_POST["remail"]), FILTER_SANITIZE_EMAIL);

		$ia = filter_var(trim($_POST["ia"]), FILTER_SANITIZE_EMAIL);

		$os = filter_var(trim($_POST["os"]), FILTER_SANITIZE_EMAIL);

		$wb = filter_var(trim($_POST["wb"]), FILTER_SANITIZE_EMAIL);

		$sr = filter_var(trim($_POST["sr"]), FILTER_SANITIZE_EMAIL);

		$bs = filter_var(trim($_POST["bs"]), FILTER_SANITIZE_EMAIL);

		$cd = filter_var(trim($_POST["cd"]), FILTER_SANITIZE_EMAIL);

		$js = filter_var(trim($_POST["js"]), FILTER_SANITIZE_EMAIL);

		$jv = filter_var(trim($_POST["jv"]), FILTER_SANITIZE_EMAIL);

		$ck = filter_var(trim($_POST["ck"]), FILTER_SANITIZE_EMAIL);

		$wb = filter_var(trim($_POST["wb"]), FILTER_SANITIZE_EMAIL);

		$fv = filter_var(trim($_POST["fv"]), FILTER_SANITIZE_EMAIL);

		$sl = filter_var(trim($_POST["sl"]), FILTER_SANITIZE_EMAIL);

		

		

        // Check that data was sent to the mailer.

        if ( empty($name) OR !filter_var($remail, FILTER_VALIDATE_EMAIL) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {

            // Set a 400 (bad request) response code and exit.

            //http_response_code(400);

            echo "Oops! There was a problem with your submission. Please complete the form and try again.";

            exit;

        }



        // Set the recipient email address.

        // FIXME: Update this to your desired email address.

        $recipient = $email;



        // Set the email subject.

        $subject = "Verify Support Details submission from $name"; ?>

   	<?php     

		$email_content = "<table ><tr>

        	<td>Name: $name</td></tr>";

        $email_content .= "<tr >

        	<td>Email:  $email </td>
		</tr> ";

       	$email_content .= "<tr >
			<td>Recipient's Email: $remail </td>

		</tr>"; ?>
 <?php $email_content .="<tr >

        	<td>Operating System: $os </td>

        </tr>

        <tr >

			<td >"; ?><?php $email_content .= "Screen Resolution: $sr </td>

		</tr>

        <tr >

        	<td>"; ?> <?php $email_content .="Web Browser: $wb </tr>

        <tr >

			<td >"; ?>

	   	<?php $email_content .= "Browser Size: $bs </td>

		</tr>

        <tr >

        	<td>"; ?> <?php $email_content .="Color Depth: $cd </td>

        </tr>

        <tr >

			<td >"; ?><?php $email_content .= "Javascript: $js </td>

        </tr>

        <tr >

        	<td>"; ?> <?php $email_content .="Java Version: $jv  </td>

	   	</tr>

        <tr >

			<td >"; ?><?php $email_content .= "Cookies: $ck </td>

		</tr>

        <tr >

        	<td>"; ?> <?php $email_content .="Silverlight: $sl </td>

        </tr>

        <tr >

			<td>"; ?><?php $email_content .= "Flash Version: $fv </td>

		</tr>

	</table>"; ?>



       <?php // Build the email headers.
		
		$mail = new PHPMailer;
		
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = '';                   // SMTP username
		$mail->Password = '';               // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
		$mail->Port = 587;                                    //Set the SMTP port number - 587 for authenticated TLS
		$mail->setFrom('verify.support@gmail.com', 'Verify Support');     //Set who the message is to be sent from
		/*$mail->addReplyTo('example@gmail.com', 'First Last');  //Set an alternative reply-to address
		$mail->addAddress('example@example.net', 'Example');  // Add a recipient*/
		$mail->addAddress($recipient);               // Name is optional
		/*$mail->addCC('cc@example.com');
		$mail->addBCC('bcc@example.com');
		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		$mail->addAttachment('/usr/labnol/file.doc');         // Add attachments
		$mail->addAttachment('/images/image.jpg', 'new.jpg'); // Optional name*/
		$mail->isHTML(true);                                  // Set email format to HTML
		 
		$mail->Subject = $subject;
		$mail->Body    = $email_content;
		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		 
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
		
        $email_headers = "From: $name <$email>";

		$email_headers  .= 'MIME-Version: 1.0' . "\r\n";

		$email_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



        // Send the email.

        if ($mail->send()) { /*mail($recipient, $subject, $email_content, $email_headers)*/

            // Set a 200 (okay) response code.

            //http_response_code(200);

            echo "Thank You! Your message has been sent.";

        } else {

            // Set a 500 (internal server error) response code.

            http_response_code(500);

            echo "Oops! Something went wrong and we couldn't send your message.";

        }

} else {

        // Not a POST request, set a 403 (forbidden) response code.

        http_response_code(403);

        echo "There was a problem with your submission, please try again.";

    } ?>

