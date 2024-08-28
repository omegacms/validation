<?php
/**
 * Part of Omega CMS -  Validation Test Package
 *
 * @link       https://omegacms.github.io
 * @author     Adriano Giovannini <omegacms@outlook.com>
 * @copyright  Copyright (c) 2022 Adriano Giovannini. (https://omegacms.github.io)
 * @license    https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 */

/**
 * @declare
 */
declare( strict_types = 1 );

/**
 * @namespace
 */
namespace Omega\Validation\Tests;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

/**
 * @use
 */
use Omega\Validation\Validation;
use Omega\Validation\Rule\EmailRule;
use Omega\Validation\Rule\IntegerRule;
use Omega\Validation\Rule\MinRule;
use Omega\Validation\Rule\RequiredRule;
use Omega\Testing\TestCase;
use Omega\Validation\Exception\ValidationException;

/**
 * Validation test class.
 * 
 * The `ValidationTest` class extends the `TestCase` class provided by the Omega CMS testing 
 * framework. It contains several test methods to verify the functionality of the Omega CMS 
 * validation library.
 *
 * @category    Omega
 * @package     Omega\Validation
 * @subpackage  Omega\Validation\Tests
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2022 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class ValidationTest extends TestCase
{
    /**
     * Validation instance.
     * 
     * @var Validation $validation Holds the current Validation instance.
     */
    protected Validation $validation;

    /**
     * Setup.
     * 
     * This method is inherited from the parent class and is presumably used 
     * for common test setup procedures. In this specific case, it creates a 
     * new `Validation` instance, adds various validation rules to it (`EmailRule`, 
     * `IntegerRule`, `MinRule`, and `RequiredRule`), and assigns it to the 
     * `$validation` property.
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->validation = new Validation();

        $this->validation->addRule('email',    new EmailRule()    );
        $this->validation->addRule('integer',  new IntegerRule()  );
        $this->validation->addRule('min',      new MinRule()      );
        $this->validation->addRule('required', new RequiredRule() );
    }

    /**
     * Test invalid email values fails.
     * 
     * This test simulates validating data with an invalid email address (`foo`). 
     * It asserts that a ValidationException is thrown with the expected error message 
     * (`email should be an email.`).
     * 
     * @return void
     */
    public function testInvalidEmailValuesFails()
    {
        $expected = ['email' => [ 
            'email should be an email.' 
            ] 
        ];

        [ $exception ] = $this->assertExceptionThrown(
            fn() => $this->validation->validate( [ 
                'email' => 'foo' 
            ], 
            [ 
                'email' => [ 'email' 
                ] 
            ] ), ValidationException::class );

        $this->assertEquals( $expected, $exception->getErrors() );
    }

    /**
     * Test valid email values passes.
     * 
     * This test simulates validating data with a valid email address (`foo@bar.com`). 
     * It asserts that the validation is successful and the email is returned unchanged.
     * 
     * @return void
     */
    public function testValidEmailValuesPasses()
    {
        $data = $this->validation->validate( [
            'email' => 'foo@bar.com'
        ], 
        [
            'email' => [
                'email'
            ]
        ] );

        $this->assertEquals( $data[ 'email' ], 'foo@bar.com' );
    }

    /**
     * Test invalid required value fails.
     * 
     * This test simulates validating data with a missing required field (`email`). 
     * It asserts that a ValidationException is thrown with the expected error 
     * message (`email is required`).
     * 
     * @return void
     */
    public function testInvalidRequiredValuesFails()
    {
        $expected = [
            'email' => [
                'email is required'
            ]
        ];

        [ $exception ] = $this->assertExceptionThrown(
            fn() => $this->validation->validate( [
                'email' => ''
            ], 
            [
                'email' => [
                    'required'
                ]
            ] ), ValidationException::class );

        $this->assertEquals( $expected, $exception->getErrors() );
    }

    /**
     * Test valid required value passes.
     * 
     * This test simulates validating data with a present value for a required 
     * field (`email`). It asserts that the validation is successful and the 
     * email is returned unchanged.
     * 
     * @return void
     */
    public function testValidRequiredValuesPasses()
    {
        $data = $this->validation->validate( [
            'email' => 'foo@bar.com'
        ], 
        [
            'email' => [
                'required'
            ]
        ] );

        $this->assertEquals( $data[ 'email' ], 'foo@bar.com' );
    }

    /**
     * Test invalid min values fails.
     * 
     * This test simulates validating data with an email address that doesn't 
     * meet the minimum length requirement (less than 4 characters). It asserts 
     * that a ValidationException is thrown with the expected error message 
     * (`email should be at least 4 characters.`).
     * 
     * @return void
     */
    public function testInvalidMinValuesFails()
    {
        $expected = [
            'email' => [
                'email should be at least 4 characters.'
            ]
        ];

        [ $exception ] = $this->assertExceptionThrown(
            fn() => $this->validation->validate( [ 
                'email' => 'foo'
            ], 
            [
                'email' => [
                    'min:4'
                ]
            ] ), ValidationException::class );

        $this->assertEquals( $expected, $exception->getErrors() );
    }

    /**
     * Test valid min values passes.
     * 
     * This test simulates validating data with an email address that meets the
     * minimum length requirement (4 characters or more). It asserts that the 
     * validation is successful and the email is returned unchanged.
     * 
     * @return void
     */
    public function testValidMinValuesPasses()
    {
        $data = $this->validation->validate( [ 
            'email' => 'foo@bar.com'
        ], 
        [
            'email' => [
                'min:4'
            ]
        ] );

        $this->assertEquals( $data[ 'email' ], 'foo@bar.com' );
    }

    /**
     * Test invalid integer value fails.
     * 
     * This test simulates validating data with a non-integer value for the 
     * `age` field. It asserts that a ValidationException is thrown with the 
     * expected error message (`age should be an integer.`).
     */
    public function testInvalidIntegerValueFails()
    {
        $expected = [
            'age' => [
                'age should be an integer.'
                ]
            ];
    
        [ $exception ] = $this->assertExceptionThrown(
            fn() => $this->validation->validate( [
                'age' => 'not_an_integer'
            ], 
            [
                'age' => [
                    'integer'
                ]
            ] ), ValidationException::class );
    
        $this->assertEquals( $expected, $exception->getErrors() );
    }

    /**
     * Test valid integer values passes.
     * 
     * This test simulates validating data with a valid integer value for 
     * the `age` field. It asserts that the validation is successful and 
     * the age value is returned unchanged.
     * 
     * @return void
     */
    public function testValidIntegerValuePasses()
    {
        $data = $this->validation->validate( [ 
            'age' => 25
        ], 
        [
            'age' => [
                'integer'
            ]
        ] );

        $this->assertEquals( $data[ 'age' ], 25 );
    }
}