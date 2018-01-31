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
    private $report;

    public function __construct(Project $project)
    {
        $this->setProject($project);
        $this->setSource('Phploc');
        $project->addTest($this);
    }

    /**
     * @return mixed
     */
    public function getReport()
    {
        if(is_null($this->report))
        {
            $this->defineRepport();
        }
        //dump("début");
        //dump($this->report);
        //dump(getType($this->report));
        //dump("fin");
        return $this->report;
    }


    private function defineRepport()


//php ./vendor/bin/phploc --log-xml=/var/www/TestingArea/warhammerSymfo/LOG-XML / var/www/TestingArea/warhammerSymfo
    {
        $commande = "php ../vendor/bin/phploc --log-xml=".Project::repoTesting."/".$this->getProject()->getName()."/LOG-XML ".Project::repoTesting."/".$this->getProject()->getName();
        dump(Project::repoTesting."/".$this->getProject()->getName());
        dump($commande);
        $this->report = shell_exec($commande);

    }


    public function getJson()
    {
        $report_to_JSON = $this->getReport();
        dump($report_to_JSON);
        dump(getType($report_to_JSON));
        /*$lines = explode("\n", $report_to_JSON);
        foreach ($lines as $line){
            dump($line);
    }*/
        //dump(json_encode($report_to_JSON));
    }
}