var result_div = document.getElementById("result");
var volume = document.getElementById("volume");
var button = document.getElementById("submit");
var orig_button_value = button.innerText;

// function showSpinner() {
//     var spinner = document.getElementById("spinner");
//     spinner.style.display = 'block';
// }
//
// function hideSpinner() {
//     var spinner = document.getElementById("spinner");
//     spinner.style.display = 'none';
// }
//
function disableSubmitButton() {
    button.disabled = true;
    button.innerText = 'Loading...';
}

function enableSubmitButton() {
    button.disabled = false;
    button.innerText = orig_button_value;
}

function submitComment() {
    // clearResult();
    // clearErrors();
    // showSpinner();
    disableSubmitButton();

    var id = parseInt(document.getElementById("img01").getAttribute("data-photo-id"));
    var author = document.getElementById('author').value;
    var body = document.getElementById('body').value;

    var rawData = ''
        + 'id=' + id
        + '&author=' + author
        + '&body=' + body;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'add_comment.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
        if(xhr.readyState == 4 && xhr.status == 200) {
            var result = xhr.responseText;
            //hideSpinner();
            enableSubmitButton();
            getComments(id);
            // var json = JSON.parse(result);
            // if(json.hasOwnProperty('errors') && json.errors.length > 0) {
            //     displayErrors(json.errors);
            // } else {
            //     postResult(json.volume);
            // }
        }
    };

    xhr.send(rawData);
}

