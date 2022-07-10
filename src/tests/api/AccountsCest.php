<?php

use Codeception\Util\HttpCode;

class AccountsCest
{
    // prepare test data
    public function _before(ApiTester $I)
    {
        // $account = new Account();
        // $account->username = 'test';
        // $account->password = 'pwd';
        // $account->save();
    }

    // teardown
    public function _after(ApiTester $I)
    {
    }

    // index
    public function testActionIndex(ApiTester $I)
    {
        // $I->sendGet('accounts');
        // $I->seeResponseCodeIs(HttpCode::OK);
        // $data = $I->grabResponse();
        // $data = json_decode($data);
        // print_r($data);
    }

    // view
    public function testActionView(ApiTester $I)
    {
        // $I->sendGet('api/v1/accounts/1');
        // $I->seeResponseCodeIs(HttpCode::OK);
        // $data = $I->grabResponse();
        // $data = json_decode($data);
    }
}
