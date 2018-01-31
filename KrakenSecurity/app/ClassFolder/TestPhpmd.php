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
        $test->setSource(TestPhpmd::source);
        $test = parent::newTest($project, $test);
        return $test;
    }


    public function getCommande($parameter = null)
    {
        $validRules = array("codesize","cleancode","controversial","design","naming","unusedcode" );
        if(in_array($parameter, $validRules ))
        {
            return  "php ../vendor/bin/phpmd ".Project::repoTesting."/".$this->getProject()->getName()."/ xml rulesets/".$parameter.".xml";
        }
        else
        {
            throw new \LogicException("Rules ".$parameter." not found");
        }
    }
}

