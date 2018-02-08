<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 14:32
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClassFolder\Project;
use App\ClassFolder\Test;
use App\ClassFolder\TestPhpcpd;
use App\ClassFolder\TestPhpcodesniffer;
use App\ClassFolder\TestPhploc;
use App\ClassFolder\TestPhpmd;
use App\ClassFolder\TestPHPmnd;
use App\ClassFolder\TestSecurityChecker;
use App\Jobs\ProcessProject;

class ProjectController extends Controller
{
    public function test(Request $request)
    {
        //$git = "https://github.com/kedorev/warhammerSymfo.git";
        //$git = "https://github.com/sebastianbergmann/phploc.git";

        $input = $request->all();
        $git = $input['git'];
        $phploc = $input['TestPhploc'];
        $phpmd = $input['TestPhpmd'];
        $securityschecker = $input['TestSecurityChecker'];
        $phpmnd = $input['TestPHPmnd'];
        $phpcodesniffer = $input['TestPhpcodesniffer'];
        $phpcpd = $input['TestPhpcpd'];
        $project = Project::newProject($git);
        $testsToMake = array();




/*        //@Todo : integrer les tests voulu par l'utilisateur dans le tableau testsToMake

        $testsToMake[TestPhploc::source] = 1;
        $testsToMake[TestPhpmd::source] = 1;
        $testsToMake[TestSecurityChecker::source] = 1;
        $testsToMake[TestPHPmnd::source] = 1;
        $testsToMake[TestPhpcodesniffer::source] = 1;
        $testsToMake[TestPhpcpd::source] = 1;

        //---------------------------------------------------------

        $params['tests'] = $testsToMake;
        $this->dispatch(new ProcessProject($project,$params));*/
        dump($securityschecker);
        die;

    }


    public function getProject($id)
    {
        $projet = Project::getProjectById(intval($id));
        //dump($projet);
        return $projet;
        //die;

    }

    public function mail()
    {
        $projet = Project::getProjectById(1);
        $projet->sendStarterMail('kedorev@gmail.com');
    }


    public function allTests()
    {
        return Test::getJSONAllTest();
    }

    public function TesttoJSON($id){
        $project = $this->getProject();
        $project_to_JSON = $project->getProjectJson();
        //$this->test($git);
        //$project = $this->getProject($id);
        return($project_to_JSON);
    }
}