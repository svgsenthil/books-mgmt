<?php

include_once "Interfaces\ValidationInterface.php";

use Interfaces\ValidationInterface;

class Validation Implements ValidationInterface {

    public function check_empty_field($data, $fields)
    {
        $err_message = null;

        foreach($fields as $field):
            if(empty($data[$field])):
                $err_message .= "<p class='error'>$field field is required!</p>";
            endif;
        endforeach;

        return $err_message;
    }

    public function is_valid_title($name)
    {
        return strlen($name) > 100 ? true : false;
    }

    public function is_valid_price($price)
    {
        return (is_numeric($price) && $price > 5 && $price < 1000) ? false : true;
    }

    public function is_upload($image)
    {
        $upload_dir = 'uploads/';

        $imgName = $image['name'];
        $imgTmp = $image['tmp_name'];
        $imgSize = $image['size'];

        $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
        $allowExt  = array('jpeg', 'jpg', 'png');

        if (in_array($imgExt, $allowExt)) {
            if ($imgSize < 5000000) {
                move_uploaded_file($imgTmp, $upload_dir.$imgName);
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    public function check_atleast_one_category($checkboxArray)
    {
        if (count($checkboxArray, COUNT_NORMAL) > 0) {
            return false;
        } else {
            return true;
        }
    }
}