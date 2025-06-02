<?php

namespace Revolution\Mastodon;

use GuzzleHttp\ClientInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Psr\Http\Message\ResponseInterface;
use Revolution\Mastodon\Contracts\Factory;

class MastodonClient implements Factory
{
    use Concerns\Accounts;
    use Concerns\Apps;
    use Concerns\Statuses;
    use Concerns\Streaming;
    use Conditionable;
    use Macroable;

    protected string $api_version = 'v1';

    protected ?ClientInterface $client = null;

    protected string $domain = '';

    protected string $token = '';

    protected string $api_base = '/api/';

    protected ?ResponseInterface $response = null;

    public function call(string $method, string $api, array $options = []): array
    {
        $response = Http::baseUrl($this->apiEndpoint())
            ->when(isset($this->client), fn (PendingRequest $client) => $client->setClient($this->client))
            ->when(filled($this->token), fn (PendingRequest $client) => $client->withToken($this->token))
            ->send($method, $api, $options);

        $this->response = $response->toPsrResponse();

        return $response->json() ?? [];
    }

    public function get(string $api, array $query = []): array
    {
        $options = [];

        if (! empty($query)) {
            $options['query'] = $query;
        }

        return $this->call('GET', $api, $options);
    }

    public function post(string $api, array $params = []): array
    {
        $options = [];

        if (! empty($params)) {
            $options['form_params'] = $params;
        }

        return $this->call('POST', $api, $options);
    }

    public function apiEndpoint(): string
    {
        return $this->domain.$this->api_base.$this->api_version;
    }

    public function setClient(ClientInterface $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function domain(string $domain): static
    {
        $this->domain = trim($domain, '/');

        return $this;
    }

    public function token(#[\SensitiveParameter] string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function apiVersion(string $api_version): static
    {
        $this->api_version = $api_version;

        return $this;
    }

    public function apiBase(string $api_base): static
    {
        $this->api_base = $api_base;

        return $this;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
