<?php

use app\models\Account;
use Codeception\Util\HttpCode;

class AccountsCest
{
    // prepare test data
    public function _before(ApiTester $I)
    {
        $I->comment('Api Tester');
        $account = new Account();

        $account->username = 'test';
        $account->password = 'pwd';
        $account->save();

        $a = Account::find('d793b8a1-7a95-3aee-a600-02434d9e3997')
            ->one();
        $a->username = 'user011';
        $a->save();

        // $res = Account::find('d793b8a1-7a95-3aee-a600-02434d9e3997')
        //     ->asArray()->one();
        // print_r($res);exit;
        // die();
    }

    // teardown
    public function _after(ApiTester $I)
    {
    }

    // index
    public function testActionIndex(ApiTester $I)
    {
        $I->sendGet('api/v1/accounts');
        $I->seeResponseCodeIs(HttpCode::OK);
        $data = $I->grabResponse();
        $data = json_decode($data);
        // print_r($data[0]);
    }

    // view
    public function testActionView(ApiTester $I)
    {
        // $I->sendGet('api/v1/accounts/1');
        // $I->seeResponseCodeIs(HttpCode::OK);
        // $data = $I->grabResponse();
        // $data = json_decode($data);
        // print_r($data[0]);
    }
}
