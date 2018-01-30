<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 14:32
 */

namespace App\Http\Controllers;

use App\ClassFolder\Project;
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
        $phpmdTest = new TestPhpmd($project);
        $phpmetricTest = new TestPhpmetric($project);
        $testCpd = new TestPhpcpd($project);
        $testCS = new TestPhpcodesniffer($project);
        $phploc = new TestPhploc($project);
        $phpmdTest->getCleanCodeRepport();
        $phpmdTest->getCodeSizeRepport();
        $phpmdTest->getControversialRepport();
        $phpmdTest->getDesignRepport();
        $phpmdTest->getNamingRepport();
        $phpmdTest->getUnusedcodeRepport();
        $testCpd->getRepport();
        $testCS->getRepport();
        $phploc->getReport();
        dump($project);

        //$phpmetricTest->getJson();
        //Project::create($project, $git);
        die;

    }

    public function getProject($id)
    {
        $projet = Project::getProjectById(intval($id));
        dump($projet);
        die;

    }
}