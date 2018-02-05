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
    const idSource = 2;



    public static function newTestPHP(Project $project)
    {
        $test = new self();
        $test->setSource(TestPhpcpd::source);
        $test = parent::newTest($project, $test,TestPhpcpd::source, TestPhpcpd::idSource);
        return $test;
    }

    public static function getTestFromDatas(Project $project, $datas)
    {
        $test = new self();
        $test = parent::newTestFromDatas($project, $test, $datas);
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