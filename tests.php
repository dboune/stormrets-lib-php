<?php

require_once 'agentstorm-lib.php';

$options = getopt("h:k:");
if (!array_key_exists("h", $options) && !array_key_exists("h", $options)) {
    print "\nUsage: \n";
    print " tests.php -h<host> -k<API KEY>\n\n";
    die();
}

// Test Contacts
//
$obj = new AgentStormContactsEndpoint($options['h'], $options['k']);
$result = $obj->getAll();
echo 'Contact Count: ' . $result->Count . "/" . $result->TotalCount . "\n";

// Test Companies
//
$obj = new AgentStormCompaniesEndpoint($options['h'], $options['k']);
$result = $obj->getAll();
echo 'Company Count: ' . $result->Count . "/" . $result->TotalCount . "\n";

// Test Properties
//
$obj = new AgentStormPropertiesEndpoint($options['h'], $options['k']);
$result = $obj->getAll();
echo 'Properties Count: ' . $result->Count . "/" . $result->TotalCount . "\n";

// Cities
$result = $obj->getCities();
echo 'City Count: ' . $result->Count . "/" . $result->TotalCount . "\n";

// Tags
$result = $obj->getTags();
echo 'Tag Count: ' . $result->Count . "/" . $result->TotalCount . "\n";

// By Tag
$result = $obj->getByTag('MRMLS');
echo 'Property[MRMLS] Count: ' . $result->Count . "/" . $result->TotalCount . "\n";
