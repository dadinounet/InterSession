<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 14:32
 */

namespace App\Http\Controllers;

use App\ClassFolder\Project;
use App\ClassFolder\TestPhpmd;
use App\ClassFolder\TestPhpmetric;

class ProjectController extends Controller
{
    public function test()
    {
        $project = new Project("https://github.com/kedorev/warhammerSymfo.git");
        $project->cloneProject();
        $phpmdTest = new TestPhpmd($project);
        $phpmetricTest = new TestPhpmetric($project);
        $phpmdTest->getCleanCodeRepport();
        $phpmdTest->getCodeSizeRepport();
        $phpmdTest->getControversialRepport();
        $phpmdTest->getDesignRepport();
        $phpmdTest->getNamingRepport();
        $phpmdTest->getUnusedcodeRepport();
        dump($project);
        $phpmetricTest->getJson();
        die;
    }
}