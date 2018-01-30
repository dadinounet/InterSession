<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 18/01/18
 * Time: 16:32
 */

namespace App\ClassFolder;


class TestPhploc extends Test
{
    private $report;

    public function __construct(Project $project)
    {
        $this->setProject($project);
        $this->setSource('Phploc');
        $project->addTest($this);
    }

    /**
     * @return mixed
     */
    public function getReport()
    {
        if(is_null($this->report))
        {
            $this->defineRepport();
        }
        return $this->report;
    }


    private function defineRepport()
    {
        $commande = "php ../vendor/bin/phploc ".Project::repoTesting."/".$this->getProject()->getName();
        $this->report = shell_exec($commande);
    }
    //
}