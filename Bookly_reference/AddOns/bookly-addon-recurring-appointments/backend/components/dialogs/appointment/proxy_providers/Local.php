<?php
namespace BooklyRecurringAppointments\Backend\Components\Dialogs\Appointment\ProxyProviders;

use Bookly\Lib as BooklyLib;
use BooklyRecurringAppointments\Lib;
use Bookly\Backend\Components\Dialogs\Appointment\Edit\Proxy\RecurringAppointments as RecurringAppointmentsProxy;

/**
 * Class Local
 * @package BooklyRecurringAppointments\Backend\Components\Dialogs\Appointment
 */
class Local extends RecurringAppointmentsProxy
{
    /**
     * @inheritdoc
     */
    public static function renderSubForm()
    {
        /** @var \WP_Locale $wp_locale */
        global $wp_locale;

        $start_of_week = get_option( 'start_of_week' );
        $weekdays      = array( 'sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat' );

        // Sort days considering start_of_week;
        uksort( $weekdays, function ( $a, $b ) use ( $start_of_week ) {
            $a -= $start_of_week;
            $b -= $start_of_week;
            if ( $a < 0 ) {
                $a += 7;
            }
            if ( $b < 0 ) {
                $b += 7;
            }

            return $a - $b;
        } );

        self::renderTemplate( 'sub_form', array( 'weekdays' => $weekdays, 'weekday_abbrev' => array_values( $wp_locale->weekday_abbrev ) ) );
    }

    /**
     * @inheritdoc
     */
    public static function renderSchedule()
    {
        self::renderTemplate( 'schedule' );
    }

    /**
     * @inheritdoc
     */
    public static function createBackendPayment( BooklyLib\Entities\Series $series, $customer )
    {
        $price = $customer['payment_price'];
        $tax   = $customer['payment_tax'] ?: 0;

        $ca_list = BooklyLib\Entities\CustomerAppointment::query( 'ca' )
            ->leftJoin( 'Appointment', 'a', 'a.id = ca.appointment_id' )
            ->where( 'ca.series_id', $series->getId() )
            ->where( 'ca.customer_id', $customer['id'] )
            ->sortBy( 'a.start_date' )
            ->find();

        $items = array();

        /** @var BooklyLib\Entities\CustomerAppointment $ca */
        foreach ( $ca_list as $ca ) {
            $appointment = BooklyLib\Entities\Appointment::find( $ca->getAppointmentId() );
            if ( $appointment->getCustomServiceName() === null ) {
                $service  = BooklyLib\Entities\Service::find( $appointment->getServiceId() );
                $title    = $service->getTitle();
                $duration = $service->getDuration();
            } else {
                $title    = $appointment->getCustomServiceName();
                $duration = strtotime( $appointment->getEndDate() ) - strtotime( $appointment->getStartDate() );
            }

            $staff  = BooklyLib\Entities\Staff::find( $appointment->getStaffId() );
            $extras = array();
            if ( $ca->getExtras() != '[]' ) {
                $_extras = json_decode( $ca->getExtras(), true );
                /** @var \BooklyServiceExtras\Lib\Entities\ServiceExtra $extra */
                foreach ( (array) BooklyLib\Proxy\ServiceExtras::findByIds( array_keys( $_extras ) ) as $extra ) {
                    $quantity = $_extras[ $extra->getId() ];
                    $extras[] = array(
                        'title'    => $extra->getTitle(),
                        'price'    => $extra->getPrice(),
                        'quantity' => $quantity,
                    );
                }
            }

            $item = array(
                'ca_id'             => $ca->getId(),
                'appointment_date'  => $appointment->getStartDate(),
                'service_name'      => $title,
                'service_price'     => $price / count( $ca_list ),
                'service_tax'       => $tax / count( $ca_list ),
                'wait_listed'       => $ca->getStatus() == $ca::STATUS_WAITLISTED,
                'number_of_persons' => $ca->getNumberOfPersons(),
                'units'             => $ca->getUnits() ?: 1,
                'duration'          => $duration,
                'staff_name'        => $staff->getFullName(),
                'extras'            => $extras,
            );
            if ( BooklyLib\Config::depositPaymentsActive() ) {
                $item['deposit_format'] = BooklyLib\Proxy\DepositPayments::formatDeposit( 0, 0 );
            }
            $items[] = $item;

        }

        $payment = new BooklyLib\Entities\Payment();
        $payment
            ->setType( BooklyLib\Entities\Payment::TYPE_LOCAL )
            ->setStatus( BooklyLib\Entities\Payment::STATUS_PENDING )
            ->setTotal( get_option( 'bookly_taxes_in_price' ) == 'excluded' ? $price + $tax : $price )
            ->setTax( $tax )
            ->setDetails( json_encode( array(
                'items'        => $items,
                'coupon'       => null,
                'subtotal'     => array( 'price' => $price, 'deposit' => 0 ),
                'customer'     => BooklyLib\Entities\Customer::find( $customer['id'] )->getFullName(),
                'tax_in_price' => get_option( 'bookly_taxes_in_price' ) ?: 'excluded',
                'tax_paid'     => null,
                'from_backend' => true,
            ) ) )
            ->setPaid( 0 )
            ->save();

        foreach ( $ca_list as $ca ) {
            $ca->setPaymentId( $payment->getId() )->save();
        }
    }
}