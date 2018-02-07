<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 05/02/18
 * Time: 09:27
 */

namespace App\Http\Controllers;


use App\ClassFolder\Report;


class ReportController extends Controller
{
    /**
     * @param $id
     * @return Report
     * @deprecated : report will be set directly by test
     */
    public function getReportById($id)
    {
        $report = Report::getReportById($id);
        dump($report);
        return $report;
    }
}