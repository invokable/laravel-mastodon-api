<?php

namespace Revolution\Mastodon\Contracts;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

interface Factory
{
    public function createApp(string $client_name, string $redirect_uris, string $scopes, string $website = ''): array;

    public function verifyCredentials(): array;

    public function call(string $method, string $api, array $options = []): array;

    public function get(string $api, array $query = []): array;

    public function post(string $api, array $params = []): array;

    public function apiEndpoint(): string;

    public function setClient(ClientInterface $client): static;

    public function domain(string $domain): static;

    public function token(string $token): static;

    public function apiVersion(string $api_version): static;

    public function apiBase(string $api_base): static;

    public function getResponse(): ?ResponseInterface;

    public function statuses(int $account_id, int $limit = 40, ?int $since_id = null): array;

    public function createStatus(string $status, array $options = []): array;

    public function status(int $status_id): array;

    /**
     * @param  callable(string $event, string $data): void  $callback
     */
    public function streaming(string $url, callable $callback): void;
}
