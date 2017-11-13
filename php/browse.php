<?php
    require_once 'phpHeader.php';
    $header = new PhpHeader();

    require_once 'edit.php';
    require_once 'checkPermission.php';

class Browse
{
    public function DisplayYourLists()
    {
        global $header;

        if($_SESSION["login_id"] > 0)
        {
            //use login id
            $id = TestInput($_SESSION["login_id"]);
            $sql = "SELECT `Id` FROM `Lists` WHERE `OwnerId` = '".$id."' AND `Public` = '0';";

            $result = Query($sql);

            $zero = false;

            if($result->num_rows > 0)
            {
                ?>
                <div class = "headerCardBrowse"><h3>Prywatne:</h3></div>
                <?php

                while ($row = $result->fetch_assoc())
                {
                    $list_id = $row["Id"];
                    $this->DrawListCard($list_id);
                }
            }
            else $zero = true;

            $sql = "SELECT `Id` FROM `Lists` WHERE `OwnerId` = '".$id."' AND `Public` = '1';";

            $result = Query($sql);

            if($result->num_rows > 0)
            {
                ?>
                <div class = "headerCardBrowse"><h3>Publiczne:</h3></div>
                <?php

                while ($row = $result->fetch_assoc())
                {
                    $list_id = $row["Id"];
                    $this->DrawListCard($list_id);
                }
            }
            else
            {
                if($zero == true)
                {
                    ?>
                    <div class = "headerCardBrowse"><h3>Brak list do wyświetlenia.</h3></div>
                    <?php
                }
            }
        }
        else
        {
            //use login token
            $login_token = $header->editTokens->editToken;

            $sql = "SELECT `Id` FROM `Lists` WHERE `OwnerId` = '0' AND `Public` = '1' AND `Edit_token` = '".$login_token."';";

            $result = Query($sql);

            if($result->num_rows > 0)
            {
                while ($row = $result->fetch_assoc())
                {
                    $list_id = $row["Id"];
                    $this->DrawListCard($list_id);
                }
            }
            else
            {
                ?>
                <div class = "headerCardBrowse"><h3>Brak list do wyświetlenia.</h3></div>
                <?php
            }
        }
    }

    public function DisplayRecommenedLists()
    {
        $sql = "SELECT `List_id` FROM `Recommended`;";
        $result = Query($sql);

        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $list_id = $row["List_id"];
                $this->DrawListCard($list_id);
            }
        }
        else
        {
            ?>
            <div class = "headerCardBrowse"><h3>Brak list do wyświetlenia.</h3></div>
            <?php
        }
    }

    public function DisplayLastLists()
    {
        $listController = new LastListsController();
        $listIds = $listController->GetLastListIds();

        if($listIds == null)
        {
            ?>
            <div class = "headerCardBrowse"><h3>Brak list do wyświetlenia.</h3></div>
            <?php
        }
        else
        {
            for($i = 0; $i < count($listIds); $i++)
            {
                $this->DrawListCard($listIds[$i]);
            }
        }
    }

    public function DrawListCard($list_id)
    {
        $id = TestInput($list_id);

        //get information about the list
        $sql = "SELECT `Name` FROM `Lists` WHERE `Id`='".$id."';";

        $result = Query($sql);

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $name = $row["Name"];

            ?>
            <div class = "list_card">
                <p><?php $this->ShowCountCards($id); ?></p>
                <h3><?php echo $name; ?></h3>
                <hr>
                <?php $this->DrawButtons($id); ?>
            </div>
            <?php
        }
        else
        {
            ?>
            <div class = "list_card">
                <h3>Podczas ładowania danych wystąpił błąd.</h3>
                <hr>
            </div>
            <?php
        }
    }

    private function CountCards($list_id)
    {
        $sql = "SELECT `Id` FROM `Words` WHERE `List_id` = '".$list_id."';";
        $result = Query($sql);

        return $result->num_rows;
    }

    private function ShowCountCards($list_id)
    {
        $count = $this->CountCards(($list_id));
        if($count == 0 || $count >= 5)
        {
            echo $count." fiszek";
        }
        else if($count == 1)
        {
            echo "1 fiszka";
        }
        else
        {
            echo $count." fiszki";
        }
    }

    private function DrawButtons($list_id)
    {
        if(CheckPermission($list_id))
        {
            ?>
            <div class = "list_button">
                <a href = "../edycja/index.php?list_id=<?php echo $list_id; ?>"><button class = "edit_button">Edycja</button></a>
            </div>
            <div class = "list_button">
                <button onclick = "PopupDeleteBrowse(<?php echo $list_id;?>)" class = "edit_button">Usuń</button>
            </div>
            <div class = "list_button">
                <a href = "../test/index.php?id=<?php echo $list_id; ?>"><button class = "edit_button">Nauka</button><a/>
            </div>
            <div class = "list_button">
                <a href = "../test/quick.php?id=<?php echo $list_id; ?>"><button class = "edit_button">Szybki test</button></a>
            </div>
            <?php
        }
        else
        {
            ?>
            <div class = "list_button">
                <a href = "../test/index.php?id=<?php echo $list_id; ?>"><button class = "edit_button">Nauka</button><a/>
            </div>
            <div class = "list_button">
                <a href = "../test/quick.php?id=<?php echo $list_id; ?>"><button class = "edit_button">Szybki test</button></a>
            </div>
            <?php
        }
    }
}
