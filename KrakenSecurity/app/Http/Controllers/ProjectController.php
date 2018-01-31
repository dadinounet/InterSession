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

class ProjectController extends Controller
{
    public function test()
    {
        //$git = "https://github.com/kedorev/warhammerSymfo.git";
        $git = "https://github.com/sebastianbergmann/phploc.git";
        $project = Project::newProject($git);
        $project->cloneProject();

        $phpmdTest = TestPhpmd::newTestPHP($project);
        $testCpd = TestPhpcpd::newTestPHP($project);
        $testPHPloc = TestPhploc::newTestPHP($project);
        $testSniffer = TestPhpcodesniffer::newTestPHP($project);

        $reportMDcodesize = Report::newReport($phpmdTest, "codesize");
        $reportMDcleancode = Report::newReport($phpmdTest, "cleancode");
        $reportPhploc = Report::newReport($testPHPloc);
        $reportcpd = Report::newReport($testCpd);
        $reportSnifer = Report::newReport($testSniffer);



        dump($project);

        die;

    }

    public function getProject($id)
    {
        $projet = Project::getProjectById(intval($id));
        dump($projet);
        die;

    }
}