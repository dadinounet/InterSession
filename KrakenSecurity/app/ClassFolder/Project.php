<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 12:09
 */

namespace App\ClassFolder;



use App\Mail\startTestMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\Types\Parent_;
use SebastianBergmann\CodeCoverage\Report\Xml\Tests;
use Symfony\Component\Process\Exception\LogicException;
use Illuminate\Support\Facades\DB;

class Project
{
    const path = "/var/www/";
    const repoTesting = Project::path.'TestingArea';
  
    /**
     * @var integer
     */
    protected $id;
    /**
     * @var string
     */
    private $repoGit;

    /**
     * @var string
     */
    private $name;
    /**
     * @var array[test]
     */
    private $tests;

    /**
     * @var
     */
    protected $created_at;

    /**
     * @var
     */
    protected $updated_at;

    /**
     * @var integer
     */
    protected $user_id;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Project constructor.
     */
    protected function __construct()
    {

        $this->tests = array();
    }

    /**
     * @return string
     */
    public function getRepoGit(): string
    {
        return $this->repoGit;
    }
    /**
     * @param string $repoGit
     */
    public function setRepoGit(string $repoGit)
    {
        $this->repoGit = $repoGit;
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    /**
     * Clone the repo git in testing folder.
     */
    public function cloneProject()
    {
        $commande = 'git clone '.$this->getRepoGit()." ".$this->getPath();

        $this->createFolder();
        $return = shell_exec($commande);

    }
    /**
     * @return bool
     */
    public function getFolder(): bool
    {
        if(file_exists($this->getPath()))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
  
    private function createFolder()
    {
        if($this->getFolder() == 0)
        {
            try
            {
                var_dump($this->getPath());
                mkdir($this->getPath());

            }
            catch (\Error $e)
            {
                dump($e);
                die;
            }
        }
    }
    public function removeProjectTestingArea()
    {
        $commande = "rm -rf ".$this->getPath();
        shell_exec($commande);
    }
    /**
     * @return array
     */
    public function getTests(): array
    {
        return $this->tests;
    }
    /**
     * @param array $tests
     */
    public function setTests(array $tests)
    {
        $this->tests = $tests;
    }
    public function addTest(Test $test)
    {
        foreach ($this->tests as $testProject)
        {
            if($testProject->getSource() == $test->getSource())
            {
                throw new LogicException("Test ".$test->getSource()." allready set");
            }
        }
        array_push($this->tests, $test);
    }

    public static function newProject(string $repoGit) : Project
    {
        $project = new Project();
        $project->repoGit = $repoGit;
        $arraySplitRepoGit = explode ( '/' , $repoGit );
        $arraySplitRepoGit = explode ( '.' , $arraySplitRepoGit[count($arraySplitRepoGit)-1] );
        $project->tests = array();
        $project->user_id = Auth::id();

        $project->created_at = now();
        $project->updated_at = now();
        $project->setName($arraySplitRepoGit[0]);
        return $project;
    }

  
    public function update()
    {
        DB::table('projects')->where('id', $this->id)->update([
            "repoGit" => $this->getRepoGit(),
            "name" => $this->getName(),
            "updated_at" => now(),
        ]);
        foreach ($this->getTests() as $test)
        {
            $test->update();
        }
    }


    public function save()
    {
        dump($this);
        $id =  DB::table('projects')->insertGetId([
            "repoGit" => $this->getRepoGit(),
            "name" => $this->getName(),
            "user_id" => $this->user_id,
            "updated_at" => $this->created_at,
            "created_at" => $this->updated_at,
        ]);
        $this->setId($id);
    }

    private function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return date
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param date $created_at
     */
    protected function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return date
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param date $updated_at
     */
    protected function setUpdatedAt( $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public static function getProjectById(int $id): ?Project
    {
        $data = DB::table('projects')->where('id', $id)->first();
        $project = new self();
        $project->setId($data->id);
        $project->setName($data->name);
        $project->setRepoGit($data->repoGit);
        $project->setUserId($data->user_id);
        $project->setCreatedAt($data->created_at);
        $project->setUpdatedAt($data->updated_at);
        Test::getTestByProject($project);
        return $project;
    }

    public static function getProjectByUserId(int $user_id): ?array
    {
        $projects = array();
        $datas = DB::table('projects')->where('user_id', $user_id);
        foreach ($datas as $data){
            $project = new self();

            $project->setId($data->id);
            $project->setName($data->name);
            $project->setRepoGit($data->repoGit);
            $project->setUserId($data->user_id);
            $project->setCreatedAt($data->created_at);
            $project->setUpdatedAt($data->updated_at);
            Test::getTestByProject($project);
            array_push($projects, $project);
        }

        return $projects;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {


        $path = Project::repoTesting."/".$this->created_at."_".$this->getName();
        $path = str_replace(' ','_',$path);
        var_dump($path);
        return($path);

    }


    public function getProjectJson()
    {

        $tests_results = array();
        $name_project = $this->name;
        foreach ($this->tests as $test) {
            $report_to_JSON = json_decode($test->getTestJson());
            $temp_array = array($report_to_JSON);
            array_push($tests_results, $temp_array);
        }
        $result = array($name_project => $tests_results);
        $result_to_JSON = json_encode($result);
        return $result_to_JSON;
    }


    public function sendStarterMail(string $dest)
    {
        Mail::to($dest)->send(new startTestMail());

    }
}

