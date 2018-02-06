<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 12:04
 */

namespace App\ClassFolder;

use App\Http\Controllers\ProjectController;
use App\Jobs\ProcessSaveTest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\DB as database;

/**
 * Class Test
 * @package App\ClassFolder
 */
abstract class Test
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $source;

    /**
     * @var int
     */
    private $idSource;

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
     * @var date
     */
    protected $created_at;

    /**
     * @var date
     */
    protected $updated_at;

    /**
     *
     * @param string $source
     */
    protected function __construct()
    {
    }
    /**
     * Prevent clonning
     */
    protected function __clone()
    {
    }

    protected static function newTest(Project $project, Test $test, string $source, int $idSource) :Test
    {
        $test->reports = array();
        $test->setProject($project);
        $test->setSource($source);
        $test->setIdSource($idSource);
        $project->addTest($test);
        $test->setUpdatedAt(now());
        $test->setCreatedAt(now());


        return $test;
    }


    public function save()
    {
        $id = database::table('tests')->insertGetId([
            "source" => $this->getSource(),
            "projectId" => $this->project->getId(),
            "updated_at" => $this->getUpdatedAt(),
            "created_at" => $this->getCreatedAt(),
        ]);
        $this->setId($id);
    }


    protected static function newTestFromDatas(Project $project, Test $test, $datas) :Test
    {
        $test->reports = array();
        $test->setSource($datas->source);
        $test->setProject($project);
        $test->setCreatedAt($datas->created_at);
        $test->setUpdatedAt($datas->updated_at);
        $project->addTest($test);
        $test->setId($datas->id);

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
    public function addReportWithoutCommande(Report $report)
    {
        array_push($this->reports, $report);
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
     * @return int
     */
    public function getIdSource(): int
    {
        return $this->idSource;
    }

    /**
     * @param int $idSource
     */
    public function setIdSource(int $idSource): void
    {
        $this->idSource = $idSource;
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param $created_at
     */
    protected function setCreatedAt( $created_at): void
    {
        $this->created_at = $created_at;
    }

    protected function getUpdatedAt()
    {
        return $this->updated_at;
    }


    public function setUpdatedAt( $updated_at): void
    {
        $this->updated_at = $updated_at;
    }




    public static function getTestById(int $id, Test $test, Project $project = null)
    {
        $data = database::table('tests')->where('id', $id)->first();
        $test->setId($id);
        $test->setSource($data->source);
        $test->setProject($project);
        return $test;
    }

    public static function getTestByProject(Project $project)
    {
        $query = database::table('tests')->where('projectId', $project->getId());
        $datas = $query->get();
        foreach ($datas as $data) {
            $test = "";
            if($data->source == TestPhpcpd::source)
            {
                $test = TestPhpcpd::getTestFromDatas($project, $data);
            }
            elseif($data->source == TestPhpmd::source)
            {
                $test = TestPhpmd::getTestFromDatas($project, $data);
            }
            elseif($data->source == TestPhpcodesniffer::source)
            {
                $test = TestPhpcodesniffer::getTestFromDatas($project, $data);
            }
            elseif($data->source == TestPhploc::source)
            {
                $test = TestPhploc::getTestFromDatas($project, $data);
            }
            if($test != "")
            {
                Report::getReportByTest($test);
            }


        }
    }


    protected static function getJsonTestDetails(string $source, int $sourceId)
    {
        return [
            "source" => $source,
            "id" => $sourceId
        ];
    }

    static public function getJSONAllTest()
    {
        $json = array();
        array_push($json,TestPHPmnd::getJsonTestDetails(TestPHPmnd::source, TestPHPmnd::idSource));
        array_push($json,TestPhpcodesniffer::getJsonTestDetails(TestPhpcodesniffer::source, TestPhpcodesniffer::idSource));
        array_push($json,TestSecurityChecker::getJsonTestDetails(TestSecurityChecker::source, TestSecurityChecker::idSource));
        array_push($json,TestPhploc::getJsonTestDetails(TestPhploc::source, TestPhploc::idSource));
        array_push($json,TestPhpcpd::getJsonTestDetails(TestPhpcpd::source, TestPhpcpd::idSource));
        array_push($json,TestPhpmd::getJsonTestDetails(TestPhpmd::source, TestPhpmd::idSource));

        return json_encode($json);
    }
}

