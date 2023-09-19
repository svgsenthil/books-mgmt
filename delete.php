<?php

include "utility/autoload.php";

$crud = new Crud;
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');


//Delete Record form Database
if($_SERVER['REQUEST_METHOD'] == "GET"): 
    $crud->id    = $id; var_dump($crud->id);
    $delete_data = $crud->delete();

    if($delete_data):
        header("location:show-books.php?record_delete_status=success");
    else:
        echo "<div class='text-center'><p>Data has not been deleted</p></div>";
    endif;
endif;