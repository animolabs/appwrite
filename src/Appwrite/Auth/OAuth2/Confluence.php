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
        $url = $this->endpoint . '[LOGIN_URL_STUFF]';
        return $url;
    }

    protected function getTokens(string $code): array
    {
        if (empty($this->tokens)) {
            // TODO: Fire request to oauth API to generate access_token
            // Make sure to use '$this->getScopes()' to include all scopes properly
            $this->tokens = ["[FETCH TOKEN RESPONSE]"];
        }

        return $this->tokens;
    }

    public function refreshTokens(string $refreshToken): array
    {
        // TODO: Fire request to oauth API to generate access_token using refresh token
        $this->tokens = ["[FETCH TOKEN RESPONSE]"];

        return $this->tokens;
    }

    public function getUserID(string $accessToken): string
    {
        $user = $this->getUser($accessToken);

        // TODO: Pick user ID from $user response
        $userId = "[USER ID]";

        return $userId;
    }

    public function getUserEmail(string $accessToken): string
    {
        $user = $this->getUser($accessToken);

        // TODO: Pick user email from $user response
        $userEmail = "[USER EMAIL]";

        return $userEmail;
    }

    public function isEmailVerified(string $accessToken): bool
    {
        $user = $this->getUser($accessToken);

        // TODO: Pick user verification status from $user response
        $isVerified = "[USER VERIFICATION STATUS]";

        return $isVerified;
    }

    public function getUserName(string $accessToken): string
    {
        $user = $this->getUser($accessToken);

        // TODO: Pick username from $user response
        $username = "[USERNAME]";

        return $username;
    }

    protected function getUser(string $accessToken): array
    {
        if (empty($this->user)) {
            // TODO: Fire request to oauth API to get information about users
            $this->user = "[FETCH USER RESPONSE]";
        }

        return $this->user;
    }
}