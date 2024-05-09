<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Handle\Win32WindowHandle;
use Serafim\WinUI\Driver\Win32\Lib\ImageLoadRegion;
use Serafim\WinUI\Driver\Win32\Lib\ImageType;
use Serafim\WinUI\Driver\Win32\Lib\User32;
use Serafim\WinUI\Driver\Win32\Text\Converter;

final readonly class IconLoader
{
    public function __construct(
        private Win32WindowHandle $handle,
        private User32 $user32,
        private Converter $text,
    ) {}

    /**
     * @return array{int, int}|null
     */
    private function getIcoFileSize(string $pathname): ?array
    {
        $stream = @\fopen($pathname, 'rb');

        if ($stream === false) {
            return null;
        }

        $chunk = @\fread($stream, 8);

        // Check if icon prefix contain valid length
        if (!\is_string($chunk) || \strlen($chunk) !== 8) {
            return null;
        }

        // Check if icon prefix is a valid ICO magik
        if (!\str_starts_with($chunk, "\x00\x00\x01\x00")) {
            return null;
        }

        // Then 2 bytes contain the number of icon images (int16).
        // The final two bytes contain the width (int8) and height (int8).
        return [
            \ord(\substr($chunk, 6, 1)),
            \ord(\substr($chunk, 7, 1)),
        ];
    }

    public function load(string $pathname): CData
    {
        if (!\is_readable($pathname)) {
            throw new \InvalidArgumentException('Could not load icon from "'. $pathname . '"');
        }

        $size = $this->getIcoFileSize($pathname);

        if ($size === null) {
            throw new \InvalidArgumentException('Invalid icon format');
        }

        $pathnameWideString = $this->text->wide($pathname, owned: false);

        try {
            $image = $this->user32->LoadImageW(
                $this->handle->class->instance->ptr,
                $pathnameWideString,
                ImageType::IMAGE_ICON,
                $size[0],
                $size[1],
                ImageLoadRegion::LR_LOADFROMFILE,
            );

            if ($image === null) {
                throw new \RuntimeException('Could not load icon file');
            }

            return $image;
        } finally {
            \FFI::free(\FFI::addr($pathnameWideString));
        }
    }
}
