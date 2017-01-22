<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

<<<<<<< HEAD
class Controller extends BaseController
=======
abstract class Controller extends BaseController
>>>>>>> 00ec27f4a978d3702ee7c4bf63b73b8dd2c762a2
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
