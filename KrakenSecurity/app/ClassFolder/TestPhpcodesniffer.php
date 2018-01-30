<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 19/01/18
 * Time: 09:17
 */

namespace App\ClassFolder;


class TestPhpcodesniffer extends Test
{
    private $repport;


    /**
     * TestPhpmetric constructor.
     * @param Project
     */
    public function __construct(Project $project)
    {
        $this->setProject($project);
        $this->setSource('Code sniffer');
        $project->addTest($this);
    }



    public function getRepport()
    {
        if(is_null($this->repport))
        {
            $this->defineRepport();
        }
        return $this->repport;
    }

    private function defineRepport()
    {
        $commande = "php ../vendor/bin/phpcs --report=xml ".Project::repoTesting."/".$this->getProject()->getName();
        $resultString = shell_exec($commande);
        $result = simplexml_load_string($resultString);

        $this->repport = $result;

    }
}