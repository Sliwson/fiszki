<?php
require_once 'edit.php';
require_once 'phpHeader.php';

function CheckPermission ($listId)
{
    $header = new PhpHeader();

    $sql = "SELECT `Name`, `Public`, `OwnerId`, `Edit_token` FROM `Lists` WHERE `Id` = '".$listId."';";
    $result = Query($sql);

    if($result->num_rows > 0)
    {
        $listProps = new ListProperties();

        $row = $result->fetch_assoc();

        $listProps->id = $listId;
        $listProps->name = $row["Name"];
        $listProps->isPublic = $row["Public"];
        $listProps->ownerId = $row["OwnerId"];
        $listProps->editToken = $row["Edit_token"];

        if($listProps->isPublic)
        {
            //the list is public...
            if($_SESSION["login_id"] > 0)
            {
                //...and user is logged
                //check if the id's matches
                if($listProps->ownerId == $_SESSION["login_id"])
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                //...and user is not logged
                //check if token matches
                if($listProps->editToken == $header->editTokens->editToken)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        else
        {
            //the list isn't public
            if($_SESSION["login_id"] == $listProps->ownerId)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    else
    {
        return false;
    }
}

function CheckPermissionTest($listId)
{
    $header = new PhpHeader();

    $sql = "SELECT `Public`, `OwnerId` FROM `Lists` WHERE `Id` = '".$listId."';";
    $result = Query($sql);

    if($result->num_rows > 0)
    {
        $listProps = new ListProperties();

        $row = $result->fetch_assoc();

        $listProps->id = $listId;
        $listProps->isPublic = $row["Public"];
        $listProps->ownerId = $row["OwnerId"];

        if($listProps->isPublic)
        {
            return true;
        }
        else
        {
            //the list isn't public
            if($_SESSION["login_id"] == $listProps->ownerId)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    else
    {
        return false;
    }
}