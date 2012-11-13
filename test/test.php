<?php

/**
 * Script to generate PHPUnit test code for Categorizr based on JSON input data.
 *
 * Sample usage:  php test.php < test_user_agents.json > tests.php && phpunit tests.php && rm tests.php
 */

// This could do with some error handling but I'm not sure how to do that in PHP any more :-(
$test_data = file_get_contents('php://stdin', 'r');
$user_agents = json_decode($test_data);

$_SERVER = array('HTTP_USER_AGENT' => ''); // Prevents categorizr.php choking.

require('categorizr.php'); // Edit this to the path of categorizr.php you wish to test.

// This is now the generation of the test code.

print("<?php\n\n");
print("\$_SERVER = array('HTTP_USER_AGENT' => ''); // Prevents categorizr.php choking.\n");
print("require('categorizr.php');\n");

print("class CategorizrTest extends PHPUnit_Framework_TestCase {\n");

print("\tprotected function setUp() {\n");
print("\t\t// Mock the super globals.\n");
print("\t\t\$_SESSION = array();");
print("\t\t\$_SERVER = array('HTTP_USER_AGENT' => '');");
print("\t}\n");

$i = 0;
foreach($user_agents as $test) {
  // Build the tests.
  $ua = $test[0];
  print("\tpublic function test_$i() {\n");
  print("\t\t\$_SERVER['HTTP_USER_AGENT'] = '$ua';\n");
  print("\t\t\$this->assertEquals(array('$ua', '$test[1]'), array('$ua', categorizr()));\n");
  print("\t}\n");
  $i += 1;

  if ($test[2] === "i") {
    // The UA should be tested in a case insensitive manner.
    $ua = strtoupper($test[0]);
    print("\tpublic function test_$i() {\n");
    print("\t\t\$_SERVER['HTTP_USER_AGENT'] = '$ua';\n");
    print("\t\t\$this->assertEquals(array('$ua', '$test[1]'), array('$ua', categorizr()));\n");
    print("\t}\n");
    $i += 1;

    $ua = strtolower($test[0]);
    print("\tpublic function test_$i() {\n");
    print("\t\t\$_SERVER['HTTP_USER_AGENT'] = '$test[0]';\n");
    print("\t\t\$this->assertEquals(array('$ua', '$test[1]'), array('$ua', categorizr()));\n");
    print("\t}\n");
    $i += 1;
  }
}

print("}\n");
