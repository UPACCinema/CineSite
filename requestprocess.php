<?php
include_once("officers/include/session.php");

global $session, $form;

$to = "upac-cinema@union.rpi.edu";

$fullname = $_POST["cname"];
$fromemail = $_POST["cmail"];
$from = $fullname.$fromemail;

$subj = "Club Film Request";
$body = "Saturday Film Request
Club: " . $_POST['club'] . 
"Contact Info: " . $_POST['cname'] . 
"Contact Email: " . $_POST['cmail'] . 
"Union Funded: " . $_POST['funds'] .
"Payment Option: " . $_POST['pay'] . 
"1st choice film: " . $_POST['first'] . 
"2nd Choice film: " . $_POST['second'] . 
"3rd Choice film: " . $_POST['third'] . 
"4th Choice film: " . $_POST['fourth'] . 
"Desired Month: " . $_POST['date'] . ", " . $_POST['year'] . 
"Read Club Film Info: " . $_POST['terms'];

if(!$_POST['club'] || strlen($_POST['club'] = trim($_POST['club'])) == 0) {
  $form->setError('club',"*Field Required");
}
if(!$_POST['cname'] || strlen($_POST['cname'] = trim($_POST['cname'])) == 0) {
  $form->setError("cname","*Field Required");
}
if(!$_POST['cmail'] || strlen($_POST['cmail'] = trim($_POST['cmail'])) == 0) {
  $form->setError("cmail","*Field Required");
}
if(!$_POST['funds']) {
  $form->setError("funds","*Field Required");
}
if(!$_POST['pay']) {
  $form->setError("pay","*Field Required");
}
if(!$_POST['first'] || strlen($_POST['first'] = trim($_POST['first'])) == 0) {
  $form->setError("first","*Field Required");
}
if(!$_POST['date'] || strlen($_POST['date'] = trim($_POST['date'])) == 0) {
  $form->setError("date","*Field Required");
}
if(!$_POST['year'] || strlen($_POST['year'] = trim($_POST['year'])) == 0) {
  $form->setError("year","*Field Required");
}
if(!$_POST['terms']) {
  $form->setError("terms","*Field Required");
}

if($form->num_errors > 0) {
  $_SESSION['value_array'] = $_POST;
  $_SESSION['error_array'] = $form->getErrorArray();
} else {
  if(mail($to, $subj, $body, $from)) {
  // email sent successfully
    $_SESSION['requestfilm'] = true;
  } else {
  // email not sent
    $_SESSION['requestfilm'] = false;
  }
}
header("Location: request.php");
?>