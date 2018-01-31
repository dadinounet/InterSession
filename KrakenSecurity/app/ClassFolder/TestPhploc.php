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
        $test->setSource(TestPhploc::source);
        $test = parent::newTest($project, $test);
        return $test;
    }

    public function addReport(Report $report, $parameter = null)
    {
        parent::addReport($report, $parameter);

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
        //php ./vendor/bin/phploc --log-xml=/var/www/TestingArea/warhammerSymfo/LOG-XML /var/www/TestingArea/warhammerSymfo

        return "php ../vendor/bin/phploc --log-xml=".Project::repoTesting."/".$this->getProject()->getName() ."/".TestPhploc::fileReportName." ".Project::repoTesting."/".$this->getProject()->getName();
    }


}