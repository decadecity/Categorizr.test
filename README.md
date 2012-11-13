#Categorizr.test

Test data for [Categorizr](https://github.com/bjankord/Categorizr)

##Test data

The test data is in JSON format for portability and takes the following form:


    [
      ["user agent string", "mobile", "i"],
      ["another user agent string", "mobile", "s"]
    ]


The file should consist of a single array.  Each element of the array should consist of three items:

 1. The user agent string to be tested.
 2. The expected category into which that user agent should be placed - one of:  "mobile", "tv", "tablet" or "desktop"
 3. A flag indicating weather the test should be carried out in a case insensitive manner - "i" indicates case intensive, any other value is case sensitive.

##PHPUnit tests

There is a PHPUnit test generator that will run these tests against the original implementation of Categorizr.  This is a bit cumbersome as, rather than containing the test cases itself, it generates a file containing a set of tests which then has to be run by PHPUnit.

Sample usage:

    php test.php < test_user_agents.json > tests.php && phpunit tests.php && rm tests.php
