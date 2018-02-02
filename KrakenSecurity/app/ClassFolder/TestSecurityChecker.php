<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 02/02/18
 * Time: 11:19
 */

namespace App\ClassFolder;


class TestSecurityChecker extends Test
{
    const source = "Security Check";


    public static function newTestPHP(Project $project)
    {
        $test = new self();
        $test = parent::newTest($project, $test, TestSecurityChecker::source);
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
        return "curl -H \"Accept: application/json\" https://security.sensiolabs.org/check_lock -F lock=@".Project::repoTesting."/".$this->getProject()->getName().$parameter."/composer.lock";
        //return "php ../security-checker.phar security:check ".Project::repoTesting."/".$this->getProject()->getName().$parameter."/composer.lock";
    }
}