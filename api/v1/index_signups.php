<?php


ini_set('default_charset', 'UTF-8');
header('Content-Type: application/json;charset=UTF-8');
require_once('../../../../../wp-config.php');

$concert_id = 'all';

$args =  array(
    'post_type'  => 'signup',
    'posts_per_page' => -1,
    'post_status' => 'publish',
);


if (isset($_GET['id'])) {
    $concert_id = $_GET['id'];
    $args['post_parent'] = $concert_id;
}

$requests_array = get_posts($args);



$data =  'nom;concert;date'  .   "\n";


foreach ($requests_array as $request) {


    $name =  $request->post_title;
    $concert = get_post($request->post_parent);
    $user = get_user_by('id', $request->post_author);


    $ar = array(
        $user->user_nicename,
        $concert->post_title,
        $concert->post_date,
    );

    $data .=  implode(';', $ar);
    $data .=  "\n";
}


$encoded_csv = mb_convert_encoding($data, 'UTF-16LE', 'UTF-8');

$file = "inscriptions_{$concert_id}";
$filename = $file . '_' . date('Y-m-d_H-i', time());
header('Content-type: application/vnd.ms-excel');
header('Content-disposition: csv' . date('Y-m-d') . '.csv');
header('Content-disposition: filename=' . $filename . '.csv');
// header('Content-Length: ' . strlen($encoded_csv));
$encoded_csv =   chr(255) . chr(254) . $encoded_csv;
print $encoded_csv;


//print_r ($data);

exit;
