<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 01/02/18
 * Time: 10:53
 */

namespace App\ClassFolder;


class TestPHPmnd extends Test
{
    const source = "Phpmnd";

    public function getCommande($parameter = null)
    {
        //php ./vendor/bin/phpmnd TestingArea/phploc/ --strings

        return "php ../vendor/bin/phpmnd ".Project::repoTesting."/".$this->getProject()->getName() ." --strings --extensions=all";
    }


    public static function newTestPHP(Project $project)
    {
        $test = new self();
        $test = parent::newTest($project, $test, TestPHPmnd::source);
        return $test;
    }

    public static function getTestFromDatas(Project $project, $datas)
    {
        $test = new self();
        $test = parent::newTestFromDatas($project, $test, $datas);
        return $test;
    }

}