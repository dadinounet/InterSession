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

class ProjectController extends Controller
{
    public function test()
    {

        $paramaters = array("codesize","cleancode","controversial","design","naming","unusedcode" );
        $git = "https://github.com/kedorev/warhammerSymfo.git";
        //$git = "https://github.com/sebastianbergmann/phploc.git";
        $project = Project::newProject($git);
        $project->cloneProject();

        $phpmdTest = TestPhpmd::newTestPHP($project);
        $testCpd = TestPhpcpd::newTestPHP($project);
        $testPHPloc = TestPhploc::newTestPHP($project);
        $testSniffer = TestPhpcodesniffer::newTestPHP($project);
        $testMnd = TestPHPmnd::newTestPHP($project);

        //dump($testPHPloc->getTestJson());
        foreach ($paramaters as $paramater){
            $reportMD = Report::newReport($phpmdTest, $paramater);
        }
        //$reportMD = Report::newReport($phpmdTest, "codesize");

        $composerLock = TestSecurityChecker::newTestPHP($project);
        $reportMDcodesize = Report::newReport($phpmdTest, "codesize");
        $reportMDcleancode = Report::newReport($phpmdTest, "cleancode");
        $reportPhploc = Report::newReport($testPHPloc);

        $reportcpd = Report::newReport($testCpd);

        $reportSnifer = Report::newReport($testSniffer);
        $reportMND = Report::newReport($testMnd);

        $reportMND->getReportJson();
        $testMnd->getTestJson();
        $reportSecurityChecker = Report::newReport($composerLock);
        //dump($reportSecurityChecker->getReportJson());
        //dump($composerLock->getTestJson());
        /*foreach ($project->getTests() as $test)
        {
            if($test->getSource() == TestSecurityChecker::source)
            {
                dump($test->getReports());
            }
        }*/
        //dump($project);
        dump($project->getProjectJson());
        die;

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