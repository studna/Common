<?php

include __DIR__ . "/../../../bootstrap.php";

class PasswordMockObject {

    use Studna\Common\Entities\Attributes\Password;

}

class PasswordAttributeTest extends Tester\TestCase {

    const PWD = 'A';

    public function setPassword() {
        $user = new PasswordMockObject();
        $user->setPassword(self::PWD);
        Tester\Assert::true($user->verifyPassword(self::PWD));
    }

    public function testChangePassword() {

        $user = new PasswordMockObject();
        $user->setPassword(self::PWD);
        Tester\Assert::null($user->changePassword('NEW', self::PWD));
        Tester\Assert::exception(function() use ($user) {
            $user->changePassword(self::PWD, 'WRONG');
        }, 'Studna\Common\Exceptions\InvalidPasswordException');
    }

}

run(new PasswordAttributeTest());

