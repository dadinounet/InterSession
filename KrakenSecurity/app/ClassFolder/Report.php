<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 30/01/18
 * Time: 14:45
 */

namespace App\ClassFolder;


class Report
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Test
     */
    private $test;

    /**
     * @var string
     */
    private $report;

    /**
     * @var string
     */
    private $commande;


    private function __construct()
    {}

    private function __clone()
    {}

    public static function newReport(Test $test, string $parameter = null)
    {
        $report = new self();
        $report->test = $test;
        $test->addReport($report, $parameter);
        $report->commande = $test->getCommande($parameter);
        $report->report = shell_exec($report->getCommande());
        if($test->getSource() == TestPhploc::source)
        {
            $report->report = $test->getReportXML();
        }
        return $report;
    }


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

    /**
     * @return int
     */
    public function getTest(): Test
    {
        return $this->test;
    }

    /**
     * @param int $testId
     */
    public function setTest(Test $testId)
    {
        $this->test = $testId;
    }

    /**
     * @return string
     */
    public function getReport(): string
    {
        return $this->report;
    }

    /**
     * @param string $report
     */
    public function setReport(string $report): void
    {
        $this->report = $report;
    }

    /**
     * @return string
     */
    public function getCommande(): string
    {
        return $this->commande;
    }

    /**
     * @param string $commande
     */
    public function setCommande(string $commande): void
    {
        $this->commande = $commande;
    }



}