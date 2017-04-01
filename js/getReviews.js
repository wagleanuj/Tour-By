/*
 * Anuj Wagle
 * Std number:201511763
 * This javascript is needed to get the reviews and post the reviews
 * It used ajax to get the responses and post the comments to getReviews.php
 */
//get the cookie saved by the php file that this js is called from and split them and get the
// guide id that we want to get and post reviews to
var cookies = document.cookie.split(";").map(function (el) {
    return el.split("=");
}).reduce(function (prev, cur) {
    prev[cur[0]] = cur[1];
    return prev
}, {});

var guideId = cookies["guideIdForReview"];//get the guide id

// this function is called from multiple places, one is while we want to load the reviews only
// next it is called when the tourist wants to post a review
function loadAll(loadedFrom, tournumber) {
    var tourno = tournumber;
    var once = false;
    var commentBox = document.getElementById('comment');//get the comment box
    //url that ajax will request to
    var url = "getReviews.php?";
    //adding the id of the picture to be requested in the query
    var query = "command=" + guideId;
    //if loadedFrom is 3, it was sent from the comment form, so
    //add the comment in the query by encoding it.
    if (loadedFrom == 3) {
        var comment = commentBox.value;
        query += "&tournum=" + tourno + "&comment=" + encodeURIComponent(comment);
    }
    // get an AJAX object
    var xhr = new XMLHttpRequest();
    xhr.onload = function () {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200 || xhr.status == 400) {
                console.log(query);// for debugging use
                var response = xhr.responseText;
                console.log(response);//for debugging use

                var obj = JSON.parse(response);
                console.log(obj);//for debugging use
                //send the json object to the function renderHTMl()
                // to update the picture and comment field
                renderHTML(obj);
            }
            //if the status is not 200 or 400
            else {
                alert("unknown error");

            }

        }
    };

    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(query);// send the query to url
}


// this function takes the json parsed object and updates the review field
function renderHTML(indata) {
    var commentContainer = document.getElementById("commentSection");
    commentContainer.innerHTML = "";
    var HTMLstring = "";
    if (indata == "No reviews yet!") {
        HTMLstring += "<h4><i> No reviews yet!</i></h4>"
    }
    else {
        //going through the json array to get all the comments in the comment container
        for (i = 0; i < indata.length; i++) {
            if (indata[i].comment != "") {
                HTMLstring += "<blockquote><p>" + indata[i].comment + "</p> <cite><b>" + indata[i].author + "</b><p>Tour #: " + indata[i].tourId + "<span style='padding-left: 20px;'>Tour Date: " + indata[i].tourDate + "</span></p></cite></blockquote> ";
            }
        }
    }
    commentContainer.insertAdjacentHTML('beforeend', HTMLstring);// insert into the comment container div

}
