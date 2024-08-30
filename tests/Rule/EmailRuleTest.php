<?php

/**
 * @declare
 */
declare( strict_types = 1 );

/**
 * @namespace
 */
namespace Omega\Validation\Tests\Rule;

/**
 * @use
 */
use Omega\Validation\Exception\ValidationException;

class EmailRuleTest extends AbstractRuleTest
{
    /**
     * Test invalid email values fails.
     * 
     * This test simulates validating data with an invalid email address (`foo`). 
     * It asserts that a ValidationException is thrown with the expected error message 
     * (`email should be an email.`).
     * 
     * @return void
     */
    public function testInvalidEmailValuesFails() : void
    {
        $expected = ['email' => [ 
            'email should be an email.' 
        ]];
    
        try {
            $this->validation->validate([
                'email' => 'foo'
            ], [
                'email' => ['email']
            ]);
            $this->fail('Expected ValidationException not thrown.');
        } catch (ValidationException $exception) {
            $this->assertEquals($expected, $exception->getErrors());
        }
    }

    /**
     * Test valid email values passes.
     * 
     * This test simulates validating data with a valid email address (`foo@bar.com`). 
     * It asserts that the validation is successful and the email is returned unchanged.
     * 
     * @return void
     */
    public function testValidEmailValuesPasses() : void
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
}