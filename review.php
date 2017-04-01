<?php
/**
 * @author: Anuj Wagle
 * This php file is used for displaying the reviews of a guide. It is called from getprofile.php to show the reviews of
 * a guide and is directed to when the tourist needs to write a review on the tourist in mytours.php
 */
include_once 'navbar.php';// include the navigation bar
//disables warnings on some browsers
error_reporting(0);
//redirect it to the sign in page if no session detected


//define tourno and value
$tourno;
$value;
//get the values of tourno and value from the get array
if (isset($_GET['tour']) && isset($_GET['guide'])) {
    $value = $_GET['guide'];
    $tourno = $_GET['tour'];
}
else{
    $value=$_SESSION['viewValue'];
}
setcookie("guideIdForReview", $value);

?>
<html>
<head>
    <script src="js/getReviews.js">
    </script>

</head>
<body>
<div class="container">
    <h5>Reviews</h5>

    <div id="commentSection">
    </div>
<?php
//since this php file is included in getprofile.php and when we need the tourist to write the review
// if the tour number is defined, then we want to display a text box to let the tourist write a review
if(isset($_GET['tour'])){
echo'
    <div class="styled-input wide">
          <textarea id="comment"></textarea>

          <label>Write a review</label>

          <span></span></div>
    <button class="button button5" onclick="loadAll(3,'. $tourno.' ); return false;">POST</button>';
}?>
</div>
<script>
    //loads all the reviews
    loadAll(0, 0);

</script>
</body>
</html>
