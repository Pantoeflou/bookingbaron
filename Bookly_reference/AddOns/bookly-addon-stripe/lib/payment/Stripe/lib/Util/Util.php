<?php

namespace BooklyStripe\Lib\Payment\Lib\Stripe\Util;

use BooklyStripe\Lib\Payment\Lib\Stripe\StripeObject;

abstract class Util
{
    private static $isMbstringAvailable = null;
    private static $isHashEqualsAvailable = null;

    /**
     * Whether the provided array (or other) is a list rather than a dictionary.
     *
     * @param array|mixed $array
     * @return boolean True if the given object is a list.
     */
    public static function isList($array)
    {
        if (!is_array($array)) {
            return false;
        }

      // TODO: generally incorrect, but it's correct given Stripe's response
        foreach (array_keys($array) as $k) {
            if (!is_numeric($k)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Recursively converts the PHP Stripe object to an array.
     *
     * @param array $values The PHP Stripe object to convert.
     * @return array
     */
    public static function convertStripeObjectToArray($values)
    {
        $results = array();
        foreach ($values as $k => $v) {
            // FIXME: this is an encapsulation violation
            if ($k[0] == '_') {
                continue;
            }
            if ($v instanceof StripeObject) {
                $results[$k] = $v->__toArray(true);
            } elseif (is_array($v)) {
                $results[$k] = self::convertStripeObjectToArray($v);
            } else {
                $results[$k] = $v;
            }
        }
        return $results;
    }

    /**
     * Converts a response from the Stripe API to the corresponding PHP object.
     *
     * @param array $resp The response from the Stripe API.
     * @param array $opts
     * @return StripeObject|array
     */
    public static function convertToStripeObject($resp, $opts)
    {
        $types = array(
            // data structures
            'list' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Collection',

            // business objects
            'account' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Account',
            'alipay_account' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\AlipayAccount',
            'apple_pay_domain' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\ApplePayDomain',
            'application_fee' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\ApplicationFee',
            'balance' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Balance',
            'balance_transaction' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\BalanceTransaction',
            'bank_account' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\BankAccount',
            'bitcoin_receiver' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\BitcoinReceiver',
            'bitcoin_transaction' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\BitcoinTransaction',
            'card' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Card',
            'charge' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Charge',
            'country_spec' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\CountrySpec',
            'coupon' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Coupon',
            'customer' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Customer',
            'dispute' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Dispute',
            'ephemeral_key' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\EphemeralKey',
            'event' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Event',
            'exchange_rate' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\ExchangeRate',
            'fee_refund' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\ApplicationFeeRefund',
            'file_upload' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\FileUpload',
            'invoice' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Invoice',
            'invoiceitem' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\InvoiceItem',
            'login_link' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\LoginLink',
            'order' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Order',
            'order_return' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\OrderReturn',
            'payout' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Payout',
            'plan' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Plan',
            'product' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Product',
            'recipient' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Recipient',
            'recipient_transfer' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\RecipientTransfer',
            'refund' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Refund',
            'sku' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\SKU',
            'source' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Source',
            'source_transaction' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\SourceTransaction',
            'subscription' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Subscription',
            'subscription_item' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\SubscriptionItem',
            'three_d_secure' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\ThreeDSecure',
            'token' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Token',
            'transfer' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\Transfer',
            'transfer_reversal' => 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\TransferReversal',
        );
        if (self::isList($resp)) {
            $mapped = array();
            foreach ($resp as $i) {
                array_push($mapped, self::convertToStripeObject($i, $opts));
            }
            return $mapped;
        } elseif (is_array($resp)) {
            if (isset($resp['object']) && is_string($resp['object']) && isset($types[$resp['object']])) {
                $class = $types[$resp['object']];
            } else {
                $class = 'BooklyStripe\\Lib\\Payment\\Lib\\Stripe\\StripeObject';
            }
            return $class::constructFrom($resp, $opts);
        } else {
            return $resp;
        }
    }

    /**
     * @param string|mixed $value A string to UTF8-encode.
     *
     * @return string|mixed The UTF8-encoded string, or the object passed in if
     *    it wasn't a string.
     */
    public static function utf8($value)
    {
        if (self::$isMbstringAvailable === null) {
            self::$isMbstringAvailable = function_exists('mb_detect_encoding');

            if (!self::$isMbstringAvailable) {
                trigger_error("It looks like the mbstring extension is not enabled. " .
                    "UTF-8 strings will not properly be encoded. Ask your system " .
                    "administrator to enable the mbstring extension, or write to " .
                    "support@stripe.com if you have any questions.", E_USER_WARNING);
            }
        }

        if (is_string($value) && self::$isMbstringAvailable && mb_detect_encoding($value, "UTF-8", true) != "UTF-8") {
            return utf8_encode($value);
        } else {
            return $value;
        }
    }

    /**
     * Compares two strings for equality. The time taken is independent of the
     * number of characters that match.
     *
     * @param string $a one of the strings to compare.
     * @param string $b the other string to compare.
     * @return bool true if the strings are equal, false otherwise.
     */
    public static function secureCompare($a, $b)
    {
        if (self::$isHashEqualsAvailable === null) {
            self::$isHashEqualsAvailable = function_exists('hash_equals');
        }

        if (self::$isHashEqualsAvailable) {
            return hash_equals($a, $b);
        } else {
            if (strlen($a) != strlen($b)) {
                return false;
            }

            $result = 0;
            for ($i = 0; $i < strlen($a); $i++) {
                $result |= ord($a[$i]) ^ ord($b[$i]);
            }
            return ($result == 0);
        }
    }

    /**
     * @param array $arr A map of param keys to values.
     * @param string|null $prefix
     *
     * @return string A querystring, essentially.
     */
    public static function urlEncode($arr, $prefix = null)
    {
        if (!is_array($arr)) {
            return $arr;
        }

        $r = array();
        foreach ($arr as $k => $v) {
            if (is_null($v)) {
                continue;
            }

            if ($prefix) {
                if ($k !== null && (!is_int($k) || is_array($v))) {
                    $k = $prefix."[".$k."]";
                } else {
                    $k = $prefix."[]";
                }
            }

            if (is_array($v)) {
                $enc = self::urlEncode($v, $k);
                if ($enc) {
                    $r[] = $enc;
                }
            } else {
                $r[] = urlencode($k)."=".urlencode($v);
            }
        }

        return implode("&", $r);
    }
}
