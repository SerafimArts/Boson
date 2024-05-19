<?php

declare(strict_types=1);

namespace Local\Driver\Win32\Win32;

use FFI\CData;
use Local\Driver\Win32\Win32\Text\Converter;

final class Text
{
    private static ?Converter $instance = null;

    public static function getInstance(): Converter
    {
        return self::$instance ??= new Converter();
    }

    /**
     * @param non-empty-string|null $encoding
     */
    public static function decode(string $text, ?string $encoding = null): string
    {
        return self::getInstance()
            ->decode($text, $encoding);
    }

    /**
     * @param non-empty-string|null $encoding
     */
    public static function encode(string $text, ?string $encoding = null): string
    {
        return self::getInstance()
            ->encode($text, $encoding);
    }

    /**
     * @param non-empty-string|null $encoding
     */
    public static function fromWide(CData $text, ?string $encoding = null): string
    {
        return self::getInstance()
            ->fromWide($text, $encoding);
    }

    /**
     * @param non-empty-string|null $encoding
     */
    public static function wide(string $text, ?string $encoding = null, bool $owned = true): CData
    {
        return self::getInstance()
            ->wide($text, $encoding, $owned);
    }

    public static function ansi(string $text, bool $owned = true): CData
    {
        return self::getInstance()
            ->ansi($text, $owned);
    }
}
