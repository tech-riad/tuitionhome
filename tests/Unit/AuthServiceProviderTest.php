<?php

namespace Tests\Unit;

use App\Providers\AuthServiceProvider;
use Illuminate\Foundation\Application;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AuthServiceProviderTest extends TestCase
{
    public function test_corporate_partners_scope_is_registered(): void
    {
        $provider = new AuthServiceProvider($this->app);
        $provider->boot();

        $scopes = Passport::tokensCan();

        $this->assertArrayHasKey('corporate_partners', $scopes);
    }
}
