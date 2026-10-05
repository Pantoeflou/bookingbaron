<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$codes = array(
    array( 'code' => 'list', 'description' => __( 'pages with another time', 'bookly' ) ),
);

echo Bookly\Lib\Utils\Common::codes( $codes );