<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 12:04
 */

namespace App\ClassFolder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * Class Test
 * @package App\ClassFolder
 */
abstract class Test
{
    /**
     * @var string
     */
    private $source;

    /**
     * @var boolean
     */
    private $valide;

    /**
     * @var Project
     */
    private $project;


    /**
     * @var array
     */
    protected $reports;

    /**
     *
     * @param string $source
     */
    private function __construct()
    {
    }
    /**
     * Prevent clonning
     */
    private function __clone()
    {
    }

    protected static function newTest(Project $project, Test $test) :Test
    {
        $test->reports = array();
        $test->setProject($project);
        $project->addTest($test);
        return $test;
    }

    /**
     * @return mixed
     */
    public function getReports() :array
    {
        return $this->reports;
    }


    /**
     * @param Report $report
     */
    public function addReport(Report $report, $parameter = null)
    {
        array_push($this->reports, $report);
        $report->setCommande($this->getCommande($parameter));
    }


    /**
     * @param Report $report
     */
    public function removeReport(Report $report)
    {
        $this->reports->forget($report);
    }


    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source)
    {
        $this->source = $source;
    }

    /**
     * @return bool
     */
    public function isValide(): bool
    {
        return $this->valide;
    }

    /**
     * @param bool $valide
     */
    public function setValide(bool $valide)
    {
        $this->valide = $valide;
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @param Project $project
     */
    protected function setProject(Project $project)
    {
        $this->project = $project;
    }


    abstract public function getCommande($parameter = null);


}

