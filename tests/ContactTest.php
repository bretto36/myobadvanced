<?php

namespace MyobAdvanced\Tests;

use Illuminate\Support\Facades\Http;
use MyobAdvanced\Contact;

class ContactTest extends Base
{
    public function testContactList()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('contacts'));

        $contacts = $this->myobAdvanced->search(Contact::class, 10)->send();

        $this->assertCount(10, $contacts);

        /** @var Contact $contact */
        $contact = $contacts->shift();

        $this->assertEquals('8aa2b525-0f96-e411-b335-e006e6dac1d7', $contact->getId());
        $this->assertEquals('3909', $contact->getContactID());
        $this->assertEquals(true, $contact->getActive());
        $this->assertEquals('2014-12-25 02:16:29', $contact->getLastModifiedDateTime()->format('Y-m-d H:i:s'));
        $this->assertEquals('Contact', $contact->getType());
    }

    public function testContactGet()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('contact'));

        /** @var Contact $contact */
        $contact = $this->myobAdvanced->get(Contact::class, '8aa2b525-0f96-e411-b335-e006e6dac1d7')->send();

        $this->assertEquals('8aa2b525-0f96-e411-b335-e006e6dac1d7', $contact->getId());
        $this->assertEquals('3909', $contact->getContactID());
        $this->assertEquals(true, $contact->getActive());
        $this->assertEquals('2014-12-25 02:16:29', $contact->getLastModifiedDateTime()->format('Y-m-d H:i:s'));
        $this->assertEquals('Contact', $contact->getType());
    }
}
