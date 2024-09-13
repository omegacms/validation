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

class MinRuleTest extends BaseRuleTest
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
    #[Test]
    public function invalidValuesFails(): void
    {
        $expected = ['email' => ['email should be at least 4 characters.']];

        [$exception, ] = $this->assertExceptionThrown(function() {
            $this->validation->validate([
                'email' => 'foo'
            ], [
                'email' => ['min:4']
            ]);
        }, ValidationException::class);

        $this->assertEquals($expected, $exception->getErrors());
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
    #[Test]
    public function validValuesPasses() : void
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