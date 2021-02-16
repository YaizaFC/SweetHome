<?php

if(!function_exists('sendEmail')){
    /**
     * This function sends the email and returns true or false as to status
     * @param string $to This should be the email address of the person you wish to send the email to
     * @param string $subject The subject of the email message
     * @param string $plain The plain text version of the email message
     * @param string $html The HTML version of the email message
     * @param string $from The email address of the person the email is from
     * @param string $fromname The name of the person the email is from
     * @param string $replyto If you want to change the reply to address
     * @param array $attachment A single attachment should be included here e.g. array(path, name, encoding = base64, mimetype)
     * @return true|false Returns true if email sent else returns false 
     */
    function sendEmail($to, $subject, $plain, $html, $from, $fromname, $replyto = '', $attachment = ''){
        // Check configuration for SMTP parameters
        $mail = new PHPMailer;
        $mail->CharSet = 'UTF-8';
        if(USE_SMTP){
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = SMTP_AUTH;
            if(!is_null(SMTP_AUTH)){
                $mail->Username = SMTP_USERNAME;
                $mail->Password = SMTP_PASSWORD;
            }
            $mail->Port = SMTP_PORT;
            if(!is_null(SMTP_SECURITY)){
                $mail->SMTPSecure = SMTP_SECURITY;
            }
        }
        
        $mail->From = $from;
        $mail->FromName = $fromname;
        if(!empty($replyto)){
            $mail->AddReplyTo($replyto, $fromname);
        }
        $mail->addAddress($to);
        $mail->isHTML(true);
        if(!empty($attachment)){
            $mail->addAttachment($attachment[0], $attachment[1], $attachment[2], $attachment[3]);
        }
        $mail->Subject = $subject;
        $mail->Body = $html;
        $mail->AltBody = $plain;
        return $mail->send();
    }
}

try {
	$db = new DBAL\Database("localhost", "root", null, "sweethome");
    //$db = new PDO('mysql:dbname=user;host=127.0.0.1', "root", null);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

function makeInfoBox($type,$content){
	$info_color = "blue";
	switch($type){
		case $type == 'error':
			$info_color = "red";
		break;
		case $type == 'warning':
			$info_color = "orange";
		break;
		case $type == 'confirm':
		case $type == 'correct':
			$info_color = "green";
		break;
		default:
			$info_color = "blue";
		break;
	}
	?>
<div class="row" id="alert_box">
	<div class="col s12 m12">
		<div class="card <?php print $info_color; ?> darken-1">
			<div class="row">
				<div class="col s12 m10">
					<div class="card-content white-text">
						<?php 
						if(is_array($content)){
							foreach($content as $str){
								print "<p>".$str."</p>";
							}
						} else {
							print "<p>".$content."</p>";
						}; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php };


function makeCard($casa_id,$casa_name,$casa_img,$casa_ubication,$casa_score){ ?>


	<div class="col s11 m5 l3 card small offset-s1 offset-m1 offset-l1 ">
		<div class="card-image waves-effect waves-block waves-light">
			<a href="casa.php?id=<?php print $casa_id; ?>">
				<img class="responsive-img" src="<?php print $casa_img; ?>" />
				<span class="card-title truncate casa_titulo"><?php print $casa_name; ?></span>
			</a>
		</div>
	    <div class="card-action">
			<div class="row col s6 align-left">
				<a href="<?php print htmlentities($casa_ubication); ?>"><i class="material-icons">map</i></a>
			</div>
			<div class="row col s6 right-align">
				<span class="truncate"><?php print $casa_score; ?> Puntos</span>
			</div>
		</div>
	</div>
	
	
<?php };