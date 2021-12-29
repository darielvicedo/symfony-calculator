<?php

namespace App\Service;

use App\Enum\OperandTypeEnum;
use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Performs calculation operations.
 */
class CalculatorHelper
{
    /**
     * Performs a calculation between two integers.
     *
     * @param string $op
     * @param int $numA
     * @param int $numB
     * @return float
     * @throws Exception
     */
    public function calculate(string $op, int $numA, int $numB): float
    {
        // check for a defined operation
        if (!in_array($op, OperandTypeEnum::getAvailableTypes())) {
            throw new InvalidArgumentException("Invalid operation.", Response::HTTP_BAD_REQUEST);
        }

        try {
            // check if the operation is implemented
            if (!method_exists($this, $op)) {
                throw new Exception(sprintf("Operation for %s is not implemented yet.", OperandTypeEnum::getTypeName($op)), Response::HTTP_NOT_IMPLEMENTED);
            }

            // try to get a result
            $result = call_user_func_array([$this, $op], [$numA, $numB]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $result;
    }

    /**
     * Division implementation.
     *
     * @param int $numA
     * @param int $numB
     * @return float
     * @throws Exception
     */
    private function div(int $numA, int $numB): float
    {
        if (0 === $numB) {
            throw new Exception("Division by zero is not defined.", Response::HTTP_NOT_IMPLEMENTED);
        }

        return $numA / $numB;
    }

    /**
     * Addition implementation.
     *
     * @param int $numA
     * @param int $numB
     * @return int
     */
    private function add(int $numA, int $numB): int
    {
        return $numA + $numB;
    }

    /**
     * Subtraction implementation.
     *
     * @param int $numA
     * @param int $numB
     * @return int
     */
    private function sub(int $numA, int $numB): int
    {
        return $numA - $numB;
    }

    /**
     * Multiplication implementation.
     *
     * @param int $numA
     * @param int $numB
     * @return int
     */
    private function mul(int $numA, int $numB): int
    {
        return $numA * $numB;
    }
}
