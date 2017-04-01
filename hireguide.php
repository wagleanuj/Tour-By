<html>
<?php
/**
 * Created by PhpStorm.
 * User: Anuj Wagle
 * Date: 3/15/2017
 * Time: 10:05 PM
 * @author: Anuj Wagle
 * @contributor: Ray Zhen

 * This php file lets the tourist to propose a time to the guide and contact the guide
 */
session_start();//starts the session

include 'header.php';//include the css and font importing

include 'navbar.php';// include the navigation bar

$_SESSION['uemail'];
// check if we the place stored in session does not match with the one in get array, display error by saying session expired
if ($_SESSION['uplace'] != $_GET['pl']) {
    echo 'Your session has expired!';
    return;
}
//get the information about the tourist from the session
$s = $_SESSION['sessData'];
include 'config.php';// include the database information
$id;

// if the guideId is set in the GET array, get his email
if (isset($_GET['guideId'])) {
    $id = $_GET['guideId'];
    $qu = "select email from users where id=" . $id;
    $res = $db->query($qu);
    if (!$res) {
        die(' There was an error with query' . $db->error);

    }
    $data = $res->fetch_assoc();
    $email = $data['email'];
}
// if submit had been pressed, process the information recieved from the form and send the email
// to the guide
if (isset($_POST['submit'])) {
    $dateProp = $_POST['propdate'];

   // set the server timezone and get todays date
    date_default_timezone_set('UTC');
    $date = date('m/d/Y', time());
    // if the tourist is trying to book a time in the past, give an error
    if (strtotime($dateProp) <= strtotime($date)) {
        echo "<p align='center' style='font-size:200%;color:red;'>Set a valid date</p>";
    }
    // else send the email
    else {
        $confirmationLink = "http://www.cs.mun.ca/~aw7464/project/confirmation.php?pl=" . $_SESSION['uplace'] . "&t=" . $s['userID']
            . "&g=" . $id . "&bD=" . $dateProp;
        $to = $email;
        $subject = "You have been booked.";
        $txt = "Hi,
    You have been booked for a tour guide. Please view the following message from the tourist who booked you:
    " . $_POST['message'] . "
         To confirm this tour, please follow the following link.
         " . $confirmationLink;;
        $headers = "From:" . $_SESSION['uemail'];;
        mail($to, $subject, $txt, $headers);
        echo "<h1 align='center'> Your response has been successfully sent</h1>";
        return;
    }

}
?>
<?php
//html for the form
echo '


<body>
<h1 align="center"> Contact the guide </h1>
<div class="container">
<div class="row">
<form method="post" action="">
    <p name="email">To: ' . $email . '</p>
    <br/>
    Propose a Date: <input type="date" name="propdate" ><br/>
    <label for="message">Your message:</label><br/>
    <textarea class="materialize-textarea"rows="50" cols="50" name="message"></textarea> <br/>
    <br/>
    <input  class="btn" type="submit" name="submit" value="Send">
</form>
</div>
</div>
</body>
</html>';
?>