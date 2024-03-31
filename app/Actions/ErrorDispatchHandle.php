<?php

namespace App\Actions;

use App\Services\Github\Issues;

class ErrorDispatchHandle
{
    public function handle(\Throwable $e): void
    {
        $issue = new Issues(Issues::createIssueMonolog('exception', $e->getMessage(), [$e]));
        $issue->createIssueFromException();
    }
}
