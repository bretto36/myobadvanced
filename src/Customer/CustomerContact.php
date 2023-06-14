<?php

namespace MyobAdvanced\Customer;

use MyobAdvanced\AbstractObject;
use MyobAdvanced\Contact;

/**
 * @method string getContactID()
 *
 * @method Contact getContact()
 * @method self setContact(Contact $value)
 */
class CustomerContact extends AbstractObject
{
    public $expands = [
        'Contact' => Contact::class,
    ];
}