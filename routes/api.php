<?php

require_once(CORE_BASE.'Route.php');
Route::post('checkDuplicateEmail', 'FormController', 'checkDuplicationOfEmail');
