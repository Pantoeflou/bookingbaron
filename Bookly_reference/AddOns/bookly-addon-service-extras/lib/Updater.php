<?php
namespace BooklyServiceExtras\Lib;

use Bookly\Lib as BooklyLib;

/**
 * Class Updater
 * @package BooklyServiceExtras\Lib
 */
class Updater extends BooklyLib\Base\Updater
{
    public function update_2_2()
    {
        add_option( 'bookly_service_extras_after_step_time', '0' );
    }

    public function update_2_1()
    {
        /** @global \wpdb $wpdb */
        global $wpdb;

        // Rename tables.
        $tables = array(
            'service_extras',
        );
        $query = 'RENAME TABLE ';
        foreach ( $tables as $table ) {
            $query .= sprintf( '`%s` TO `%s`, ', $this->getTableName( 'ab_' . $table ), $this->getTableName( 'bookly_' . $table ) );
        }
        $query = substr( $query, 0, -2 );
        $wpdb->query( $query );
    }

    function update_1_22()
    {
        add_option( 'bookly_service_extras_multiply_nop', '1' );
    }

    function update_1_16()
    {
        add_option( 'bookly_service_extras_show_in_cart', '1' );
    }

    function update_1_14()
    {
        $this->addL10nOptions( array( 'bookly_l10n_step_extras_button_next' => __( 'Next', 'bookly' ) ) );
    }

    function update_1_11()
    {
        $options = array(
            'ab_appearance_text_step_extras'      => 'bookly_l10n_step_extras',
            'ab_appearance_text_info_extras_step' => 'bookly_l10n_info_extras_step',
        );
        $this->renameL10nStrings( $options );
    }

    function update_1_4()
    {
        /** \wpdb $wpda */
        global $wpdb;

        /** @var \Bookly\Lib\Entities\CustomerAppointment[] $appointments */
        $appointments = \Bookly\Lib\Entities\CustomerAppointment::query( 'ca' )
            ->select( 'ca.*' )
            ->whereNot( 'ca.extras', '[]' )
            ->order( 'DESC' )
            ->find();
        foreach ( $appointments as $appointment ) {
            $extras_old = (array) json_decode( $appointment->getExtras(), true );
            if ( isset ( $extras_old[0] ) ) {
                $extras = array();
                foreach ( $extras_old as $extras_id ) {
                    $extras[ $extras_id ] = 1;
                }
                $appointment->setExtras( json_encode( $extras ) );
                $appointment->save();
            }
        }

        $wpdb->query( 'ALTER TABLE `' . Entities\ServiceExtra::getTableName() . '` ADD COLUMN `max_quantity` INT NOT NULL DEFAULT 1' );
    }

    function update_1_3()
    {
        $this->renameOptions( array( 'bookly_service_extras_loaded' => 'bookly_service_extras_data_loaded' ) );
    }

    function update_1_2()
    {
        if ( get_option( 'bookly_service_extras_step_extras_enabled', 'missing' ) != 'missing' ) {
            $this->renameOptions( array( 'bookly_service_extras_step_extras_enabled' => 'bookly_service_extras_enabled' ) );
        }
    }

}