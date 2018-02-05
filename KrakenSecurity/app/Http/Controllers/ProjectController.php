<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 14:32
 */

namespace App\Http\Controllers;

use App\ClassFolder\Project;
use App\ClassFolder\Report;
use App\ClassFolder\Test;
use App\ClassFolder\TestPhpcpd;
use App\ClassFolder\TestPhpcodesniffer;
use App\ClassFolder\TestPhploc;
use App\ClassFolder\TestPhpmd;
use App\ClassFolder\TestPhpmetric;
use App\ClassFolder\TestPHPmnd;
use App\ClassFolder\TestSecurityChecker;
use App\Jobs\ProcessGitClone;
use App\Jobs\ProcessReport;

class ProjectController extends Controller
{
    public function test()
    {
        $git = "https://github.com/kedorev/warhammerSymfo.git";
        //$git = "https://github.com/sebastianbergmann/phploc.git";
        $project = Project::newProject($git);
        $this->dispatch(new ProcessGitClone($project));


        /*$phpmdTest = TestPhpmd::newTestPHP($project);
        $testCpd = TestPhpcpd::newTestPHP($project);
        $testPHPloc = TestPhploc::newTestPHP($project);
        $testSniffer = TestPhpcodesniffer::newTestPHP($project);
        $testMnd = TestPHPmnd::newTestPHP($project);
        $composerLock = TestSecurityChecker::newTestPHP($project);

        $reportMDcodesize = Report::newReport($phpmdTest, "codesize");
        $this->dispatch(new ProcessReport($reportMDcodesize));
        $reportMDcleancode = Report::newReport($phpmdTest, "cleancode");
        $reportPhploc = Report::newReport($testPHPloc);
        $reportcpd = Report::newReport($testCpd);
        $reportSnifer = Report::newReport($testSniffer);
        $reportMND = Report::newReport($testMnd);
        $reportSecurityChecker = Report::newReport($composerLock);



        foreach ($project->getTests() as $test)
        {
            if($test->getSource() == TestSecurityChecker::source)
            {
                dump($test->getReports());
            }
        }
        dump($project);*/


    }

    public function getProject($id)
    {
        $projet = Project::getProjectById(intval($id));
        dump($projet);
        die;

    }


    public function mail()
    {
        $projet = Project::getProjectById(1);
        $projet->sendStarterMail('kedorev@gmail.com');
    }


    public function allTests()
    {
        echo Test::getJSONAllTest();
    }
}