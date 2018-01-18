<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 12:09
 */

namespace App\ClassFolder;



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
     * Project constructor.
     * @param string $repoGit
     */
    public function __construct(string $repoGit)
    {
        $this->repoGit = $repoGit;
        $arraySplitRepoGit = explode ( '/' , $repoGit );
        $arraySplitRepoGit = explode ( '.' , $arraySplitRepoGit[count($arraySplitRepoGit)-1] );

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
}

