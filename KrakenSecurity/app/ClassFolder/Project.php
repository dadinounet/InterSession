<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 12:09
 */

namespace App\ClassFolder;



use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Parent_;
use Symfony\Component\Process\Exception\LogicException;

class Project extends Model
{
    const path = "/var/www/";
    const repoTesting = Project::path.'TestingArea';



    protected $fillable = [
        'repoGit', 'name', 'id',
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';


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
     * @param string $repoGit
     */
    public function __construct(string $repoGit)
    {
        $this->repoGit = $repoGit;
        $arraySplitRepoGit = explode ( '/' , $repoGit );
        $arraySplitRepoGit = explode ( '.' , $arraySplitRepoGit[count($arraySplitRepoGit)-1] );
        $this->tests = array();

        $this->setName($arraySplitRepoGit[0]);

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
                throw new LogicException("Test allready set");
            }
        }
        array_push($this->tests, $test);
    }


}

