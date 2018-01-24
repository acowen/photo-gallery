var container = document.getElementById('images');
var load_more = document.getElementById('load-more');
var request_in_progress = false;
var end_of_database = false;

function showSpinner() {
    var spinner = document.getElementById("spinner");
    spinner.style.display = 'block';
}

function hideSpinner() {
    var spinner = document.getElementById("spinner");
    spinner.style.display = 'none';
}

function showLoadMore() {
    load_more.style.display = 'inline';
}

function hideLoadMore() {
    load_more.style.display = 'none';
}

function showEndofImages(){
    document.getElementById('end').style.display = "block";
}

function appendToDiv(div, new_html) {
    // Put the new HTML into a temp div
    var temp = document.createElement('div');
    temp.innerHTML = new_html;

    //get all loaded html and append to container
    var class_name = temp.firstElementChild.className;
    var items = temp.getElementsByClassName(class_name);
    var len = items.length;
    for (i = 0; i < len; i++) {
        div.appendChild(items[0]);
    }
}

function setCurrentPage(page) {
    console.log('Incrementing page to: ' + page);
    load_more.setAttribute('data-page', page);
}

function scrollReaction() {
    if(end_of_database){ return };
    var content_height = container.offsetHeight;
    var current_y = window.innerHeight + window.pageYOffset;
    // console.log(current_y + '/' + content_height);
    if (current_y >= content_height) {
        loadMore();
    }
}

function loadMore() {

    if (request_in_progress) {
        return;
    }
    if(end_of_database){ return };

    request_in_progress = true;

    showSpinner();
    hideLoadMore();

    var page = parseInt(load_more.getAttribute('data-page'));
    var next_page = page + 1;

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_photos.php?page=' + next_page, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var result = xhr.responseText;
            hideSpinner();
            console.log(result);
            if(result == "false"){
                end_of_database = true;
                showEndofImages();
                return;
            }
            setCurrentPage(next_page);
            // append results to end of blog posts
            appendToDiv(container, result);
            showLoadMore();
            request_in_progress = false;
        }
    };
    xhr.send();
}

load_more.addEventListener("click", loadMore);

window.onscroll = function () {
    scrollReaction();
}

// Load even the first page with Ajax
loadMore();
