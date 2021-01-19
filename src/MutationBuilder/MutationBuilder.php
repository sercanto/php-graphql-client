<?php

namespace GraphQL\MutationBuilder;

use GraphQL\Mutation;

/**
 * Class MutationBuilder
 *
 * @package GraphQL
 */
class MutationBuilder extends AbstractMutationBuilder
{
    /**
     * Changing method visibility to public
     *
     * @param Mutation|MutationBuilder|string $selectedField
     *
     * @return AbstractMutationBuilder|MutationBuilder
     */
    public function selectField($selectedField)
    {
        return parent::selectField($selectedField);
    }

    /**
     * Changing method visibility to public
     *
     * @param string $argumentName
     * @param        $argumentValue
     *
     * @return AbstractMutationBuilder|MutationBuilder
     */
    public function setArgument(string $argumentName, $argumentValue)
    {
        return parent::setArgument($argumentName, $argumentValue);
    }

    /**
     * Changing method visibility to public
     *
     * @param string $name
     * @param string $type
     * @param bool   $isRequired
     * @param null   $defaultValue
     *
     * @return AbstractMutationBuilder|MutationBuilder
     */
    public function setVariable(string $name, string $type, bool $isRequired = false, $defaultValue = null)
    {
        return parent::setVariable($name, $type, $isRequired, $defaultValue);
    }
}