<?php
    require_once '../php/phpHeader.php';
    $header = new PhpHeader();

    require_once 'createListFilter.php';

    require_once 'lastListsController.php';

    class ListProperties
    {
        public $id;
        public $name;
        public $isPublic;
        public $ownerId;
        public $editToken;
    }

    class Edit
    {
        public $noGetError;
        public $permissionError;
        public $otherError;

        public $listProps;

        public function CheckPermissions()
        {
            global $header;

            $this->noGetError = false;
            $this->permissionError = false;
            $this->otherError = false;

            if(!isset($_GET["list_id"]))
            {
                $this->noGetError = true;
                return false;
            }
            else
            {
                $id = TestInput($_GET["list_id"]);
                if(!is_numeric($id))
                {
                    //id is not numeric
                    $this->noGetError = true;
                    return false;
                }
                else
                {
                    //id is ok
                    //check permissions

                    //get list properties
                    $sql = "SELECT `Name`, `Public`, `OwnerId`, `Edit_token` FROM `Lists` WHERE `Id` = '".$id."';";
                    $result = Query($sql);

                    if($result->num_rows > 0)
                    {
                        $this->listProps = new ListProperties();

                        $row = $result->fetch_assoc();

                        $this->listProps->id = $id;
                        $this->listProps->name = $row["Name"];
                        $this->listProps->isPublic = $row["Public"];
                        $this->listProps->ownerId = $row["OwnerId"];
                        $this->listProps->editToken = $row["Edit_token"];

                        if($this->listProps->isPublic)
                        {
                            //the list is public...
                            if($_SESSION["login_id"] > 0)
                            {
                                //...and user is logged
                                //check if the id's matches
                                if($this->listProps->ownerId == $_SESSION["login_id"])
                                {
                                    return true;
                                }
                                else
                                {
                                    $this->permissionError = true;
                                    return false;
                                }
                            }
                            else
                            {
                                //...and user is not logged
                                //check if token matches
                                if($this->listProps->editToken == $header->editTokens->editToken)
                                {
                                    return true;
                                }
                                else
                                {
                                    $this->permissionError = true;
                                    return false;
                                }
                            }
                        }
                        else
                        {
                            //the list isn't public
                            if($_SESSION["login_id"] == $this->listProps->ownerId)
                            {
                                return true;
                            }
                            else
                            {
                                $this->permissionError = true;
                                return false;
                            }
                        }
                    }
                    else
                    {
                        $this->otherError = true;
                        return false;
                    }
                }
            }
        }

        public function LoadCards() {
            //function is called after checking permissions so list props is not null, but let's check it anyway
            if($this->listProps != null)
            {
                $sql = "SELECT `Id`, `English`, `Polish` FROM `Words` WHERE `List_id`='".$this->listProps->id."';";
                $result = Query($sql);

                $lastListsController = new LastListsController(); //for last lists card in 'przegladaj'
                $lastListsController->AddNewRecord($this->listProps->id);

                ?>
                <div class = "scroll">
                <?php

                if($result->num_rows > 0)
                {
                    //display already added cards
                    while($row = $result->fetch_assoc())
                    {
                        //display row
                        $en = $row["English"];
                        $pl = $row["Polish"];
                        $word_id = $row["Id"];

                        ?>
                        <div id = "<?php echo "card_".$word_id; ?>" class = "added_card">
                                <div class = "button_container">
                                    <button onclick = "DeleteWord(<?php echo $word_id.",".$this->listProps->id ?>)"class = "delete_button">Usuń</button>
                                </div>
                                <div class = "input_container">
                                    <div class = "inputfield_container_left"><input onblur = "AlterWord(<?php echo $this->listProps->id.",".$word_id ?>)" class = "english_input_accepted" name = "english_input" type = "text" placeholder = "Angielski" value = "<?php echo $en; ?>"></div>
                                    <div class = "inputfield_container_right"><input onblur = "AlterWord(<?php echo $this->listProps->id.",".$word_id ?>)" class = "polish_input_accepted" name = "polish_input" type = "text" placeholder = "Polski" value = "<?php echo $pl;?>"></div>
                                </div>
                        </div>
                        <?php
                    }
                }
                //display adding form
                ?>
                <div id = "add_space"></div>
                <div class = "add_card">
                        <div class = "button_container">
                            <button onclick = "AddWord(<?php echo $this->listProps->id ?>)" id = "add_button_id" class = "add_button">Dodaj</button>
                        </div>
                        <div class = "input_container">
                            <div class = "inputfield_container_left"><input id = "english_input" name = "english_input" onkeypress="return searchKeyPress(event);" type = "text" placeholder = "Angielski" required></div>
                            <div class = "inputfield_container_right"><input id = "polish_input" name = "polish_input" onkeypress="return searchKeyPress(event);" type = "text" placeholder = "Polski" required></div>
                        </div>
                </div>
                </div>
                <?php
            }
        }
    }
?>