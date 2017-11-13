<?php
require_once 'checkPermission.php';
require_once 'lastListsController.php';

class QuickTest
{
    private $permission;
    private $listId;

    public function GetPermission()
    {
        return $this->permission;
    }

    public function GetListId()
    {
        return $this->listId;
    }

    function __construct($list_id)
    {
        $this->listId = $list_id;

        if(is_numeric($list_id))
        {
            $this->permission = CheckPermissionTest($list_id);
            if($this->permission)
            {
              $lastListsController = new LastListsController(); //for last lists card in 'przegladaj'
              $lastListsController->AddNewRecord($this->listId);
            }
        }
        else
        {
            $this->permission = false;
        }
    }
}
