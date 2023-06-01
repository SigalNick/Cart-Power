<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

$short_url = $_REQUEST['short_url'];

if ($short_url) {
    $product_id = get_product_id_by_short_url($short_url);
    if ($product_id) {
        return array(CONTROLLER_STATUS_REDIRECT, "products.view?product_id=$product_id");
    }
}

fn_set_notification('E', __('error'), __('wrong_short_url'));
return array(CONTROLLER_STATUS_REDIRECT, "index");