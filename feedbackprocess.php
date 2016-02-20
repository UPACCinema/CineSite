<?php
require_once('recaptchalib.php');
$privatekey = '6LcBlckSAAAAABtR_1Ly6kJpsZPgQfFu0Uy0fXuy';
$resp = recaptcha_check_answer ($privatekey,
							$_SERVER["REMOTE_ADDR"],
							$_POST["recaptcha_challenge_field"],
							$_POST["recaptcha_response_field"]);
if(!$resp->is_valid) {
	die ("Error: Please reenter the reCAPTCHA.");
}
else{
include_once("officers/include/session.php");

global $session, $form;
$to = "upac-cinema@union.rpi.edu";
$fullname = $_POST["fullname"];
$fromemail = $_POST["email"];

if(!$fullname || strlen($fullname = trim($fullname)) == 0){
  if(!$fromemail || strlen($fromemail = trim($fromemail)) == 0){
    $fullname = "Do Not Reply";
    $fromemail = " <donotreply@union.rpi.edu>";
    $from = $fullname.$fromemail;
  } else {
    $from = $fromemail;
  }
} else {
  if(!$fromemail || strlen($fromemail = trim($fromemail)) == 0){
    $from = $fullname;
  } else {
    $from = $fullname." <".$fromemail.">";
  }
}

$subj = "UPAC Cinema Web Feedback";
$body = $_POST["comments"];
if(!$body || strlen($body = trim($body)) == 0){
  $form->setError("comments","*Field Required");
  $_SESSION['value_array'] = $_POST;
  $_SESSION['error_array'] = $form->getErrorArray();
}
else{
  if(mail($to, $subj, $body, $from)) {
  // email sent successfully
    $_SESSION['feedbacksent'] = true;
  } else {
  // email not sent
    $_SESSION['feedbacksent'] = false;
  }
}
header("Location: feedback.php");
}
?>