<?php

declare(strict_types=1);

namespace Local\Com\Exception;

use Local\Com\Meta\StructMetadata;

class ResultException extends ComException
{
    /**
     * @api
     * @param non-empty-string $proc External C API proc name.
     */
    public static function fromProcName(string $proc, int $code = 1): static
    {
        $message = \sprintf('An internal error occurred while invoking the %s() proc', $proc);

        return new static($message, $code);
    }

    /**
     * @api
     * @param non-empty-string $struct External C-struct name.
     * @param non-empty-string $proc External C-struct proc name.
     */
    public static function fromStructProcName(string $struct, string $proc, int $code = 1): static
    {
        $message = \sprintf('An internal error occurred while invoking the %s->%s() proc', $struct, $proc);

        return new static($message, $code);
    }

    /**
     * @api
     * @param StructMetadata<object> $meta
     * @param non-empty-string $proc External C-struct proc name.
     */
    public static function fromStructMetadata(StructMetadata $meta, string $proc, int $code = 1): static
    {
        return static::fromStructProcName($meta->name, $proc, $code);
    }

    /**
     * @api
     * @param non-empty-string $struct External C-struct name.
     * @param non-empty-string $proc External C-struct proc name.
     */
    public static function fromCallbackName(string $struct, string $proc, int $code = 1): static
    {
        $message = \sprintf('An error occurred while invoking the %s->%s() callback', $struct, $proc);

        return new static($message, $code);
    }

    /**
     * @api
     * @param StructMetadata<object> $meta
     * @param non-empty-string $method Local PHP callback method name or real C-struct callback name.
     */
    public static function fromCallbackMetadata(StructMetadata $meta, string $method, int $code = 1): static
    {
        if (isset($meta->callbacks[$method])) {
            $method = $meta->callbacks[$method]->name;
        }

        return static::fromCallbackName($meta->name, $method, $code);
    }
}
