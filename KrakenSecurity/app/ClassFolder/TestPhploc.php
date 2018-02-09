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
    const idSource = 3;

    public static function newTestPHP(Project $project)
    {
        $test = new self();
        $test = parent::newTest($project, $test, TestPhploc::source, TestPhploc::idSource);
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
        $file = fopen($this->getProject()->getPath()."/".TestPhploc::fileReportName, "r");
        $export = fread($file,filesize($this->getProject()->getPath()."/".TestPhploc::fileReportName));
        return(simplexml_load_string($export));

    }




    public function getCommande($parameter = null)
    {
        return "php ./vendor/bin/phploc --log-xml=".$this->getProject()->getPath() ."/".TestPhploc::fileReportName." ".$this->getProject()->getPath();
    }


    /*public function getReportJson()
    {

        $report_to_JSON = json_encode($this->getReportXML());
        //dump(json_encode($report_to_JSON));
        //dump(getType($report_to_JSON));

        /*$lines = explode("\n", $report_to_JSON);
        foreach ($lines as $line){
            dump($line);
    }
        //dump(json_encode($report_to_JSON));


        return $report_to_JSON;
    }*/
}