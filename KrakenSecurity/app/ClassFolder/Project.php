<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 12:09
 */

namespace App\ClassFolder;



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
        $commande = 'git clone '.$this->getRepoGit()." ".Project::repoTesting."/".$this->getName();

        $this->createFolder();

        $return = shell_exec($commande);

    }


    /**
     * @return bool
     */
    public function getFolder(): bool
    {
        $name = "../TestingArea/".$this->getName();
        if(file_exists($name))
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
                mkdir(Project::repoTesting."/".$this->getName());

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
        $commande = "rm -rf ".Project::repoTesting."/".$this->getName();
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

        $project->created_at = now();
        $project->updated_at = now();
        $project->setName($arraySplitRepoGit[0]);
        $id =  DB::table('projects')->insertGetId([
            "repoGit" => $project->getRepoGit(),
            "name" => $project->getName(),
            "updated_at" => $project->created_at,
            "created_at" => $project->updated_at,
        ]);
        $project->setId($id);
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
        $project->setCreatedAt($data->created_at);
        $project->setUpdatedAt($data->updated_at);
        Test::getTestByProject($project);
        return $project;
    }
}

