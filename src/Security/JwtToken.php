<?php
/**
 * Created by PhpStorm.
 * User: uob
 * Date: 06/09/18
 * Time: 23:06
 */

namespace App\Security;

use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;


class JwtToken extends PreAuthenticatedToken
{
    public function __construct($credentials, string $providerKey, array $roles = [])
    {
        parent::__construct($credentials['user'], $credentials, $providerKey, $roles);
    }
}