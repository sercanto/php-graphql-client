<?php

namespace GraphQL\MutationBuilder;

use GraphQL\Mutation;

/**
 * Interface MutationBuilderinterface
 *
 * @package GraphQL\MutationBuilder
 */
interface MutationBuilderinterface
{
    /**
     * @return Mutation
     */
    function getMutation(): Mutation;
}