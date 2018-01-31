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
    const fileReportName = "LOGXML_PHPLOC";
    const source = "Phploc";


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
        $test = parent::newTest($project, $test, TestPhploc::source);
        return $test;
    }

    public static function getTestFromDatas(Project $project, $datas)
    {
        $test = new self();
        $test = parent::newTestFromDatas($project, $test, $datas);
        return $test;
    }


    /**
     * @return mixed
     */
    public function getReportXML()
    {
        $file = fopen(Project::repoTesting."/".$this->getProject()->getName() ."/".TestPhploc::fileReportName, "r");
        $export = fread($file,filesize(Project::repoTesting."/".$this->getProject()->getName()."/".TestPhploc::fileReportName));
        return(simplexml_load_string($export));

    }


    public function getCommande($parameter = null)
    {
        return "php ../vendor/bin/phploc --log-xml=".Project::repoTesting."/".$this->getProject()->getName() ."/".TestPhploc::fileReportName." ".Project::repoTesting."/".$this->getProject()->getName();
    }


}