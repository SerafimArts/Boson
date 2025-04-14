<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Scripts;

use FFI\CData;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Internal\ValueObject\Id\StructPointerId;

final readonly class ScriptId extends StructPointerId
{
    /**
     * Returns new {@see ScriptId} instance from given
     * `saucer_script*` struct pointer.
     *
     * @api
     */
    final public static function fromScriptHandle(LibSaucer $api, CData $handle): self
    {
        $id = self::getPointerIntValue($api, $handle);

        return new self($id, $handle);
    }
}
