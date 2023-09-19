<?php

namespace Interfaces;

Interface ValidationInterface {
    public function check_empty_field($data, $fields);
    public function is_valid_title($name);
    public function is_valid_price($price);
    public function is_upload($image);
    public function check_atleast_one_category($category);
}