<?php

declare(strict_types=1);

namespace Serafim\Boson;

use FFI\CData;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Shared\Id\StructPointerId;

final readonly class ApplicationId extends StructPointerId
{
    final protected function __construct(
        /**
         * Application name
         *
         * @var non-empty-string
         */
        public string $name,
        int $id,
        CData $ptr,
    ) {
        parent::__construct($id, $ptr);
    }

    /**
     * Returns new {@see ApplicationId} instance from given
     * `saucer_application*` struct pointer and application name.
     *
     * @api
     *
     * @param non-empty-string $name
     */
    final public static function fromAppHandle(LibSaucer $api, CData $handle, string $name): self
    {
        $id = self::getPointerIntValue($api, $handle);

        return new self($name, $id, $handle);
    }
}
