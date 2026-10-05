<?php
namespace BooklyServiceExtras\Lib\Utils;

/**
 * Class Common
 * @package BooklyServiceExtras\Lib\Utils
 */
abstract class Common
{
    /**
     * Format title to "Q x TITLE" when Q > 1.
     *
     * @param string $title
     * @param integer $quantity
     * @return string
     */
    public static function formatTitle( $title, $quantity )
    {
        return ( $quantity > 1 ) ? $quantity . '&nbsp;&times;&nbsp;' . $title : $title;
    }

}