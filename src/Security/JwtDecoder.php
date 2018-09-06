<?php
/**
 * Created by PhpStorm.
 * User: uob
 * Date: 06/09/18
 * Time: 22:57
 */

namespace App\Security;

use Symfony\Component\Security\Core\Exception\BadCredentialsException;


class JwtDecoder
{

    public function decodeAuthorization(?string $header): ?array
    {
        if (empty($header)) {
            throw new BadCredentialsException('Authorization header missing');
        }
        [$bearer, $token] = explode(' ', $header);
        if (empty($token)) {
            throw new BadCredentialsException('JWT token in header missing');
        }
        [$tokenHeader, $encodedPayload, $receivedSignature] = explode('.', $token);
        if (empty($tokenHeader) || empty($encodedPayload) || empty($receivedSignature)) {
            throw new BadCredentialsException('JWT token format invalid');
        }
        $secret = getenv('APP_SECRET');
        $binarySignature = hash_hmac('sha256', $tokenHeader.'.'.$encodedPayload, $secret, true);
        $encodedSignature = rtrim(strtr(base64_encode($binarySignature), '+/', '-_'), '=');
        if ($receivedSignature !== $encodedSignature) {
            throw new BadCredentialsException('JWT token signature invalid');
        }
        $decodedPayload = json_decode(base64_decode($encodedPayload), true);
        if (empty($decodedPayload)) {
            throw new BadCredentialsException('JWT token payload missing');
        }
        return $decodedPayload;
    }
}