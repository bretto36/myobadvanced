<?php

namespace MyobAdvanced\Tests;

use Illuminate\Support\Facades\Http;
use MyobAdvanced\Account;

class AccountTest extends Base
{
    public function testAccountList()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('accounts'));

        $accounts = $this->myobAdvanced->search(Account::class, 5)->send();

        $this->assertCount(5, $accounts);

        /** @var Account $account */
        $account = $accounts->shift();

        $this->assertEquals('b49ee0b4-b440-433e-ae89-465daba80d18', $account->getId());
        $this->assertEquals('1165', $account->getAccountID());
        $this->assertEquals('100000', $account->getAccountCD());
        $this->assertEquals('CASHASSET', $account->getAccountClass());
        $this->assertEquals('', $account->getAccountGroup());
        $this->assertTrue($account->getActive());
        $this->assertTrue($account->getCashAccount());
        $this->assertEquals(2, $account->getChartOfAccountsOrder());
        $this->assertEquals('', $account->getConsolidationAccount());
        $this->assertEquals('2014-10-23 01:01:51', $account->getCreatedDateTime()->format('Y-m-d H:i:s'));
        $this->assertEquals('AUD', $account->getCurrencyID());
        $this->assertEquals('Petty Cash AUD', $account->getDescription());
        $this->assertEquals('2014-10-23 01:24:34', $account->getLastModifiedDateTime()->format('Y-m-d H:i:s'));
        $this->assertEquals('Detail', $account->getPostOption());
        $this->assertFalse($account->getRequireUnits());
        $this->assertEquals('', $account->getRevaluationRateType());
        $this->assertFalse($account->getSecured());
        $this->assertEquals('', $account->getTaxCategory());
        $this->assertEquals('Asset', $account->getType());
        $this->assertFalse($account->getUseDefaultSubaccount());
    }

    public function testAccountGet()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('account'));

        /** @var Account $account */
        $account = $this->myobAdvanced->get(Account::class, 'b49ee0b4-b440-433e-ae89-465daba80d18')->send();

        $this->assertEquals('b49ee0b4-b440-433e-ae89-465daba80d18', $account->getId());
        $this->assertEquals('1165', $account->getAccountID());
        $this->assertEquals('100000', $account->getAccountCD());
        $this->assertEquals('CASHASSET', $account->getAccountClass());
        $this->assertEquals('', $account->getAccountGroup());
        $this->assertTrue($account->getActive());
        $this->assertTrue($account->getCashAccount());
        $this->assertEquals(2, $account->getChartOfAccountsOrder());
        $this->assertEquals('', $account->getConsolidationAccount());
        $this->assertEquals('2014-10-23 01:01:51', $account->getCreatedDateTime()->format('Y-m-d H:i:s'));
        $this->assertEquals('AUD', $account->getCurrencyID());
        $this->assertEquals('Petty Cash AUD', $account->getDescription());
        $this->assertEquals('2014-10-23 01:24:34', $account->getLastModifiedDateTime()->format('Y-m-d H:i:s'));
        $this->assertEquals('Detail', $account->getPostOption());
        $this->assertFalse($account->getRequireUnits());
        $this->assertEquals('', $account->getRevaluationRateType());
        $this->assertFalse($account->getSecured());
        $this->assertEquals('', $account->getTaxCategory());
        $this->assertEquals('Asset', $account->getType());
        $this->assertFalse($account->getUseDefaultSubaccount());


        //$this->assertCount(5, $accounts);
    }
}
