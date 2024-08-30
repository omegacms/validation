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

class MinRuleTest extends AbstractRuleTest
{
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
    public function testInvalidMinValuesFails() : void
    {
        $expected = ['email' => ['email should be at least 4 characters.']];

        try {
            $this->validation->validate([
                'email' => 'foo'
            ], [
                'email' => ['min:4']
            ]);
            $this->fail('Expected ValidationException not thrown.');
        } catch (ValidationException $exception) {
            $this->assertEquals($expected, $exception->getErrors());
        }
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
    public function testValidMinValuesPasses() : void
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
}