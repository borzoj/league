<?php
namespace App\Security;

use App\Security\ApiKeyUserProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;


class JwtAuthenticator implements SimplePreAuthenticatorInterface
{
    public function createToken(Request $request, $providerKey)
    {
        $header = $request->headers->get('Authorization');
        $payload = (new JwtDecoder())->decodeAuthorization($header);
        return new JwtToken($payload, $providerKey);
    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof JwtToken && $token->getProviderKey() === $providerKey;
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        if (!$userProvider instanceof JwtUserProvider) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The user provider must be an instance of JwtUserProvider (%s was given).',
                    get_class($userProvider)
                )
            );
        }

        $credentials  = $token->getCredentials();
        if (empty(empty($credentials) || empty($credentialsp['user']))) {
            throw new CustomUserMessageAuthenticationException("User not found");
        }

        $roles = array_map(
            function($role) {
                return "ROLE_".strtoupper($role);
            },
            $credentials['roles']
        );

        return new JwtToken($credentials, $providerKey, $roles);
    }
}
