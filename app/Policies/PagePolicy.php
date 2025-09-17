<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the client can view the page.
     */
    public function view(Client $client, Page $page)
    {
        return $client->id === $page->client_id;
    }

    /**
     * Determine whether the client can update the page.
     */
    public function update(Client $client, Page $page)
    {
        return $client->id === $page->client_id;
    }

    /**
     * Determine whether the client can delete the page.
     */
    public function delete(Client $client, Page $page)
    {
        return $client->id === $page->client_id;
    }
}
