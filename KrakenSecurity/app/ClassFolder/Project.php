<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 12:09
 */

namespace App\ClassFolder;



use phpDocumentor\Reflection\Types\Parent_;
use Illuminate\Support\Facades\DB;
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
     * Project constructor.
     */
    protected function __construct()
    {}
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

        $project->setName($arraySplitRepoGit[0]);
        /*DB::table('projects')->insert([

            "repoGit" => $project->getRepoGit(),
            "name" => $project->getName(),
            "updated_at" => now(),
            "created_at" => now(),
        ]);
        return $project;
    }

        ]);*/
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
    public static function getProjectById(int $id): ?Project
    {
        $data = DB::table('projects')->where('id', $id)->first();
        $project = new Project();
        $project->setId($data->id);
        $project->setName($data->name);
        $project->setRepoGit($data->repoGit);
        return $project;
    }
}

