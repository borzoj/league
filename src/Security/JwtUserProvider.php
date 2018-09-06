<?php
/**
 * Created by PhpStorm.
 * User: uob
 * Date: 06/09/18
 * Time: 22:32
 */

namespace App\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;


class JwtUserProvider implements UserProviderInterface
{
    public function getUsernameForApiKey($apiKey)
    {
        $username = "john";
        return $username;
    }

    public function loadUserByUsername($username)
    {
        return new User($username, null, ['ROLE_USER']);
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}