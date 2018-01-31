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

    /**
     * TestPhpmetric constructor.
     */
    private function __construct()
    {

    }

    /**
     * Prevent clonning object
     */
    private function __clone()
    {

    }


    public static function newTestPHP(Project $project)
    {
        $test = new self();
        $test = parent::newTest($project, $test);
        $test->setSource('Code sniffer');
        return $test;
    }


    public function getCommande()
    {
        return "php ../vendor/bin/phpcs --report=xml ".Project::repoTesting."/".$this->getProject()->getName();
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
        $commande =
        $resultString = shell_exec($commande);
        $result = simplexml_load_string($resultString);

        $this->repport = $result;

    }
}