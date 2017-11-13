function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function DeleteWord(wordId, listId)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.responseText;
            if (response == '1') {
                document.getElementById("card_" + wordId).style.visibility = "hidden";
                document.getElementById("card_" + wordId).style.display = "none";
            }
            else
            {
                //TODO: handle error
            }
        }
    };

    xmlhttp.open("GET", "../php/deleteWord.php?word_id=" + wordId + "&list_id=" + listId, true);
    xmlhttp.send();
}

function AddWord(listId)
{
    var xmlhttp = new XMLHttpRequest();

    var english = document.getElementById("english_input").value;
    var polish = document.getElementById("polish_input").value;

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.responseText;
            if (response != '0') {

                var cardString = DrawCard(response,listId, polish, english);
                document.getElementById("add_space").innerHTML += cardString;
                document.getElementById("english_input").value = "";
                document.getElementById("polish_input").value = "";
                document.getElementById("english_input").focus();
            }
            else {
                //TODO: handle error
            }
        }
    };

    xmlhttp.open("GET", "../php/addWord.php?list_id=" + listId + "&en=" + english + "&pl=" + polish, true);
    xmlhttp.send();
}

function AlterWord(listId, wordId)
{
    var xmlhttp = new XMLHttpRequest();

    var card = document.getElementById("card_" + wordId);
    var array = card.getElementsByTagName("input");

    var pl,en;

    if (array.length == 2)
    {
        en = array[0].value;
        pl = array[1].value;

        xmlhttp.open("GET", "../php/alterWord.php?word_id=" + wordId + "&list_id=" + listId + "&en=" + en + "&pl=" + pl, true);
        xmlhttp.send();
    }

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.responseText;
            if (response == '1') {
                //handle response
            }
            else
            {
                //TODO: handle error
            }
        }
    };
}

function DrawCard(insertId, listId, pl, en)
{
    return "<div id = \"card_"+insertId+"\" class = \"added_card\">\n" +
        "   <div class = \"button_container\">\n" +
        "   <button onclick = \"DeleteWord(" + insertId + "," + listId+ ")\"class = \"delete_button\">Usuń</button>\n" +
        "   </div>\n" +
        "   <div class = \"input_container\">\n" +
        "   <div class = \"inputfield_container_left\"><input onblur = \"AlterWord(" + listId + "," + insertId + ")\" class = \"english_input_accepted\" name = \"english_input\" type = \"text\" placeholder = \"Angielski\" value = \""+escapeHtml(en)+"\"></div>\n" +
        "   <div class = \"inputfield_container_right\"><input onblur = \"AlterWord(" + listId + "," + insertId + ")\" class = \"polish_input_accepted\" name = \"polish_input\" type = \"text\" placeholder = \"Polski\" value = \"" + escapeHtml(pl) + "\"></div>\n" +
        "   </div>\n" +
        "   </div>";
}

function searchKeyPress(e)
{
    // look for window.event in case event isn't passed in
    e = e || window.event;
    if (e.keyCode == 13)
    {
        document.getElementById('add_button_id').click();
        return false;
    }
    return true;
}
