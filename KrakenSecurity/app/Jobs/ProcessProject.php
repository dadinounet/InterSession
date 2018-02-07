<?php

namespace App\Jobs;

use App\ClassFolder\Project;
use App\ClassFolder\Report;
use App\ClassFolder\TestPhpcodesniffer;
use App\ClassFolder\TestPhpcpd;
use App\ClassFolder\TestPhploc;
use App\ClassFolder\TestPhpmd;
use App\ClassFolder\TestPHPmnd;
use App\ClassFolder\TestSecurityChecker;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class ProcessProject
 * @package App\Jobs
 */
class ProcessProject implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels,
        //Dispatchable;
        DispatchesJobs;

    /**
     * @var Project
     */
    private $project;
    private $param;


    /**
     * ProcessProject constructor.
     * @param Project $project
     */
    public function __construct(Project $project, array $param)
    {
        $this->project = $project;
        $this->param = $param;
        //dump($this);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->project->cloneProject();
        $this->project->save();
        foreach ($this->param['tests'] as $test => $value)
        {
            if($value == 1)
            {
                $params = null;
                if(TestPhploc::source == $test and $value == 1)
                {
                    $testInstance = TestPhploc::newTestPHP($this->project);
                }
                elseif(TestPhpmd::source == $test and $value == 1)
                {
                    $testInstance = TestPhpmd::newTestPHP($this->project);
                    $params = "codesize";
                }
                elseif(TestPhpcpd::source == $test and $value == 1)
                {
                    $testInstance = TestPhpcpd::newTestPHP($this->project);
                }
                elseif(TestSecurityChecker::source == $test and $value == 1)
                {
                    $testInstance = TestSecurityChecker::newTestPHP($this->project);
                }
                elseif(TestPhpcodesniffer::source == $test and $value == 1)
                {
                    $testInstance = TestPhpcodesniffer::newTestPHP($this->project);
                }
                elseif(TestPHPmnd::source == $test and $value == 1)
                {
                    $testInstance = TestPHPmnd::newTestPHP($this->project);
                }

                $testInstance->save();
                //dump($testInstance);
                /*dump("start ".$test);
                dump($testInstance);
                dump("stop ".$test);*/
                $report = Report::newReport($testInstance,$params);
                $report->saveIntoDB();
            }
        }
        $this->project->removeProjectTestingArea();

        dump($this->project);
    }
}
