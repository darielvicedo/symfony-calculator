<?php

namespace App\Controller;

use App\Service\CalculatorHelper;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * Performs operation {op} on the given operands {numA},  {numB}.
     *
     * @param string $op
     * @param int $numA
     * @param int $numB
     * @param CalculatorHelper $calc
     * @return Response
     */
    #[Route(path: '{op}/{numA}/{numB}', name: 'app_calculator_calculate', requirements: ['numA' => '\d+', 'numB' => '\d+'], methods: ['GET'])]
    public function calculator(string $op, int $numA, int $numB, CalculatorHelper $calc): Response
    {
        try {
            $result = $calc->calculate(trim(strtolower($op)), $numA, $numB);
        } catch (Exception $e) {
            return $this->json([
                'error' => $e->getCode(),
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return $this->json([
            'result' => $result,
        ], Response::HTTP_OK);
    }
}
