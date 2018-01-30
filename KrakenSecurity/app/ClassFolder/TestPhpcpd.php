<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 18/01/18
 * Time: 14:33
 */

namespace App\ClassFolder;


class TestPhpcpd extends Test
{
    private $repport;

    public function __construct(Project $project)
    {
        $this->setProject($project);
        $this->setSource('Phpcpd');
        $project->addTest($this);
    }
    /**
     * @return mixed
     */
    public function getRepport()
    {
        if(is_null($this->repport))
        {
            $this->editReport();
        }
        return $this->repport;
    }

/*
composer require --dev sebastian/phpcpd*/

    private function editReport()
    {
        $commande =  "php ../vendor/bin/phpcpd ".Project::repoTesting."/".$this->getProject()->getName();
        $this->repport = shell_exec($commande);
    }
}