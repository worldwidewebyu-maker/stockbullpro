<?php

namespace Tests\Feature\Deploy;

use Tests\TestCase;

class DeployHookTest extends TestCase
{
    public function test_deploy_endpoint_requires_valid_token(): void
    {
        config(['app.deploy_secret' => 'test-deploy-secret']);

        $this->get(route('deploy.run'))
            ->assertUnauthorized();

        $this->get(route('deploy.run', ['token' => 'wrong']))
            ->assertUnauthorized();
    }

    public function test_deploy_endpoint_runs_with_valid_token(): void
    {
        config(['app.deploy_secret' => 'test-deploy-secret']);

        $this->get(route('deploy.run', ['token' => 'test-deploy-secret']))
            ->assertOk()
            ->assertJsonStructure(['ok', 'results', 'ran_at']);
    }
}
