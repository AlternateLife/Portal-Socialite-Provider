<?php

namespace AlternateLife\Socialite\Portal;

use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'ALTERNATELIFE';

    /**
     * {@inheritdoc}
     */
    protected $scopeSeparator = ' ';

    /**
     * {@inheritdoc}
     */
    protected $scopes = [];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'https://portal.alternate-life.de/oauth/authorize',
            $state
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://portal.alternate-life.de/oauth/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getAccessTokenByRefreshToken($token)
    {
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            'headers'     => [
                'Accept' => 'application/json',
            ],
            'form_params' => [
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type'    => 'refresh_token',
                'refresh_token' => $token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_add(
            parent::getTokenFields($code), 'grant_type', 'authorization_code'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://portal.alternate-life.de/api/user', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id'          => $user['id'],
            'name'        => $user['name'],
            'nickname'    => $user['name'],
            'character'   => $user['character'] ?? null,
            'whitelisted' => $user['whitelisted'] ?? null,
            'banned'      => $user['banned'] ?? null,
            'roles'       => $user['roles'] ?? null,
        ]);
    }
}
