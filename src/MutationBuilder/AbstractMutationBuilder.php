<?php

namespace GraphQL\MutationBuilder;

use GraphQL\Exception\EmptySelectionSetException;
use GraphQL\InlineFragment;
use GraphQL\Mutation;
use GraphQL\RawObject;
use GraphQL\Variable;

/**
 * Class AbstractMutationBuilder
 *
 * @package GraphQL
 */
abstract class AbstractMutationBuilder implements MutationBuilderInterface
{
    /**
     * @var Mutation
     */
    private $mutation;

    /**
     * @var array|Variable[]
     */
    private $variables;

    /**
     * @var array
     */
    private $selectionSet;

    /**
     * @var array
     */
    private $argumentsList;

    /**
     * MutationBuilder constructor.
     *
     * @param string $mutationObject
     * @param string $alias
     */
    public function __construct(string $mutationObject = '', string $alias = '')
    {
        $this->mutation      = new Mutation($mutationObject, $alias);
        $this->variables     = [];
        $this->selectionSet  = [];
        $this->argumentsList = [];
    }

    /**
     * @param string $alias
     *
     * @return $this
     */
    public function setAlias(string $alias)
    {
        $this->mutation->setAlias($alias);

        return $this;
    }

    /**
     * @return Mutation
     */
    public function getMutation(): Mutation
    {
        if (empty($this->selectionSet)) {
            throw new EmptySelectionSetException(static::class);
        }

        // Convert nested mutation builders to mutation objects
        foreach ($this->selectionSet as $key => $field) {
            if ($field instanceof AbstractMutationBuilder) {
                $this->selectionSet[$key] = $field->getMutation();
            }
        }

        $this->mutation->setVariables($this->variables);
        $this->mutation->setArguments($this->argumentsList);
        $this->mutation->setSelectionSet($this->selectionSet);

        return $this->mutation;
    }

    /**
     * @param string|MutationBuilder|Mutation $selectedField
     *
     * @return $this
     */
    protected function selectField($selectedField)
    {
        if (
            is_string($selectedField)
            || $selectedField instanceof AbstractMutationBuilder
            || $selectedField instanceof Mutation
            || $selectedField instanceof InlineFragment
        ) {
            $this->selectionSet[] = $selectedField;
        }

        return $this;
    }

    /**
     * @param $argumentName
     * @param $argumentValue
     *
     * @return $this
     */
    protected function setArgument(string $argumentName, $argumentValue)
    {
        if (is_scalar($argumentValue) || is_array($argumentValue) || $argumentValue instanceof RawObject) {
            $this->argumentsList[$argumentName] = $argumentValue;
        }

        return $this;
    }

    /**
     * @param string $name
     * @param string $type
     * @param bool   $isRequired
     * @param null   $defaultValue
     *
     * @return $this
     */
    protected function setVariable(string $name, string $type, bool $isRequired = false, $defaultValue = null)
    {
        $this->variables[] = new Variable($name, $type, $isRequired, $defaultValue);

        return $this;
    }
}
