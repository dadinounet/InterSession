<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 12:12
 */

namespace App\ClassFolder;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class TestPhpmetric
 * @package App\ClassFolder
 */
class TestPhpmetric extends Test
{


    /**
     * TestPhpmetric constructor.
     * @param Project
     */
    public function __construct(Project $project)
    {
        $this->setProject($project);
        $this->setSource('Php Metric');
        $project->addTest($this);
    }


    public function getCommande($parameter = null)
    {
        return "php ../vendor/bin/phpmetrics --report-json=".Project::repoTesting."/".$this->getProject()->getName()."/phpmetric.json ".Project::repoTesting."/".$this->getProject()->getName();
    }
}

