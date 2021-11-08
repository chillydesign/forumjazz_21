<?php


ini_set('default_charset', 'UTF-8');
header('Content-Type: application/json;charset=UTF-8');
require_once('../../../../../wp-config.php');

$participants = get_users(
    array(
        'role__in' =>  array('participant', 'intervenant'),
        'number' => -1,
        'orderby' => 'ID',
        'order' => 'ASC',
    )
);

$product_ids =  array(531, 532, 533, 534);


$data =  'ID;Date;Prénom;Nom;Email;Structure;Position;Site web;Mercredi;Jeudi;Vendredi;Samedi'  .   "\n";

foreach ($participants as $participant) {


    $structure =  get_field('structure_name',  "user_" . $participant->ID);
    $position =  get_field('structure_position',  "user_" . $participant->ID);
    $website =  get_field('structure_website',  "user_" . $participant->ID);


    $ar = array(
        $participant->ID,
        $participant->user_registered,
        $participant->first_name,
        $participant->last_name,
        $participant->user_email,
        api_save_csv_string($structure),
        api_save_csv_string($position),
        api_save_csv_string($website),
    );

    foreach ($product_ids as $product_id) {

        $has_bought =  wc_customer_bought_product(
            $participant->user_email,
            $participant->ID,
            $product_id
        );
        if ($has_bought) {
            array_push($ar, 'Oui');
        } else {
            array_push($ar, 'Non');
        }
    }



    $data .=  implode(';', $ar);
    $data .=  "\n";
}


$encoded_csv = mb_convert_encoding($data, 'UTF-16LE', 'UTF-8');

$file = 'customers';
$filename = $file . '_' . date('Y-m-d_H-i', time());
header('Content-type: application/vnd.ms-excel');
header('Content-disposition: csv' . date('Y-m-d') . '.csv');
header('Content-disposition: filename=' . $filename . '.csv');
// header('Content-Length: ' . strlen($encoded_csv));
$encoded_csv =   chr(255) . chr(254) . $encoded_csv;
print $encoded_csv;


// var_dump($data);

exit;
