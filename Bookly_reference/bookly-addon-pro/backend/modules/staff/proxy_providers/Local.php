<?php
namespace BooklyPro\Backend\Modules\Staff\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Backend\Modules\Staff\Proxy;
use BooklyPro\Lib;

/**
 * Class Local
 * @package BooklyPro\Backend\Modules\Staff\ProxyProviders
 */
class Local extends Proxy\Pro
{
    /**
     * @inheritdoc
     */
    public static function getCategoriesList()
    {
        return Lib\Entities\StaffCategory::query()->sortBy( 'position' )->fetchArray();
    }

    /**
     * @inheritdoc
     */
    public static function renderGoogleCalendarSettings( array $tpl_data )
    {
        self::renderTemplate( 'google_calendar_settings', $tpl_data['gc'] );
    }

    /**
     * @inheritdoc
     */
    public static function renderStaffList()
    {
        self::renderTemplate( 'category_dialog' );
        self::renderArchivingComponents();
    }

    /**
     * @inheritdoc
     */
    public static function renderStaffPositionMessage()
    {
        self::renderTemplate( 'position_message' );
    }

    /**
     * Render archiving confirmation dialog
     */
    private static function renderArchivingComponents()
    {
        self::enqueueScripts( array(
            'module'   => array( 'js/archive.js' => array( 'jquery' ), ),
            'frontend' => array(
                'js/spin.min.js'  => array( 'jquery' ),
                'js/ladda.min.js' => array( 'jquery' ),
            ),
        ) );

        wp_localize_script( 'bookly-archive.js', 'BooklyL10nStaffArchive', array(
            'csrfToken'         => BooklyLib\Utils\Common::getCsrfToken(),
            'areYouSure'        => __( 'Are you sure?', 'bookly' ),
            'showArchivedStaff' => __( 'Show archived staff', 'bookly' ),
            'hideArchivedStaff' => __( 'Hide archived staff', 'bookly' ),
        ) );

        self::renderTemplate( 'archive_toggle' );
        self::renderTemplate( 'archive_dialog' );
    }

    /**
     * @inheritdoc
     */
    public static function updateCategoriesPositions( $categories )
    {
        foreach ( $categories as $position => $category_id ) {
            $category = Lib\Entities\StaffCategory::find( $category_id );
            $category->setPosition( $position )->save();
        }
    }

    /**
     * @inheritdoc
     */
    public static function renderStaffDetails( $staff )
    {
        $categories   = Lib\Entities\StaffCategory::query()->sortBy( 'position' )->fetchArray();
        $categories[] = array( 'id' => null, 'name' => __( 'Uncategorized', 'bookly' ) );

        self::renderTemplate( 'staff_details', compact( 'categories', 'staff' ) );
    }

}