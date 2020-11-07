<?php

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/budget-manager/cron/resetSpendings.php');

$reset = new Reset();
$reset->resetSpendings();