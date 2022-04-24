<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class AppAuthenticator extends AbstractAuthenticator
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $hasher;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordHasherInterface $hasher,
    )
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'app_auth';
    }

    public function authenticate(Request $request): Passport
    {
        $user = $this->userRepository->findOneBy(['email' => $request->request->get('email')]);

        if ($user === null) {
            throw new AuthenticationException('user not found');
        }

        if (!$this->hasher->isPasswordValid($user, $request->request->get('password'))) {
            throw new AuthenticationException('invalid password');
        }

        return new Passport(
            new UserBadge($user->getEmail(), function (string $email) {
                return $this->userRepository->findOneBy(['email' => $email]);
            }),
            new PasswordCredentials($request->get('password')),
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse('/');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new RedirectResponse('/login?error-login=1');
    }
}
