<?php


ini_set('default_charset', 'UTF-8');
header('Content-Type: application/json;charset=UTF-8');
require_once('../../../../../wp-config.php');

$requests_array = get_posts(
    array(
        'post_type'  => 'prix',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    )
);

$data =  'nom;prenom;email;etablissement;justification;concert;ipaddress'  .   "\n";

foreach ($requests_array as $request) {


    $first_name = get_field('first_name', $request->ID);
    $last_name = get_field('last_name', $request->ID);
    $email = get_field('email', $request->ID);
    $etablissement = get_field('etablissement', $request->ID);
    $justification = get_field('justification', $request->ID);
    $concert_id = get_field('concert_id', $request->ID);
    $concert = get_post($concert_id);
    $ip_address = get_field('ip_address', $request->ID);

    $ar = array(
        $first_name,
        $last_name,
        $email,
        $etablissement,
        $justification,
        $concert->post_title,
        $ip_address,
    );

    //$data .=  implode(',', $ar);
    $data .=  implode(';', $ar);
    $data .=  "\n";
}


$encoded_csv = mb_convert_encoding($data, 'UTF-16LE', 'UTF-8');

$file = 'votes';
$filename = $file . '_' . date('Y-m-d_H-i', time());
header('Content-type: application/vnd.ms-excel');
header('Content-disposition: csv' . date('Y-m-d') . '.csv');
header('Content-disposition: filename=' . $filename . '.csv');
// header('Content-Length: ' . strlen($encoded_csv));
$encoded_csv =   chr(255) . chr(254) . $encoded_csv;
print $encoded_csv;


//print_r ($data);

exit;
