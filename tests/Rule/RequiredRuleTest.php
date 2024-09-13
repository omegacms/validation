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

class RequiredRuleTest extends BaseRuleTest
{
        /**
     * Test invalid required value fails.
     * 
     * This test simulates validating data with a missing required field (`email`). 
     * It asserts that a ValidationException is thrown with the expected error 
     * message (`email is required`).
     * 
     * @return void
     */
    #[Test]
    public function invalidValuesFails() : void
    {
        $expected = ['email' => ['email is required']];

        try {
            $this->validation->validate([
                'email' => ''
            ], [
                'email' => ['required']
            ]);
            $this->fail('Expected ValidationException not thrown.');
        } catch (ValidationException $exception) {
            $this->assertEquals($expected, $exception->getErrors());
        }
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
    #[Test]
    public function validValuesPasses() : void
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
}