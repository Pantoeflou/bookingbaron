<?php
namespace BooklyRecurringAppointments\Lib\Notifications;

use Bookly\Lib as BooklyLib;
use Bookly\Lib\Notifications\Codes;

/**
 * Class ICS
 * @package BooklyRecurringAppointments\Lib\Notifications
 */
class ICS extends BooklyLib\Notifications\ICS
{
    protected $data;

    /**
     * Constructor.
     *
     * @param Codes $codes
     */
    public function __construct( Codes $codes )
    {
        $this->data =
            "BEGIN:VCALENDAR\n"
            . "VERSION:2.0\n"
            . "PRODID:-//hacksw/handcal//NONSGML v1.0//EN\n"
            . "CALSCALE:GREGORIAN\n";

        foreach ( $codes->schedule as $appointment ) {
            $this->data .= sprintf(
                "BEGIN:VEVENT\n"
                . "DTSTART:%s\n"
                . "DTEND:%s\n"
                . "SUMMARY:%s\n"
                . "DESCRIPTION:%s\n"
                . "END:VEVENT\n",
                $this->_formatDateTime( $appointment['start'] ),
                $this->_formatDateTime( $appointment['end'] ),
                $this->_escape( $codes->service_name ),
                $this->_escape( sprintf( "%s\n%s", $codes->service_name, $codes->staff_name ) )
            );
        }

        $this->data .= 'END:VCALENDAR';
    }
}