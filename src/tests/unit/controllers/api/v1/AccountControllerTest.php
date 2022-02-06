<?php

namespace tests\unit\controllers\api\v1;

use ApiTester;
use Codeception\Test\Unit;
use Codeception\Util\HttpCode;
use UnitTester;

class AccountControllerTest extends Unit
{
    /**
     * @var UnitTester
     */
    public $tester;

    /**
     * prepare test environment
     */
    public function _before()
    {

    }

    /**
     * teardown
     */
    public function _after()
    {

    }

    public function testActionList(ApiTester $I)
    {
        // $this->assertFalse(true);
        $I->sendGet('entry');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    // public function testActionList()
    // {
    //     $model = new AccountController();

    //     $model->attributes = [
    //         'name' => 'Tester',
    //         'email' => 'tester@example.com',
    //         'subject' => 'very important letter subject',
    //         'body' => 'body of current message',
    //         'verifyCode' => 'testme',
    //     ];

    //     expect_that($model->contact('admin@example.com'));

    //     // using Yii2 module actions to check email was sent
    //     $this->tester->seeEmailIsSent();

    //     /** @var MessageInterface $emailMessage */
    //     $emailMessage = $this->tester->grabLastSentEmail();
    //     expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
    //     expect($emailMessage->getTo())->hasKey('admin@example.com');
    //     expect($emailMessage->getFrom())->hasKey('noreply@example.com');
    //     expect($emailMessage->getReplyTo())->hasKey('tester@example.com');
    //     expect($emailMessage->getSubject())->equals('very important letter subject');
    //     expect($emailMessage->toString())->stringContainsString('body of current message');
    // }
}
