<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use App\Services\HttpLogCounterService;
use App\Validations\LogCountRequestValidation;

class AnalyticsController extends AbstractController
{
    /**
     * @Route("/count", name="app_analytics")
     */
    public function index(Request $request, LogCountRequestValidation $LogCountRequestValidation): JsonResponse
    {
        $LogCountRequestValidation->input($request->query->all());
        
        $violations = $LogCountRequestValidation->validate();

        if (($violations->count() > 0)) {
            return new JsonResponse('bad input parameter', 400);
        }
        
        $httpLogCounter = new HttpLogCounterService($request->query->all(), 'storage/logs.log');

        return new JsonResponse([
          'counter' => $httpLogCounter->count(),
        ], 200);
    }
}
