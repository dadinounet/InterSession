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
    private $codeSizeRepport;
    private $cleanCodeRepport;
    private $controversialRepport;
    private $designRepport;
    private $namingRepport;
    private $unusedcodeRepport;


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
        $test->setSource('Phpmd');
        $test = parent::newTest($project, $test);
        return $test;
    }





    /**
     * @return mixed
     */
    public function getCodeSizeRepport()
    {
        if(is_null($this->codeSizeRepport))
        {
            $this->getRepportCodeSize();
        }
        return $this->codeSizeRepport;
    }

    /**
     * @return mixed
     */
    public function getCleanCodeRepport()
    {
        if(is_null($this->cleanCodeRepport))
        {
            $this->getRepportCleanCode();
        }
        return $this->cleanCodeRepport;
    }

    /**
     * @return mixed
     */
    public function getControversialRepport()
    {

        if(is_null($this->controversialRepport))
        {
            $this->getRepportControversial();
        }
        return $this->controversialRepport;
    }

    /**
     * @return mixed
     */
    public function getDesignRepport()
    {
        if(is_null($this->designRepport))
        {
            $this->getRepportDesign();
        }
        return $this->designRepport;
    }

    /**
     * @return mixed
     */
    public function getNamingRepport()
    {
        if(is_null($this->namingRepport))
        {
            $this->getRepportNaming();
        }
        return $this->namingRepport;
    }

    /**
     * @return mixed
     */
    public function getUnusedcodeRepport()
    {
        if(is_null($this->unusedcodeRepport))
        {
            $this->getRepportUnusedcode();
        }
        return $this->unusedcodeRepport;
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




    /*private function getRepportCodeSize()
    {
        $commande = ;
        $resultString = shell_exec($commande);
        $result = simplexml_load_string($resultString);

        $this->codeSizeRepport = $result;
    }

    private function getRepportCleanCode()
    {
        $commande = "php ../vendor/bin/phpmd ".Project::repoTesting."/".$this->getProject()->getName()."/ xml rulesets/cleancode.xml";
        $resultString = shell_exec($commande);
        $result = simplexml_load_string($resultString);


        $this->cleanCodeRepport = $result;
    }

    private function getRepportControversial()
    {
        $commande = "php ../vendor/bin/phpmd ".Project::repoTesting."/".$this->getProject()->getName()."/ xml rulesets/controversial.xml";
        $resultString = shell_exec($commande);
        $result = simplexml_load_string($resultString);

        $this->controversialRepport = $result;
    }

    private function getRepportDesign()
    {
        $commande = "php ../vendor/bin/phpmd ".Project::repoTesting."/".$this->getProject()->getName()."/ xml rulesets/design.xml";
        $resultString = shell_exec($commande);
        $result = simplexml_load_string($resultString);

        $this->designRepport = $result;
    }

    private function getRepportNaming()
    {
        $commande = "php ../vendor/bin/phpmd ".Project::repoTesting."/".$this->getProject()->getName()."/ xml rulesets/naming.xml";
        $resultString = shell_exec($commande);
        $result = simplexml_load_string($resultString);

        $this->namingRepport = $result;
    }

    private function getRepportUnusedcode()
    {
        $commande = "php ../vendor/bin/phpmd ".Project::repoTesting."/".$this->getProject()->getName()."/ xml rulesets/unusedcode.xml";
        $resultString = shell_exec($commande);
        $result = simplexml_load_string($resultString);

        $this->unusedcodeRepport = $result;
    }*/


}

