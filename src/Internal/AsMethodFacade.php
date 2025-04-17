<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal;

/**
 * Indicates that the implementation is located in the method.
 */
#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY)]
final readonly class AsMethodFacade extends AsFacade
{
    /**
     * @param class-string $of Class responsible for implementation.
     */
    public function __construct(
        string $of,
        /**
         * A method that implements a functionality.
         *
         * @var non-empty-string
         */
        public string $method,
    ) {
        parent::__construct($of);
    }
}
