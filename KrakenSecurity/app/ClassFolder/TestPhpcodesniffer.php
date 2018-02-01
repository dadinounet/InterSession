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
    const source = "Code sniffer";


    public static function newTestPHP(Project $project)
    {
        $test = new self();
        $test = parent::newTest($project, $test, TestPhpcodesniffer::source);
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
        return "php ../vendor/bin/phpcs --report=xml ".Project::repoTesting."/".$this->getProject()->getName();
    }




}