<?php
namespace BooklyPackages\Frontend\Modules\CustomerPackages;

use Bookly\Lib as BooklyLib;
use BooklyPackages\Lib;

/**
 * Class ShortCode
 * @package BooklyPackages\Frontend\Modules\CustomerPackages
 */
class ShortCode extends BooklyLib\Base\Component
{
    /**
     * Init component.
     */
    public static function init()
    {
        // Register shortcodes.
        add_shortcode( 'bookly-packages-list', array( __CLASS__, 'render' ) );

        // Assets.
        if ( get_option( 'bookly_gen_link_assets_method' ) == 'enqueue' ) {
            add_action( 'wp_enqueue_scripts', array( __CLASS__, 'linkStyles' ) );
            add_action( 'wp_enqueue_scripts', array( __CLASS__, 'linkScripts' ) );
        } else {
            add_action( 'wp_print_styles', array( __CLASS__, 'linkStyles' ) );
            add_action( 'wp_print_scripts', array( __CLASS__, 'linkScripts' ) );
        }
    }

    /**
     * Link styles.
     */
    public static function linkStyles()
    {
        if (
            get_option( 'bookly_gen_link_assets_method' ) == 'enqueue' ||
            BooklyLib\Utils\Common::postsHaveShortCode( 'bookly-packages-list' )
        ) {
            $bookly_ver = BooklyLib\Plugin::getVersion();
            $bookly_url = plugins_url( '', BooklyLib\Plugin::getMainFile() );
            $packages   = plugins_url( '', Lib\Plugin::getMainFile() );

            wp_enqueue_style( 'bookly-ladda-min', $bookly_url . '/frontend/resources/css/ladda.min.css', array(), $bookly_ver );
            wp_enqueue_style( 'bookly-bootstrap-theme', $bookly_url . '/backend/resources/bootstrap/css/bootstrap-theme.min.css', array( 'dashicons' ), $bookly_ver );
            wp_enqueue_style( 'bookly-customer-packages', $packages  . '/frontend/modules/customer_packages/resources/css/customer_packages.css', array( 'bookly-bootstrap-theme' ), Lib\Plugin::getVersion() );
        }
    }

    /**
     * Link scripts.
     */
    public static function linkScripts()
    {
        if (
            get_option( 'bookly_gen_link_assets_method' ) == 'enqueue' ||
            BooklyLib\Utils\Common::postsHaveShortCode( 'bookly-packages-list' )
        ) {
            $bookly_ver = BooklyLib\Plugin::getVersion();
            $bookly_url = plugins_url( '', BooklyLib\Plugin::getMainFile() );
            $packages   = plugins_url( '', Lib\Plugin::getMainFile() );

            wp_enqueue_script( 'bookly-spin', $bookly_url . '/frontend/resources/js/spin.min.js', array(), $bookly_ver );
            wp_enqueue_script( 'bookly-ladda', $bookly_url . '/frontend/resources/js/ladda.min.js', array( 'bookly-spin' ), $bookly_ver );
            wp_enqueue_script( 'bookly-bootstrap', $bookly_url . '/backend/resources/bootstrap/js/bootstrap.min.js', array(), $bookly_ver );
            wp_enqueue_script( 'bookly-range-tools', $bookly_url . '/backend/resources/js/range_tools.js', array( 'jquery' ), $bookly_ver );
            wp_enqueue_script( 'bookly-datatables', $bookly_url . '/backend/resources/js/datatables.min.js', array( 'jquery' ), $bookly_ver );
            wp_enqueue_script( 'bookly-customer-packages', $packages   . '/frontend/modules/customer_packages/resources/js/customer_packages.js', array( 'bookly-datatables' ), Lib\Plugin::getVersion() );

            wp_localize_script( 'bookly-customer-packages', 'BooklyCustomerPackagesL10n', array(
                'zeroRecords'          => __( 'No packages for selected period and criteria.', 'bookly' ),
                'scheduleAppointments' => __( 'Package schedule', 'bookly' ),
                'processing'           => __( 'Processing...', 'bookly' ),
                'useClientTimeZone'    => BooklyLib\Config::useClientTimeZone(),
                'csrf_token'           => BooklyLib\Utils\Common::getCsrfToken(),
            ) );
        }
    }

    /**
     * @param $attributes
     * @return string
     */
    public static function render( $attributes )
    {
        // Disable caching.
        BooklyLib\Utils\Common::noCache();

        $customer = new BooklyLib\Entities\Customer();
        $customer->loadBy( array( 'wp_user_id' => get_current_user_id() ) );

        // Prepare URL for AJAX requests.
        $ajax_url = admin_url( 'admin-ajax.php' );

        $form_id = uniqid();

        return self::renderTemplate( 'short_code', compact( 'ajax_url', 'customer', 'form_id' ), false );
    }
}