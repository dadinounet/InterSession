<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 17/01/18
 * Time: 12:12
 */

namespace App\ClassFolder;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TestPhpmetric extends Test
{
  public function getJson()
  {
      shell_exec("php ./vendor/bin/phpmetrics --report-json=".$this->getProject()->getName()."/phpmetric.json ".$this->getProject()->getName());
  }
}

