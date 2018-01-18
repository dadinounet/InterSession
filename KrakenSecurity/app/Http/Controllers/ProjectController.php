<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 14:32
 */

namespace App\Http\Controllers;

use App\ClassFolder\Project;

class ProjectController extends Controller
{
    public function test()
    {
        $project = new Project("https://github.com/dadinounet/InterSession.git");
        var_dump($project->cloneProject());
        die;
    }
}