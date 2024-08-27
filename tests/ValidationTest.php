<?php

namespace Omega\Validation\Tests;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

use Omega\Validation\Validation;
use Omega\Validation\Rule\EmailRule;
use Omega\Validation\Rule\IntegerRule;
use Omega\Validation\Rule\MinRule;
use Omega\Validation\Rule\RequiredRule;
use Omega\Testing\TestCase as BaseTestCase;
use Omega\Validation\Exception\ValidationException;

class ValidationTest extends BaseTestCase
{
    protected Validation $validation;

    public function setUp(): void
    {
        parent::setUp();

        $this->validation = new Validation();
        $this->validation->addRule('email', new EmailRule());
        $this->validation->addRule('integer', new IntegerRule());
        $this->validation->addRule('min', new MinRule());
        $this->validation->addRule('required', new RequiredRule());
    }

    public function testInvalidEmailValuesFail()
    {
        $expected = ['email' => ['email should be an email.']];

        [ $exception ] = $this->assertExceptionThrown(
            fn() => $this->validation->validate(['email' => 'foo'], ['email' => ['email']]),
            ValidationException::class,
        );

        $this->assertEquals($expected, $exception->getErrors());
    }

    public function testValidEmailValuesPass()
    {
        $data = $this->validation->validate(['email' => 'foo@bar.com'], ['email' => ['email']]);
        $this->assertEquals($data['email'], 'foo@bar.com');
    }

    public function testInvalidRequiredValuesFail()
    {
        $expected = ['email' => ['email is required']];

        [ $exception ] = $this->assertExceptionThrown(
            fn() => $this->validation->validate(['email' => ''], ['email' => ['required']]),
            ValidationException::class,
        );

        $this->assertEquals($expected, $exception->getErrors());
    }

    public function testValidRequiredValuesPass()
    {
        $data = $this->validation->validate(['email' => 'foo@bar.com'], ['email' => ['required']]);
        $this->assertEquals($data['email'], 'foo@bar.com');
    }

    public function testInvalidMinValuesFail()
    {
        $expected = ['email' => ['email should be at least 4 characters.']];

        [ $exception ] = $this->assertExceptionThrown(
            fn() => $this->validation->validate(['email' => 'foo'], ['email' => ['min:4']]),
            ValidationException::class,
        );

        $this->assertEquals($expected, $exception->getErrors());
    }

    public function testValidMinValuesPass()
    {
        $data = $this->validation->validate(['email' => 'foo@bar.com'], ['email' => ['min:4']]);
        $this->assertEquals($data['email'], 'foo@bar.com');
    }

    public function testInvalidIntegerValueFails()
    {
        $expected = ['age' => ['age should be an integer.']];
    
        [ $exception ] = $this->assertExceptionThrown(
            fn() => $this->validation->validate(['age' => 'not_an_integer'], ['age' => ['integer']]),
            ValidationException::class,
        );
    
        $this->assertEquals($expected, $exception->getErrors());
    }

    public function testValidIntegerValuePasses()
    {
        $data = $this->validation->validate(['age' => 25], ['age' => ['integer']]);
        $this->assertEquals($data['age'], 25);
    }
    
}
