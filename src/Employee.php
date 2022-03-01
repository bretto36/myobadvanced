<?php

namespace MyobAdvanced;

use MyobAdvanced\Employee\ContactInfo;
use MyobAdvanced\Employee\Delegate;
use MyobAdvanced\Employee\EmployeeSettings;
use MyobAdvanced\Employee\EmploymentHistory;

/**
 * @method string getEmployeeID()
 * @method self setEmployeeID(string $value)
 * @method string getEmployeeName()
 * @method self setEmployeeName(string $value)
 * @method string getStatus()
 * @method self setStatus(string $value)
 *
 * @method Attribute[] getAttributes()
 * @method self setAttributes(array $value)
 * @method ContactInfo getContactInfo()
 * @method self setContactInfo(ContactInfo $value)
 * @method Delegate getDelegates()
 * @method self setDelegates(array $value)
 * @method EmployeeSettings getEmployeeSettings()
 * @method self setEmployeeSettings(EmployeeSettings[] $value)
 * @method EmploymentHistory[] getEmploymentHistory()
 * @method self setEmploymentHistory(EmploymentHistory[] $value)
 */
class Employee extends AbstractObject
{
    public $expands = [
        'Attributes'        => [Attribute::class],
        'ContactInfo'       => ContactInfo::class,
        'Delegates'         => [Delegate::class],
        'EmployeeSettings'  => EmployeeSettings::class,
        'EmploymentHistory' => [EmploymentHistory::class],
    ];
}