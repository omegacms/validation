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
use PHPUnit\Framework\Attributes\Test;

class EmailRuleTest extends BaseRuleTest
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
    #[Test]
    public function invalidValuesFails() : void
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
    #[Test]
    public function validValuesPasses() : void
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

    #[Test]
    public function emptyValuePasses(): void
    {
        $data = $this->validation->validate( [
            'email' => ''
        ], 
        [
            'email' => [
                'email'
            ]
        ] );

        $this->assertEquals( $data[ 'email' ], '' );
    }

    #[Test]
    public function nonScalarValueFails(): void
    {
        $expected = ['email' => [ 
            'email should be an email.' 
        ]];
        
        try {
            $this->validation->validate([
                'email' => ['not', 'scalar']
            ], [
                'email' => ['email']
            ]);
            $this->fail('Expected ValidationException not thrown.');
        } catch (ValidationException $exception) {
            $this->assertEquals($expected, $exception->getErrors());
        }
    }
}