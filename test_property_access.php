<?php
/**
 * Test PHP's default property access to get a baseline for our accessor.
 */
 
class Person
{
    private $idnumber;
    protected $address;
}
 
function test_class_properties() {
    $person = new Person();
 
    // Setting a property returns the new value
    assert('$person->name = \'John\' == \'John\';');
 
    // Retrieving a property returns the value
    assert('$person->name == \'John\';');
 
    // Retrieving a private or protected property issues a fatal error
    // $person->idnumber; //=> PHP Fatal error:  Cannot access private property Person::$idnumber in ...
    // $person->address; //=> PHP Fatal error:  Cannot access protected property Person::$address in ...
 
    // Retrieving an unset property returns null (and issues a warning)
    assert('$person->age == null;');
}

