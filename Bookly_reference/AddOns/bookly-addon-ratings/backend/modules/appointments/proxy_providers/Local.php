<?php
namespace BooklyRatings\Backend\Modules\Appointments\ProxyProviders;

use Bookly\Backend\Modules\Appointments\Proxy\Ratings as RatingsProxy;

/**
 * Class Local
 * @package BooklyRatings\Backend\Modules\Appointments\ProxyProviders
 */
class Local extends RatingsProxy
{
    /**
     * Render column title for Appointments table
     */
    public static function renderTableHeader()
    {
        printf( '<th>%s</th>', __( 'Rating', 'bookly' ) );
    }

    /**
     * Render 'Ratings' in appointments export popup
     * @param int $column
     */
    public static function renderExport( $column )
    {
        printf( '<div class="checkbox"><label><input checked value="%d" type="checkbox"/>%s</label></div>', $column, __( 'Rating', 'bookly' ) );
    }
}