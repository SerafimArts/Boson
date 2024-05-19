<?php

declare(strict_types=1);

namespace Local\Driver\Win32\Win32\Text;

final class Encoding implements EncodingProviderInterface
{
    /**
     * @var non-empty-string
     */
    private const string DEFAULT_INTERNAL_ENCODING = 'UTF-8';

    /**
     * @var non-empty-string
     */
    public readonly string $internal;

    /**
     * @var non-empty-string
     */
    public readonly string $external;

    public readonly bool $isLittleEndian;

    /**
     * @param non-empty-string|null $internal
     * @param non-empty-string|null $external
     */
    public function __construct(
        ?string $internal = null,
        ?string $external = null,
        ?bool $isLittleEndian = null,
    ) {
        $this->isLittleEndian = $isLittleEndian ?? self::detectLittleEndianness();
        $this->internal = $internal ?? self::detectInternalEncoding();
        $this->external = $external ?? self::detectExternalEncoding($this->isLittleEndian);
    }

    public function withInternalEncoding(string $encoding): self
    {
        return new self(
            internal: $encoding,
            external: $this->external,
            isLittleEndian: $this->isLittleEndian,
        );
    }

    public function withExternalEncoding(string $encoding): self
    {
        return new self(
            internal: $this->internal,
            external: $encoding,
            isLittleEndian: $this->isLittleEndian,
        );
    }

    /**
     * @return non-empty-string
     */
    private static function detectInternalEncoding(): string
    {
        $internal = \mb_internal_encoding();

        return $internal === '' ? self::DEFAULT_INTERNAL_ENCODING : $internal;
    }

    /**
     * @return non-empty-string
     */
    private static function detectExternalEncoding(bool $isLittleEndian): string
    {
        return 'UTF-16' . ($isLittleEndian ? 'LE' : 'BE');
    }

    private static function detectLittleEndianness(): bool
    {
        $data = \unpack('S', "\x01\x00");

        if (!\is_array($data)) {
            return false;
        }

        return ($data[1] ?? 1) === 1;
    }
}
