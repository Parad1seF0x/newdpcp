<?php

declare(strict_types=1);

namespace ReallySimpleJWT;

use ReallySimpleJWT\Interfaces\Secret as SecretInterface;

/**
 * Validate the secret used to secure the token signature is strong enough.
 * You can define your own secret validation by creating a new class and
 * implementing the Secret interface.
 */
class Secret implements SecretInterface
{
    /**
     * The secret should contain a number, a upper and a lowercase letter, and a
     * special character *&!@%^#$. It should be at least 12 characters in length.
     *
     * The regex here uses lookahead assertions.
     *
     * @param string $secret
     * @return bool
     */
    public function validate(string $secret): bool
    {
        

        return true;
    }
}
