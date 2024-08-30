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

class IntegerRuleTest extends AbstractRuleTest
{
     /**
     * Test invalid integer value fails.
     * 
     * This test simulates validating data with a non-integer value for the 
     * `age` field. It asserts that a ValidationException is thrown with the 
     * expected error message (`age should be an integer.`).
     */
    public function testInvalidIntegerValueFails() : void
    {
        $expected = [
            'age' => [
                'age should be an integer.'
            ]
        ];

        try {
            $this->validation->validate([
                'age' => 'not_an_integer'
            ], [
                'age' => ['integer']
            ]);
            $this->fail('Expected ValidationException not thrown.');
        } catch (ValidationException $exception) {
            $this->assertEquals($expected, $exception->getErrors());
        }
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
    public function testValidIntegerValuePasses() : void
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