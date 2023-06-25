<?php

namespace Appwrite\Auth\OAuth2;

use Appwrite\Auth\OAuth2;

// Reference Material
// [DOCS FROM OAUTH PROVIDER]

class Confluence extends OAuth2
{
    private string $endpoint = '[ENDPOINT API URL]';
    protected array $user = [];
    protected array $tokens = [];
    protected array $scopes = [
        // [ARRAY_OF_REQUIRED_SCOPES]
    ];

    public function getName(): string
    {
        return 'confluence';
    }

    public function getLoginURL(): string
    {
        return 'https://auth.atlassian.com/authorize?'. \http_build_query([
            'audience' => 'api.atlassian.com',
            'client_id' => $this->appID,
            'scope' => \implode(' ', $this->getScopes()),
            'redirect_uri' => $this->callback,
            'state' => $this->state,
            'response_type' => 'code',
            'prompt' => 'consent'
        ]);
    }

    protected function getTokens(string $code): array
    {
        if (empty($this->tokens)) {
            $headers = ['Content-Type: application/json;charset=UTF-8'];
            $this->tokens = \json_decode($this->request(
                'POST',
                'https://auth.atlassian.com/oauth/token',
                $headers,
                \http_build_query([
                    'code' => $code,
                    'client_id' => $this->appID,
                    'client_secret' => $this->appSecret,
                    'redirect_uri' => $this->callback,
                    'grant_type' => 'authorization_code'
                ])
            ), true);
        }

        return $this->tokens;
    }

    public function refreshTokens(string $refreshToken): array
    {
        // TODO: Fire request to oauth API to generate access_token using refresh token
        $headers = ['Content-Type: application/json;charset=UTF-8'];
        $this->tokens = \json_decode($this->request(
            'POST',
            'https://auth.atlassian.com/oauth/token',
            $headers,
            \http_build_query([
                'client_id' => $this->appID,
                'client_secret' => $this->appSecret,
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken
            ])
        ), true);

        if (empty($this->tokens['refresh_token'])) {
            $this->tokens['refresh_token'] = $refreshToken;
        }

        return $this->tokens;
    }

    public function getUserID(string $accessToken): string
    {
        $user = $this->getUser($accessToken);

        return $user['user_id'] ?? '';
    }

    public function getUserEmail(string $accessToken): string
    {
        $user = $this->getUser($accessToken);

        return $user['email'] ?? '';
    }

    public function isEmailVerified(string $accessToken): bool
    {
        $email = $this->getUserEmail($accessToken);

        return !empty($email);
    }

    public function getUserName(string $accessToken): string
    {
        $user = $this->getUser($accessToken);

        return $user['name'] ?? '';
    }

    protected function getUser(string $accessToken): array
    {
        if (empty($this->user)) {
            $user = $this->request('GET', 'https://api.atlassian.com/me?' . \http_build_query([
                'Accept' => 'application/json'
            ]));
            $this->user = \json_decode($user, true);
        }
        return $this->user;
    }
}