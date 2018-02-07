<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 05/02/18
 * Time: 15:44
 */

namespace App\Jobs;

use App\ClassFolder\Test;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessSaveTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $test;
    protected $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Test $test, array $params)
    {
        $this->test = $test;
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //dump("start save test");
        $this->test->save();
    }
}
