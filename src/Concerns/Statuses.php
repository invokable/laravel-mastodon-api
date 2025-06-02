<?php

namespace Revolution\Mastodon\Concerns;

trait Statuses
{
    /**
     * Get a list of statuses by a user.
     */
    public function statuses(int $account_id, int $limit = 40, ?int $since_id = null): array
    {
        $url = "/accounts/$account_id/statuses";

        $query = [
            'limit' => $limit,
            'since_id' => $since_id,
        ];

        return $this->get($url, $query);
    }

    /**
     * Create new status.
     */
    public function createStatus(string $status, ?array $options = null): array
    {
        $url = '/statuses';

        $params = array_merge(['status' => $status], $options ?? []);

        return $this->post($url, $params);
    }

    /**
     * Retrieve status.
     */
    public function status(int $status_id): array
    {
        $url = "/statuses/$status_id";

        return $this->get($url);
    }
}
