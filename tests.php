<?php

require_once 'agentstorm-lib.php';

$options = getopt("h:k:");
if (!array_key_exists("h", $options) && !array_key_exists("h", $options)) {
    print "\nUsage: \n";
    print " tests.php -h<host> -k<API KEY>\n\n";
    die();
}

$result = new AgentStormContactsEndpoint($options['h'], $options['k']);
echo 'Contact Count: ' . $result->getAll()->Count . "/" . $result->getAll()->TotalCount . "\n";

$result = new AgentStormCompaniesEndpoint($options['h'], $options['k']);
echo 'Company Count: ' . $result->getAll()->Count . "/" . $result->getAll()->TotalCount . "\n";

$result = new AgentStormPropertiesEndpoint($options['h'], $options['k']);
echo 'Properties Count: ' . $result->getAll()->Count . "/" . $result->getAll()->TotalCount . "\n";

$result = new AgentStormCitiesEndpoint($options['h'], $options['k']);
echo 'City Count: ' . $result->getAll()->Count . "/" . $result->getAll()->TotalCount . "\n";