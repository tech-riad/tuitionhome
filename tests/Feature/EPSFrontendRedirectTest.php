<?php

namespace Tests\Feature;

use Tests\TestCase;

class EPSFrontendRedirectTest extends TestCase
{
    public function test_app_frontend_url_is_configured_for_payment_redirects()
    {
        $this->assertNotNull(config('app.frontend_url'));
        $this->assertSame(
            env('FRONTEND_URL', config('app.url')),
            config('app.frontend_url')
        );
    }
}
