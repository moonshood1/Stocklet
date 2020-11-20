<?php

namespace App\Security;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class GoogleAuthenticator extends SocialAuthenticator
{
    private $router;
    private $clientRegistry;
    private $manager;
    private $repo;

    public function __construct(RouterInterface $router, ClientRegistry $clientRegistry, EntityManagerInterface $manager, UserRepository $repo)
    {
        $this->router = $router;
        $this->clientRegistry = $clientRegistry;
        $this->manager = $manager;
        $this->repo = $repo;
    }

    public function start(Request $request, ?AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->router->generate('account_login'));
    }

    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'oauth_google_check';
    }

    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->getClient());
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /**  @var GoogleUser $googleUser */
        $googleUser = $this->getClient()->fetchUserFromToken($credentials);
       return $this->repo->findOrCreateFromGoogleOauth($googleUser);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        return new RedirectResponse('/');
    }

    private function getClient(): GoogleClient
    {
        return $this->clientRegistry->getClient('google');
    }
}
