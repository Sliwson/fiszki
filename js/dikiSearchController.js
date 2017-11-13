function DikiSearch()
{
    var request = document.getElementById("dikiSearch").value;
    var contentDiv = document.getElementById("dikiContent");

    if(request == null || request == "")
    {
        contentDiv.innerHTML = "<p>Błąd!</p>";
    }
    else
    {
        var xmlhttp = new XMLHttpRequest();
        contentDiv.innerHTML = "<img id=\"loadingSpinner\" src = \"../img/Spinner.gif\">";

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = this.responseText;
                if (response != '0') {
                    var result = new DOMParser().parseFromString(response, "text/html");
                    if(result == null)
                    {
                        response = "Zobaczymy";
                    }
                    else
                    {
                        //parse succesfull
                        var array = result.getElementsByClassName("dictionaryEntity");

                        if(array == null || array.length == 0)
                        {
                            response = "<p>Nie znaleziono w słowniku.</p>";
                        }
                        else
                        {
                            response = "";
                            for(var i = 0; i < array.length; i++)
                            {
                                response += array[i].innerHTML;
                            }
                            response = Parse(response);
                        }
                    }
                    contentDiv.innerHTML = response;
                }
                else {
                    //TODO: handle error
                }
            }
        };

        xmlhttp.open("GET", "../php/dikiSearchGet.php?q=" + request, true);
        xmlhttp.send();
    }

}

function Parse(str)
{
    var result = new DOMParser().parseFromString(str, "text/html");

    var elements = result.getElementsByTagName("a");
    for(var i = 0; i < elements.length; i++)
    {
        elements[i].removeAttribute("href");
    }

    elements = result.getElementsByTagName("img");
    for(var i = 0; i < elements.length; i++)
    {
        elements[i].removeAttribute("src");
    }

    elements = result.getElementsByClassName("hws");
    if(elements.length == 0 || elements == null)
        return "<p>Nie znaleziono w słowniku.</p>";

    var test = result.documentElement.innerHTML;

    return test;
}

function EnterSearch(e)
{
    // look for window.event in case event isn't passed in
    e = e || window.event;
    if (e.keyCode == 13)
    {
        document.getElementById('dikiIcon').click();
        return false;
    }
    return true;
}