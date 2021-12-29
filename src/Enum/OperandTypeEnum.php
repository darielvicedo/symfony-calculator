<?php

namespace App\Enum;

/**
 * Defines operation type.
 */
abstract class OperandTypeEnum
{
    const TYPE_ADD = 'add';
    const TYPE_SUB = 'sub';
    const TYPE_DIV = 'div';
    const TYPE_MUL = 'mul';

    protected static array $typeName = [
        self::TYPE_ADD => 'Add',
        self::TYPE_SUB => 'Subtract',
        self::TYPE_DIV => 'Divide',
        self::TYPE_MUL => 'Multiply',
    ];

    protected static array $operators = [
        '+' => self::TYPE_ADD,
        '-' => self::TYPE_SUB,
        '/' => self::TYPE_DIV,
        'x' => self::TYPE_MUL,
    ];

    /**
     * Gets the name of the operation.
     *
     * @param string $typeShortName
     * @return string
     */
    public static function getTypeName(string $typeShortName): string
    {
        if (!isset(static::$typeName[$typeShortName])) {
            return "Unknown type $typeShortName";
        }

        return static::$typeName[$typeShortName];
    }

    /**
     * Gets the operation name based on operator.
     *
     * @param string $operator
     * @return string
     */
    public static function getTypeByOperator(string $operator): string
    {
        if (!array_key_exists($operator, static::$operators)) {
            return "Unknown operator $operator";
        }

        return static::$operators[$operator];
    }

    /**
     * @return int[]
     */
    public static function getAvailableTypes(): array
    {
        return [
            self::TYPE_ADD,
            self::TYPE_SUB,
            self::TYPE_DIV,
            self::TYPE_MUL,
        ];
    }

    /**
     * Check if the operator is defined.
     *
     * @param string $operator
     * @return bool
     */
    public static function isOperatorDefined(string $operator): bool
    {
        return array_key_exists($operator, self::$operators);
    }
}
