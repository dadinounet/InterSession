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


    /**
     * TestPhpmetric constructor.
     */
    private function __construct()
    {}

    /**
     * Prevent clonning object
     */
    private function __clone()
    {}


    public static function newTestPHP(Project $project)
    {
        $test = new self();
        $test->setSource('Phpcpd');
        $test = parent::newTest($project, $test);
        return $test;
    }


    public function getCommande($parameter = null)
    {
        return "php ../vendor/bin/phpcpd ".Project::repoTesting."/".$this->getProject()->getName();
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

    private function defineReport()
    {

        $this->repport = shell_exec($commande);
    }
}