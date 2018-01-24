
// Get the modal
var modal = document.getElementById('myModal');

function reply_click(clicked_id){
    var img = document.getElementById(clicked_id);
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");

    modalImg.setAttribute("data-photo-id", clicked_id);
    //Display modal
    modal.style.display = "block";

    //Insert image into modal
    modalImg.src = img.src;

    //use alt as caption
    captionText.innerHTML = img.alt;

    //do AJAX request to check for comments
    getComments(clicked_id);
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
        modal.style.display = "none";
}

function getComments(photoID) {
    var commentDiv = document.getElementById("comments");
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_comments.php?id=' + photoID, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
        if(xhr.readyState == 4 && xhr.status == 200) {
            var result = xhr.responseText;
            replaceDiv(commentDiv, result);
        }
    };
    xhr.send();
}

function replaceDiv(div, new_html) {
    div.innerHTML = new_html;
}
