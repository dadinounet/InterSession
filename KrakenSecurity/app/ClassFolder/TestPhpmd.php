<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 12:12
 */

namespace App\ClassFolder;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class TestPhpmetric
 * @package App\ClassFolder
 */
class TestPhpmd extends Test
{
    const source = "Phpmd";
    const idSource = 4;

    const validRules = array("codesize","cleancode","controversial","design","naming","unusedcode" );



    public static function newTestPHP(Project $project)
    {
        $test = new self();
        $test = parent::newTest($project, $test, TestPhpmd::source, TestPhpmd::idSource);
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
        if(in_array($parameter, TestPhpmd::validRules ))
        {
            return  "php ../vendor/bin/phpmd ".$this->getProject()->getPath()."/ xml rulesets/".$parameter.".xml";
        }
        else
        {
            throw new \LogicException("Rules ".$parameter." not found");
        }
    }

}

