<?php

namespace App\Jobs;

use App\ClassFolder\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class ProcessGitClone
 * @package App\Jobs
 */
class ProcessGitClone implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Project
     */
    private $project;


    /**
     * ProcessGitClone constructor.
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->project->cloneProject();
    }
}
