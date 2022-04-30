<?php

namespace Tests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function mockRequest(array $query = []): Request
    {
		return app(Request::class)->duplicate(query: $query);
    }
}
