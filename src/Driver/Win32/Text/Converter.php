<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Text;

use FFI\CData;
use FFI\Env\Runtime;

final readonly class Converter implements EncodingProviderInterface
{
    public Encoding $encoding;

    private \FFI $ffi;

    public function __construct(?Encoding $encoding = null)
    {
        Runtime::assertAvailable();

        $this->ffi = \FFI::cdef();

        $this->encoding = $encoding ?? new Encoding();
    }

    public function withInternalEncoding(string $encoding): self
    {
        return new self($this->encoding->withInternalEncoding($encoding));
    }

    public function withExternalEncoding(string $encoding): self
    {
        return new self($this->encoding->withExternalEncoding($encoding));
    }

    /**
     * @param non-empty-string|null $encoding
     */
    public function decode(string $text, ?string $encoding = null): string
    {
        $decoded = \mb_convert_encoding(
            $text,
            $this->encoding->internal,
            $encoding ?? $this->encoding->external,
        );

        return \rtrim($decoded, "\0");
    }

    /**
     * @param non-empty-string|null $encoding
     */
    public function encode(string $text, ?string $encoding = null): string
    {
        return \mb_convert_encoding(
            $text,
            $encoding ?? $this->encoding->external,
            $this->encoding->internal,
        );
    }

    public function fromWide(CData $ptr, ?string $encoding = null): string
    {
        $buffer = '';
        $index = 0;

        while (true) {
            $buffer .= $ptr[++$index];

            if (\str_ends_with($buffer, "\0\0")) {
                return $this->decode($buffer, $encoding);
            }
        }
    }

    /**
     * @param non-empty-string|null $encoding
     */
    public function wide(string $text, ?string $encoding = null, bool $owned = true): CData
    {
        $encoded = $this->encode($text, $encoding);
        $length = \strlen($nullTerminated = $encoded . "\0\0\0\0");
        // @phpstan-ignore-next-line
        $instance = $this->ffi->new("const char[$length]", $owned);
        // @phpstan-ignore-next-line
        \FFI::memcpy($instance, $nullTerminated, $length);

        /** @var CData */
        return $instance;
    }

    public function ansi(string $text, bool $owned = true): CData
    {
        $length = \strlen($text .= "\0");
        // @phpstan-ignore-next-line
        $instance = $this->ffi->new("const char[$length]", $owned);
        // @phpstan-ignore-next-line
        \FFI::memcpy($instance, $text, $length);

        /** @var CData */
        return $instance;
    }
}
