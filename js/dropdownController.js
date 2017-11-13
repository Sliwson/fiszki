var enabled = false;

document.getElementById('expand').onmouseover = function()
{
    enabled = true;
    EnableMenu();
}

document.getElementById('dropdown-check').onmouseover = function()
{
    enabled = true;
    EnableMenu();
}

document.getElementById('dropdown-content').onmouseover = function()
{
    enabled = true;
    EnableMenu();
}

document.getElementById('dropdown-check').onmouseout = function()
{
    enabled = false;
    window.setTimeout(DisableMenu, 100);
}

document.getElementById('dropdown-content').onmouseout = function()
{
    enabled = false;
    DisableMenu();
}

function EnableMenu() {
    document.getElementById('dropdown-content').style.display = "block";
    document.getElementById('dropdown-check').style.display = "block";
    document.getElementById('expand').style.backgroundImage = "url('../img/expand-down-color.png')";
    SetWidth();
}
function DisableMenu() {
    if(enabled == false) {
        document.getElementById('dropdown-content').style.display = "none";
        document.getElementById('dropdown-check').style.display = "none";
        document.getElementById('expand').style.backgroundImage = "url('../img/expand-down-text.png')";
    }
}

function SetWidth ()
{
    var width = document.getElementById('account').getBoundingClientRect().width;
    document.getElementById('dropdown-content').style.width = (width-15).toString()+"px";
    document.getElementById('dropdown-check').style.width = (width-15).toString()+"px";
}