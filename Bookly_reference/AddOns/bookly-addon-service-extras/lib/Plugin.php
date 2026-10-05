<?php
namespace BooklyServiceExtras\Lib;

use Bookly\Lib as BooklyLib;
use BooklyServiceExtras\Backend\Modules as Backend;
use BooklyServiceExtras\Frontend\Modules\Booking;
use BooklyServiceExtras\Backend\Components;

/**
 * Class Plugin
 * @package BooklyServiceExtras\Lib
 */
abstract class Plugin extends BooklyLib\Base\Plugin
{
    protected static $prefix;
    protected static $title;
    protected static $version;
    protected static $slug;
    protected static $directory;
    protected static $main_file;
    protected static $basename;
    protected static $text_domain;
    protected static $root_namespace;
    protected static $embedded;

    /**
     * @inheritdoc
     */
    protected static function init()
    {
        // Init ajax.
        Backend\Services\Ajax::init();

        // Init proxy.
        Backend\Appearance\ProxyProviders\Local::init();
        Backend\Appearance\ProxyProviders\Shared::init();
        Backend\Calendar\ProxyProviders\Shared::init();
        Backend\Notifications\ProxyProviders\Shared::init();
        Backend\Services\ProxyProviders\Shared::init();
        Backend\Settings\ProxyProviders\Shared::init();
        if ( get_option( 'bookly_service_extras_enabled' ) ) {
            Booking\ProxyProviders\Shared::init();
            Booking\ProxyProviders\Local::init();
        }
        Components\Appearance\ProxyProviders\Shared::init();
        Components\Dialogs\Appointment\CustomerDetails\ProxyProviders\Shared::init();
        Components\Dialogs\Appointment\Edit\ProxyProviders\Shared::init();
        Notifications\Assets\Item\ProxyProviders\Shared::init();
        ProxyProviders\Local::init();
    }

}