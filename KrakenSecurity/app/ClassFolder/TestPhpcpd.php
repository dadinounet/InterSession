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
        return "php ./vendor/bin/phpcpd --log-pmd=".$this->getProject()->getPath()."/".TestPhpcpd::fileReportName." ".$this->getProject()->getPath();
    }


    public function getReportXML()
    {
        $file = fopen($this->getProject()->getPath() ."/".TestPhpcpd::fileReportName, "r");
        $export = fread($file,filesize($this->getProject()->getPath()."/".TestPhpcpd::fileReportName));
        return(simplexml_load_string($export));

    }

    public function getReportJson()
    {
        $report_to_JSON = json_encode($this->getReportXML());
        //dump(json_encode($report_to_JSON));
        //dump(getType($report_to_JSON));

        /*$lines = explode("\n", $report_to_JSON);
        foreach ($lines as $line){
            dump($line);
    }*/
        //dump(json_encode($report_to_JSON));


        return $report_to_JSON;
    }

}