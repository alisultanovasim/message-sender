<?php

namespace App\Http\Controllers;

use App\Companies;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\OpenApi (
 *     @OA\Info (
 *     version="3.0.0",
 *     title="Bigonder.az Api",
 *     description="All bigonder Apis are here",
 *     termsOfService="http://bigonder.az/api/terms",
 *     @OA\Contact(email="asimalisultanov000@gmail.com"),
 *     @OA\License(name="Apache 2.0",url="http://www.apache.org/licenses/LICENSE-2.0.html")
 *     ),
 *     * @OA\Server(
 *      url="http://localhost:8000/",
 *      description="Demo API Server"
 * )
 * ),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {

    }
}
