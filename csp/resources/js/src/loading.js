function load(url) {
    // display loading image here...
    document.getElementById('loadingImg').visible = true;
    // request your data...
    var req = new XMLHttpRequest();
    req.open("POST", url, true);

    req.onreadystatechange = function() {
        if (req.readyState == 4 && req.status == 200) {
            // content is loaded...hide the gif and display the content...
            if (req.responseText) {
                document.getElementById('content').innerHTML = req.responseText;
                document.getElementById('loadingImg').visible = false;
            }
        }
    };
    request.send(vars);
}

function loadPage() {
    $("#loading").fadeOut();
}