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
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public $successStatus = 200;

    public function testform(Request $request)
    {
        return '<form>' . csrf_field() . '</form>';
    }

    public function test(Request $request)
    {



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

        //$user = Auth::user();
        //return ('tataosef');
        if($phploc == "1"){
            $testsToMake[TestPhploc::source] = 1;
            $success['phploc'] = 'OK';
        }
        else {
            $testsToMake[TestPhploc::source] = 0;
            $success['phploc'] = 'NOT OK';
        }
        if($phpmd == "1"){
            $testsToMake[TestPhpmd::source] = 1;
            $success['phpmd'] = 'OK';
        }
        else {
            $testsToMake[TestPhpmd::source] = 0;
            $success['phpmd'] = 'NOT OK';
        }
        if($securityschecker == "1"){
            $testsToMake[TestSecurityChecker::source] = 1;
            $success['securityschecker'] = 'OK';
        }
        else {
            $testsToMake[TestSecurityChecker::source] = 0;
            $success['securityschecker'] = 'NOT OK';
        }
        if($phpmnd == "1"){
            $testsToMake[TestPHPmnd::source] = 1;
            $success['phpmnd'] = 'OK';
        }
        else {
            $testsToMake[TestPHPmnd::source] = 0;
            $success['phpmnd'] = 'NOT OK';
        }
        if($phpcodesniffer == "1"){
            $testsToMake[TestPhpcodesniffer::source] = 1;
            $success['phpcodesniffer'] = 'OK';
        }
        else {
            $testsToMake[TestPhpcodesniffer::source] = 0;
            $success['phpcodesniffer'] = 'NOT OK';
        }
        if($phpcpd == "1"){
            $testsToMake[TestPhpcpd::source] = 1;
            $success['phpcpd'] = 'OK';
        }
        else {
            $testsToMake[TestPhpcpd::source] = 0;
            $success['phpcpd'] = 'NOT OK';
        }

        //@Todo : integrer les tests voulu par l'utilisateur dans le tableau testsToMake
        //---------------------------------------------------------

        $params['tests'] = $testsToMake;
        $this->dispatch(new ProcessProject($project,$params));
        return response()->json(['success' => $success], $this->successStatus);
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
        $project = Project::getProjectById($id);
        $project_to_JSON = $project->getProjectJson();
        //$this->test($git);
        //$project = $this->getProject($id);
        return($project_to_JSON);
    }
}