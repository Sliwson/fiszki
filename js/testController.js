var wordsArray = null;
var currentId = -1;
var currentCardSide = 0; //0 = front

//information block properties
var information;
class Information {
    constructor(count)
    {
        this.wordsCount = count;
        this.currentCard = 0;
        this.wrongCount = 0;
        this.correctCount = 0;
        this.progressText = document.getElementById("progress");
        this.correctText = document.getElementById("correct");
        this.wrongText = document.getElementById("wrong");
        this.effectivenessText = document.getElementById("effectiveness");
    }

    UpdateUI()
    {
        this.progressText.innerHTML = this.currentCard + "/" + this.wordsCount;
        this.correctText.innerHTML = this.correctCount;
        this.wrongText.innerHTML = this.wrongCount;
        if(this.correctCount + this.wrongCount == 0) this.effectivenessText.innerHTML = "100%"
        else this.effectivenessText.innerHTML = (this.correctCount*100/(this.correctCount + this.wrongCount)).toString().slice(0,4) + "%";
    }

    CardCorrect()
    {
      this.currentCard ++;
      this.correctCount ++;
      this.UpdateUI();
    }

    CardWrong()
    {
      this.currentCard ++;
      this.wrongCount ++;
      this.UpdateUI();
    }
}

String.prototype.trim = String.prototype.trim || function trim() { return this.replace(/^\s\s*/, '').replace(/\s\s*$/, ''); };

document.onkeydown = function(e)
{
  e = e || window.event;
  if (e.keyCode == 13)
  {
    if(currentCardSide == 0) document.getElementById('check_button_id').click();
    else document.getElementById("next_button").click();
  }
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function HtmlEncode(s)
{
  var el = document.createElement("div");
  el.innerText = el.textContent = s;
  s = el.innerHTML;
  return s;
}

function CheckAndFlip()
{
    //get user's input and expected answer
    var answer = document.getElementById("user_input").value.toString().trim();
    var expected = wordsArray[currentId][0].toString().trim();

    //check whether the answer is correct
    var isCorrect = Compare(answer, expected);

    //prepare the next site of the card
    document.getElementById("polish_text_back").innerHTML = wordsArray[currentId][1];

    var paragraph = document.getElementById("answer_result");
    paragraph.innerHTML = answer;

    if(isCorrect)
    {
        paragraph.style.color = "#009900";
        information.CardCorrect();
    }
    else
    {
        paragraph.style.color = "red";
        var head = document.getElementById("polish_text_back");
        head.innerHTML += " - <span style = 'color: #009900'>" + decodeURI(expected) + "</span>";
        information.CardWrong();
    }

    if(currentId == wordsArray.length - 1)
    {
       //we hit the last card
       var nextButton = document.getElementById("next_button");
       nextButton.innerHTML = "Zakończ";
       nextButton.onclick = Finish;
    }

    currentCardSide = 1;
    document.getElementById('flipper').style.transform = 'rotateX(-180deg)';
}

function Finish()
{
    window.location.href = "../przegladaj/index.php";
}

function Compare(user, english)
{
      //TODO: improve that checking
    if(user==english) return 1;
    else if (HtmlEncode(user) == english) return 1;
    else if (user == HtmlEncode(english)) return 1;
    else return 0;
}

function NextCard()
{
    currentId ++;

    document.getElementById("polish_text").innerHTML = wordsArray[currentId][1];
    document.getElementById("user_input").value = "";

    currentCardSide = 0;
    document.getElementById('flipper').style.transform = 'rotateX(0deg)';
}

function LoadFirstCard()
{
    document.getElementById("loadingSpinnerCenter").style.visibility = "hidden";
    document.getElementById("loadingSpinnerCenter").style.opacity = "0";
    document.getElementById("rc").style.visibility = "visible";
    document.getElementById("rc").style.opacity = "1";
    document.getElementById("flip_cont").style.visibility = "visible";
    document.getElementById("flip_cont").style.opacity = "1";
    document.getElementById("polish_text").innerHTML = wordsArray[0][1];
    document.getElementById("polish_text_back").innerHTML = wordsArray[0][1];
    currentId = 0;
    currentCardSide = 0;
    information = new Information(wordsArray.length);
    information.UpdateUI();
}

function DisplayErrorMessage()
{
    document.getElementById("lc").style.display = "none";
    document.getElementById("loadingSpinnerCenter").style.display = "none";
    document.getElementById("error_hidden").style.display = "block";
}

function LoadTestInfo(id)
{
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.responseText;

            if (response == '1') //null array error
            {
                DisplayErrorMessage();
            }
            else if (response != '0') {
                wordsArray = JSON.parse(response);

                if(wordsArray.length == 0 || wordsArray == null)
                {
                    DisplayErrorMessage();
                }
                else
                {
                    LoadFirstCard();
                }
            }
            else {
                //TODO: handle error
            }
        }
    };

    xmlhttp.open("GET", "../php/listGet.php?id=" + id, true);
    xmlhttp.send();
}
