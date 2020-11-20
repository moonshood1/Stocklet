<?php


namespace App\Security;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use League\OAuth2\Client\Provider\FacebookUser;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class FacebookAuthenticator extends SocialAuthenticator 
{
    private $router;
    private $repo;
    private $clientRegistry;
    private $manager;

    public function __construct(ClientRegistry $clientRegistry, RouterInterface $router,EntityManagerInterface $manager,UserRepository $repo)
    {
        $this->router = $router;
        $this->repo = $repo;
        $this->clientRegistry = $clientRegistry;
        $this->manager = $manager;
    }

    public function start(Request $request, ?AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->router->generate('account_login'));
    }

    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'oauth_facebook_check';
    }

    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->getClient());
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /**  @var FacebookUser $facebookUser */
        $facebookUser = $this->getClient()->fetchUserFromToken($credentials);
        return $this->repo->findOrCreateFromFacebookOauth($facebookUser);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new RedirectResponse('/');
    }

    private function getClient(): FacebookClient
    {
        return $this->clientRegistry->getClient('facebook');
    }
}
