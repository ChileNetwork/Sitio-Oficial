<?php
/**
*** ChileNetwork
**/
require('PaypalIPN.php');

use PaypalIPN;

$ipn = new PaypalIPN();

// Use the sandbox endpoint during testing.
$ipn->useSandbox();
$verified = $ipn->verifyIPN();
if ($verified) {
    /*
     * Process IPN
     * A list of variables is available here:
     * https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/
     */
    error_log(date('[Y-m-d H:i e] '). "- INFO - Verified ". PHP_EOL, 3, './paypal_ipn.log');
}

error_log(date('[Y-m-d H:i e] '). "- INFO - Verified False ". PHP_EOL, 3, '/paypal_ipn.log');

// Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
header("HTTP/1.1 200 OK");


