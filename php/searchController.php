<?php
require_once 'phpHeader.php';
$header = new PhpHeader();

require_once "checkPermission.php";
require_once "browse.php";
require_once "database.php";

class SearchController
{
    private $emptyUrl;
    private $searchString;
    private $matchingIds;
    private $countString;

    function __construct($get_search)
    {
        $this->matchingIds = array();
        $this->countString = "";

        if($get_search == null)
        {
          $this->emptyUrl = true;
        }
        else {
          $this->emptyUrl = false;
          $this->searchString = testInput($get_search);
          $this->PerformSearch();
          $this->UpdateCountString();
        }
    }

    public function DisplaySearchResults()
    {
        if($this->emptyUrl)
        {
          $this->DrawErrorMessage();
        }
        else {
            ?>
              <div class = "edit_card">
                <div class = "headerCardBrowse"><h3><?php echo $this->countString; ?></h3></div>
                <hr>
                <div class = "scroll">
                  <?php $this->DisplayLists()?>
                </div>
              </div>
            <?php
        }
    }

    public function ShowBarValue()
    {
      if($this->searchString != "")
      {
        echo $this->searchString;
      }
      else {
        echo "";
      }
    }

    private function PerformSearch()
    {
        $search = strtolower(preg_replace('/\s+/', '', $this->searchString));

        //download all public and private user's lists

        //public
        $sql = "SELECT `Id`,`Name` FROM `Lists` WHERE `Public`='1';";
        $result = Query($sql);
        $this->ProcessResult($result, $search);

        if($_SESSION["login_id"] > 0)
        {
          $sql = "SELECT `Id`,`Name` FROM `Lists` WHERE `Public`='0' and `OwnerId` = '".$_SESSION["login_id"]."';";
          $result = Query($sql);
          $this->ProcessResult($result, $search);
        }
    }

    private function ProcessResult($result, $search)
    {
      if($result->num_rows > 0)
      {
          while($row = $result->fetch_assoc())
          {
              $name = $row["Name"];
              $name = strtolower(preg_replace('/\s+/', '', $name)); //remove whitespaces

              $match = strpos($name, $search);

              if($match === FALSE)
              {
                //do nothing
              }
              else
              {
                  $id = $row["Id"];
                  $this->matchingIds[] = $id;
              }
          }
      }
    }

    private function UpdateCountString()
    {
      $count = count($this->matchingIds);

      if($count == 0 || $count >= 5)
      {
        $this->countString = $count." wyników";
      }
      else if ($count == 1)
      {
        $this->countString = $count." wynik";
      }
      else
      {
        $this->countString = $count." wyniki";
      }
    }

    private function DisplayLists()
    {
      $browse = new Browse();
      foreach($this->matchingIds as $id)
      {
        $browse->DrawListCard($id);
      }
    }

    private function DrawErrorMessage()
    {
      ?>
      <div class = "error_card">
          <h2>Coś poszło nie tak...</h2>
          <hr>
          <span>Błędny adres URL.</span>
      </div>
      <?php
    }
}

?>
