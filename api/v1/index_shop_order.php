<?php


ini_set('default_charset', 'UTF-8');
header('Content-Type: application/json;charset=UTF-8');
require_once('../../../../../wp-config.php');

$requests_array = get_posts(
    array(
        'post_type'  => 'shop_order',
        'posts_per_page' => -1,
        'post_status' => 'any'

    )
);

$data =  'id;date;status;total;items;user;email;Structure;Fonction;Site web'  .   "\n";

foreach ($requests_array as $request) {


    $order = wc_get_order($request->ID);

    $items = array();
    foreach ($order->get_items() as $item_id => $item) {
        $product_name = $item->get_name();
        array_push($items, $product_name);
    }

    $user_id = $order->get_user_id();
    $structure =  get_field('structure_name',  "user_" . $user_id);
    $position =  get_field('structure_position',  "user_" . $user_id);
    $website =  get_field('structure_website',  "user_" . $user_id);



    $ar = array(
        $request->ID,
        $request->post_date,
        $request->post_status,
        $order->get_total(),
        implode('|', $items),
        $order->get_formatted_billing_full_name(),
        $order->get_billing_email(),
        $structure,
        $position,
        $website,
    );

    $data .=  implode(';', $ar);
    $data .=  "\n";
}


$encoded_csv = mb_convert_encoding($data, 'UTF-16LE', 'UTF-8');

$file = 'orders';
$filename = $file . '_' . date('Y-m-d_H-i', time());
header('Content-type: application/vnd.ms-excel');
header('Content-disposition: csv' . date('Y-m-d') . '.csv');
header('Content-disposition: filename=' . $filename . '.csv');
// header('Content-Length: ' . strlen($encoded_csv));
$encoded_csv =   chr(255) . chr(254) . $encoded_csv;
print $encoded_csv;



exit;
