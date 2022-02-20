<?php

namespace MyobAdvanced;

use Carbon\Carbon;

/**
 * @method bool getActive()
 * @method self setActive(bool $value)
 * @method bool getOverrideAccountAddress()
 * @method self setOverrideAccountAddress(bool $value)
 * @method bool getAddressValidated()
 * @method self setAddressValidated(bool $value)
 * @method string getAttention()
 * @method self setAttention(string $value)
 * @method string getBusinessAccount()
 * @method self setBusinessAccount(string $value)
 * @method string getCompanyName()
 * @method self setCompanyName(string $value)
 * @method string getContactClass()
 * @method self setContactClass(string $value)
 * @method int getContactID()
 * @method self setContactID(int $value)
 * @method string getContactMethod()
 * @method self setContactMethod(string $value)
 * @method string getConvertedBy()
 * @method self setConvertedBy(string $value)
 * @method Carbon getDateOfBirth()
 * @method self setDateOfBirth(Carbon $value)
 * @method string getDisplayName()
 * @method self setDisplayName(string $value)
 * @method bool getDoNotCall()
 * @method self setDoNotCall(bool $value)
 * @method bool getDoNotEmail()
 * @method self setDoNotEmail(bool $value)
 * @method bool getDoNotFax()
 * @method self setDoNotFax(bool $value)
 * @method bool getDoNotMail()
 * @method self setDoNotMail(bool $value)
 * @method string getDuplicate()
 * @method self setDuplicate(string $value)
 * @method bool getDuplicateFound()
 * @method self setDuplicateFound(bool $value)
 * @method string getEmail()
 * @method self setEmail(string $value)
 * @method string getFax()
 * @method self setFax(string $value)
 * @method string getFaxType()
 * @method self setFaxType(string $value)
 * @method string getFirstName()
 * @method self setFirstName(string $value)
 * @method string getGender()
 * @method self setGender(string $value)
 * @method string getImage()
 * @method self setImage(string $value)
 * @method string getJobTitle()
 * @method self setJobTitle(string $value)
 * @method string getLanguageOrLocale()
 * @method self setLanguageOrLocale(string $value)
 * @method Carbon getLastIncomingActivity()
 * @method self setLastIncomingActivity(Carbon $value)
 * @method Carbon getLastModifiedDateTime()
 * @method self setLastModifiedDateTime(Carbon $value)
 * @method string getLastName()
 * @method self setLastName(string $value)
 * @method Carbon getLastOutgoingActivity()
 * @method self setLastOutgoingActivity(Carbon $value)
 * @method string getMaritalStatus()
 * @method self setMaritalStatus(string $value)
 * @method string getMiddleName()
 * @method self setMiddleName(string $value)
 * @method bool getNoMarketing()
 * @method self setNoMarketing(bool $value)
 * @method bool getNoMassMail()
 * @method self setNoMassMail(bool $value)
 * @method string getOwner()
 * @method self setOwner(string $value)
 * @method string getOwnerEmployeeName()
 * @method self setOwnerEmployeeName(string $value)
 * @method string getParentAccount()
 * @method self setParentAccount(string $value)
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
 * @method Carbon getQualificationDate()
 * @method self setQualificationDate(Carbon $value)
 * @method string getReason()
 * @method self setReason(string $value)
 * @method string getSource()
 * @method self setSource(string $value)
 * @method string getSourceCampaign()
 * @method self setSourceCampaign(string $value)
 * @method string getSpouseOrPartnerName()
 * @method self setSpouseOrPartnerName(string $value)
 * @method string getStatus()
 * @method self setStatus(string $value)
 * @method bool getSynchronize()
 * @method self setSynchronize(bool $value)
 * @method string getTitle()
 * @method self setTitle(string $value)
 * @method string getType()
 * @method self setType(string $value)
 * @method string getWebSite()
 * @method self setWebSite(string $value)
 * @method string getWorkgroup()
 * @method self setWorkgroup(string $value)
 * @method string getWorkgroupDescription()
 * @method self setWorkgroupDescription(string $value)
 * @method string getNoteID()
 * @method self setNoteID(string $value)
 *
 * @method Address getAddress()
 * @method self setAddress(Address $value)
 * @method Attribute[] getAttributes()
 * @method self setAttributes(array $value)
 */
class Contact extends AbstractObject
{
    public $expands = [
        'Address'    => Address::class,
        //'Activities' => Activity::class,
        'Attributes' => Attribute::class,
        //'Campaigns' => Campaign::class,
        //'Cases' => Case::class,
        //'Notifications' => Notification::class,
        //'Opportunities' => Opportunity::class,
        //'UserInfo' => UserInfo::class,
    ];

    protected $dates = [
        'DateOfBirth',
        'LastIncomingActivity',
        'LastModifiedDateTime',
        'LastOutgoingActivity',
        'QualificationDate',
    ];
}