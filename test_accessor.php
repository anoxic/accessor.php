<?php
/**
 * Tests for our Accessor
 */

class Person extends Accessor
{
    protected $_accessable = array('name','age','sex');
    protected $_writable = array('social_security_number');
}

$person = new Person();

// Setting a property returns the new value
assert('$person->name = \'John\' == \'John\';');

// Attempting to set a property not in _readable or _accessable throws an OutOfRangeException (unlike standard __get, which throws fatal error)
try {
    $person->thing_not_settable = "sentinel";
} catch (OutOfRangeException $e) {
    $message = $e->getMessage();
    assert('$message == \'Cannot set property Person::$thing_not_settable\';');
}

// Retrieving a property returns the value
assert('$person->name == \'John\';');

// Attempting to retrieve a property not in _writable or _accessable throws an OutOfRangeException (unlike standard __get, which throws fatal error)
try {
    $person->thing_not_gettable;
} catch (OutOfRangeException $e) {
    $message = $e->getMessage();
    assert('$message == \'Cannot get property Person::$thing_not_gettable\';');
}

// Retrieving an unset property returns null (unlike standard __get, does not issue a warning)
assert('$person->age == null;');

// Default constructor takes an array
$person2 = new Person(array('name'=>'Leia','age'=>23));
assert('$person2->name == \'Leia\'; $person2-age == 23;');

// The method Person::all() fetches all readable variables
$person2->social_security_number = '123-12-1234';
assert('$person2->all() == array(\'name\'=>\'Leia\',\'age\'=>23);');

