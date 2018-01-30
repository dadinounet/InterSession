<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 12:09
 */

namespace App\ClassFolder;



use Symfony\Component\Process\Exception\LogicException;

class Project
{
    const path = "/var/www/";
    const repoTesting = Project::path.'TestingArea';

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
        try
        {
            $folder = $this->getFolder();
            mkdir(Project::repoTesting."/".$this->getName());

        }
        catch (\Exception $e)
        {
            var_dump($e->getMessage());

        }

        shell_exec($commande);

    }


    /**
     * @return string
     * @throws \Exception
     */
    public function getFolder(): string
    {
        $name = "../TestingArea/".$this->getName();
        if(file_exists($name))
        {
            return $name;
        }
        else
        {
            throw new \Exception("Folder not found");
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

