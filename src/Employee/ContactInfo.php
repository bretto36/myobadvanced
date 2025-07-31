<?php

namespace MyobAdvanced\Employee;

use MyobAdvanced\AbstractObject;
use MyobAdvanced\Address;

/**
 * @method string getDateOfBirth()
 * @method self setDateOfBirth(string $value)
 * @method string getEmail()
 * @method self setEmail(string $value)
 * @method string getFax()
 * @method self setFax(string $value)
 * @method string getFaxType()
 * @method self setFaxType(string $value)
 * @method string getFirstName()
 * @method self setFirstName(string $value)
 * @method string getLastName()
 * @method self setLastName(string $value)
 * @method string getMiddleName()
 * @method self setMiddleName(string $value)
 * @method string getPhone1()
 * @method self setPhone1(string $value)
 * @method string getPhone1Type()
 * @method self setPhone1Type(string $value)
 * @method string getPhone2()
 * @method self setPhone2(string $value)
 * @method string getPhone2Type()
 * @method self setPhone2Type(string $value)
 * @method string getPhone3()
 * @method self setPhone3(string $value)
 * @method string getPhone3Type()
 * @method self setPhone3Type(string $value)
 * @method string getTitle()
 * @method self setTitle(string $value)
 * @method string getWebSite()
 * @method self setWebSite(string $value)
 *
 * @method Address getAddress()
 * @method self setAddress(Address $value)
 */
class ContactInfo extends AbstractObject
{
    public array $expands = [
        'Address' => Address::class,
    ];
}