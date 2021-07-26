function request()
{
    var search_term = document.getElementById("term").value;
    var origin = document.getElementById("origin").value;
    var genre = document.getElementById("genre").value;
    var sort = document.getElementById("sort").value;
    var sort_type = document.getElementById("sort-type").value;

    var xhr = new XMLHttpRequest();

    xhr.addEventListener("readystatechange", response, false);

    xhr.open("GET", "home.php?s=" + search_term + "&origin=" + origin + "&genre=" + genre + "&sort=" + sort + "&sort-type=" + sort_type);

    xhr.send();
}

function response()
{
    if (this.readyState == 4 && this.status == 200)
    {
        var display = document.getElementById("movielist");
        var html = this.responseText;
        html = html.substring(html.indexOf('<ul class="movielist" id="movielist">'));

        display.innerHTML = html;
    }
}