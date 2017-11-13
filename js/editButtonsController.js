function PopupDelete()
{
    document.getElementById("modal_fade_id").style.display = "block";
}

function PopupRefuse()
{
    document.getElementById("modal_fade_id").style.display = "none";
}

function PopupDeleteBrowse(id)
{
    document.getElementById("delete_id").setAttribute("href", "../php/deletePermanentRedirect.php?q=" + id);
    PopupDelete();
}