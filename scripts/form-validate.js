function showtext(element, text)
{
  element.appendChild(document.createTextNode(text));
}

function login(event)
{
    var elements = event.currentTarget;

    var email = elements[0].value;
    var pass = elements[1].value;

    var email_regex = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
    var pass_regex = /^.*(?=.*\d)(?=.*\W).*$/;

    var email_err = document.getElementById("email-err");
    var pass_err = document.getElementById("pass-err");
    email_err.innerHTML = "";
    pass_err.innerHTML = "";

    var input_valid = true;

    if (email == null || email == "")
    {
        showtext(email_err, "this field cannot be empty");
        input_valid = false;
    }
    else if (email_regex.test(email) == false)
    {
        showtext(email_err, "email address must be in a valid format");
        input_valid = false;
    }

    if (pass == null || pass == "")
    {
        showtext(pass_err, "this field cannot be empty");
        input_valid = false;
    }
    else if (pass.length < 8)
    {
        showtext(pass_err, "password must be at least 8 characters long");
        input_valid = false;
    }
    else if (pass_regex.test(pass) == false)
    {
        showtext(pass_err, "password must contain at least one number and special character");
        input_valid = false;
    }

    if (!input_valid)
    {
        event.preventDefault();
    }
}

function signup(event)
{
    var elements = event.currentTarget;

    var email = elements[0].value;
    var user = elements[1].value;
    var avi = elements[2].value;
    var fname = elements[3].value;
    var lname = elements[4].value;
    var pass = elements[5].value;
    var cpass = elements[6].value;

    var email_regex = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
    var pass_regex = /^.*(?=.*\d)(?=.*\W).*$/;

    var email_err = document.getElementById("email-err");
    var user_err = document.getElementById("user-err");
    var avi_err = document.getElementById("avi-err");
    var fname_err = document.getElementById("fname-err");
    var lname_err = document.getElementById("lname-err");
    var pass_err = document.getElementById("pass-err");
    var cpass_err = document.getElementById("cpass-err");
    email_err.innerHTML = "";
    user_err.innerHTML = "";
    avi_err.innerHTML = "";
    fname_err.innerHTML = "";
    lname_err.innerHTML = "";
    pass_err.innerHTML = "";
    cpass_err.innerHTML = "";

    var input_valid = true;

    if (email == null || email == "")
    {
        showtext(email_err, "this field cannot be empty");
        input_valid = false;
    }
    else if (email_regex.test(email) == false)
    {
        showtext(email_err, "email address must be in a valid format");
        input_valid = false;
    }

    if (user == null || user == "")
    {
        showtext(user_err, "this field cannot be empty");
        input_valid = false;
    }

    if (avi == null || avi == "")
    {
        showtext(avi_err, "this field cannot be empty");
        input_valid = false;
    }

    if (fname == null || fname == "")
    {
        showtext(fname_err, "this field cannot be empty");
        input_valid = false;
    }

    if (lname == null || lname == "")
    {
        showtext(lname_err, "this field cannot be empty");
        input_valid = false;
    }

    if (pass == null || pass == "")
    {
        showtext(pass_err, "this field cannot be empty");
        input_valid = false;
    }
    else if (pass.length < 8)
    {
        showtext(pass_err, "password must be at least 8 characters long");
        input_valid = false;
    }
    else if (pass_regex.test(pass) == false)
    {
        showtext(pass_err, "password must contain at least one number and special character");
        input_valid = false;
    }

    if (cpass == null || cpass == "")
    {
        showtext(cpass_err, "this field cannot be empty");
        input_valid = false;
    }
    else if (pass != cpass)
    {
        showtext(cpass_err, "must match password")
        input_valid = false;
    }

    if (!input_valid)
    {
        event.preventDefault();
    }
}

function getCharCount()
{
    return document.getElementById("name").value.length;
}

function updateCharCount(event)
{
    var char_count = getCharCount();
    var display = document.getElementById("char-count");

    display.innerHTML = char_count + "/15";

    if (char_count <= 0 || char_count > 15)
    {
        display.style.color = "rgba(255, 0, 0, 0.5)";
    }
    else
    {
        display.style.color = "rgba(255, 255, 255, 0.5)";
    }
}

function createWatchlist(event)
{
    var char_count = getCharCount();

    if (char_count <= 0 || char_count > 15)
    {
        event.preventDefault();
    }
}

function resetLogin(event)
{
    var elements = event.currentTarget;
    
    for (i = 0; i < 2; i++)
    {
        elements[i] = "";
    }

    document.getElementById("email-err").innerHTML = "";
    document.getElementById("pass-err").innerHTML = "";
}

function resetSignup(event)
{
    var elements = event.currentTarget;

    for (i = 0; i < 7; i++)
    {
        elements[i] = "";
    }

    document.getElementById("email-err").innerHTML = "";
    document.getElementById("user-err").innerHTML = "";
    document.getElementById("avi-err").innerHTML = "";
    document.getElementById("fname-err").innerHTML = "";
    document.getElementById("lname-err").innerHTML = "";
    document.getElementById("pass-err").innerHTML = "";
    document.getElementById("cpass-err").innerHTML = "";
}