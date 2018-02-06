<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 30/01/18
 * Time: 14:45
 */

namespace App\ClassFolder;

use Composer\Command\SearchCommand;
use Illuminate\Support\Facades\DB as database;

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

    /**
     * @var date
     */
    protected $created_at;

    /**
     * @var date
     */
    protected $updated_at;

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

        if($test->getSource() == TestPhploc::source || $test->getSource() == TestPhpcpd::source)
        {
            $report->report = $test->getReportXML();
        }
        else if($test->getSource() == TestPhpmd::source || $test->getSource() == TestPhpcodesniffer::source)
        {
            $report->report = simplexml_load_string($report->report);
        }
        else if($test->getSource() == TestPhpmd::source || $test->getSource() == TestPhpcodesniffer::source )
        {
            $report->report = simplexml_load_string($report->report);
        }
        else if($test->getSource() == TestPHPmnd::source) {
            $result = array();
            $element = explode("--------------------------------------------------------------------------------\n", $report->report);
            foreach ($element as $sub_elements) {
                $lines = explode("\n", $sub_elements);
                $size_lines = sizeof($lines);
                for ($i = 0; $i < $size_lines; $i++) {
                    if ($lines[$i] != "" && $i > 0) {
                        $header = "";
                        $head = substr($lines[$i], 0, 3);
                        if ($head != "  >" && $head != "Tot" && $head != "Tim") {
                            $header = strstr($lines[$i], '.', true) . ".php";
                        }
                        else if ($head == "  >") {
                            $header = "codeline";
                        }
                        else if ($head == "Tot") {
                            $header = "total";
                        }
                        else if ($head == "Tim") {
                            $header = "time";
                        }
                        $temp = array($header => $lines[$i]);
                        array_push($result, $temp);
                        //$result = array_merge($result, $temp);
                    }
                }

            }
            $report->report = $result;
        }
        else if($test->getSource() == TestSecurityChecker::source)
        {
            $report->report = json_decode($report->report);
        }

        $report->setCreatedAt(now());
        $report->setUpdatedAt(now());
        $id = database::table('reports')->insertGetId([
            "report" => $report->getReportString(),
            "testId" => $test->getId(),
            "updated_at" => $report->getUpdatedAt(),
            "created_at" => $report->getCreatedAt(),
        ]);
        $report->setId($id);
        return $report;
    }

    

    public function getReportJson()
    {

        $report = $this->report;
        $type = getType($report);
        /*if ($type != "object"){
            $report_to_JSON = json_decode($report);
        }
        else{
            $report_to_JSON = json_encode($report);
        }*/
        //dump("test report to JSON");
        //dump($report);

       /* dump(getType($this->getReport()));
        dump(getType($this->getTest()));*/
       //$test = $this->getTest();
       //dump($test->getReports());
       //$report =
        /*$report = $this->getReport();
        $typetest = getType($report);
        if($typetest =! "object"){
            $report_xml = simplexml_load_string($report);
            //$return =  $report_xml->asXML();
            dump($report_xml);
        }
        else {
            $return = $report;
        }

        //dump($return);
        dump($typetest);*/
        $report_to_JSON = json_encode($report);
        dump($report_to_JSON);
        return $report_to_JSON;
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
        /*if($this->getTest()->getSource() == TestPhploc::source)
        {
            $return =  $this->report->asXML();
        }
        else
        {*/
        $return = $this->report;
        //}
        return $return;
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

    public function getReportString() : string
    {
        $return = "";
        if(is_string($this->report))
        {
            $return = $this->report;
        }
        elseif (is_a($this->report,"SimpleXMLElement"))
        {
            $return = $this->report->asXML();
        }
        return $return;
    }

    public static function getReportById(int $id, Test $test = null): Report
    {
        $report = new self();
        $data = database::table('reports')->where('id', $id)->first();
        $report->setId($id);
        $report->setReport($data->report);
        $report->setTest($test);
        return $report;
    }

    public static function getReportByTest(Test $test)
    {
        $datas = database::table('reports')->where('testId', $test->getId())->get();
        foreach ($datas as $data)
        {
            $report = new self();
            $report->setId($data->id);
            $report->setReport($data->report);
            $report->setTest($test);
            $test->addReportWithoutCommande($report);
        }

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
    public function setCreatedAt($created_at): void
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
    public function setUpdatedAt( $updated_at): void
    {
        $this->updated_at = $updated_at;
    }



}