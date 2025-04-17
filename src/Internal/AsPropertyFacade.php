<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal;

/**
 * Indicates that the implementation is located in the property.
 */
#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY)]
final readonly class AsPropertyFacade extends AsFacade
{
    /**
     * @param class-string $of Class responsible for implementation.
     */
    public function __construct(
        string $of,
        /**
         * A property that implements a functionality.
         *
         * @var non-empty-string
         */
        public string $property,
    ) {
        parent::__construct($of);
    }
}
