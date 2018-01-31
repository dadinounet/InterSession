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
    const fileReportName = "LOGXML_PHPCPD";
    const source = "Phpcpd";


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
        $test->setSource(TestPhpcpd::source);
        $test = parent::newTest($project, $test);
        return $test;
    }


    public function getCommande($parameter = null)
    {
        return "php ../vendor/bin/phpcpd --log-pmd=".Project::repoTesting."/".$this->getProject()->getName()."/".TestPhpcpd::fileReportName." ".Project::repoTesting."/".$this->getProject()->getName();
    }

    /**
     * @return mixed
     */
    public function getReportXML()
    {
        $file = fopen(Project::repoTesting."/".$this->getProject()->getName() ."/".TestPhpcpd::fileReportName, "r");
        $export = fread($file,filesize(Project::repoTesting."/".$this->getProject()->getName()."/".TestPhpcpd::fileReportName));
        return(simplexml_load_string($export));

    }
}