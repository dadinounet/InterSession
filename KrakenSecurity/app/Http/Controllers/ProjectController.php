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
use App\ClassFolder\TestPhpcpd;
use App\ClassFolder\TestPhpcodesniffer;
use App\ClassFolder\TestPhploc;
use App\ClassFolder\TestPhpmd;
use App\ClassFolder\TestPhpmetric;
use App\ClassFolder\TestPHPmnd;

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
            //dump(getType($reportMD));
            //$reportMD->getReportJson();
        }
        //$reportMD = Report::newReport($phpmdTest, "codesize");

        $reportMDcodesize = Report::newReport($phpmdTest, "codesize");
        $reportMDcleancode = Report::newReport($phpmdTest, "cleancode");
        $reportPhploc = Report::newReport($testPHPloc);
        //$reportPhploc->getReportJson();
        $reportcpd = Report::newReport($testCpd);
        //$reportcpd->getReportJson();
        $reportSnifer = Report::newReport($testSniffer);
        $reportMND = Report::newReport($testMnd);
        $reportMND->getReportJson();
        //$testPHPloc->getTestJson();
        //$testSniffer->getTestJson();
        $testMnd->getTestJson();
        //dump(getType($project));

        dump($project->getProjectJson());

        die;

    }

    public function getProject($id)
    {
        $projet = Project::getProjectById(intval($id));
        dump($projet);

        die;

    }


}