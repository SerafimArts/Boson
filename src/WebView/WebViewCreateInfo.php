<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

use Serafim\Boson\Core\WebView\Architecture;

/**
 * Information (configuration) about creating a new webview object.
 */
final readonly class WebViewCreateInfo
{
    /**
     * @var non-empty-string
     */
    private const string DEFAULT_BINARY_DIRECTORY = __DIR__ . '/../../bin';

    /**
     * Contains the full path to the webview library.
     *
     * @var non-empty-string
     */
    public string $library;

    /**
     * @param non-empty-string|null $library Automatically detects the library
     *        pathname if {@see null}, otherwise it forcibly exposes it
     */
    public function __construct(
        ?string $library = null,
    ) {
        $this->library = $library ?? self::getRealLibraryPathname();
    }

    /**
     * Returns the autodetected library path
     *
     * @return non-empty-string
     */
    private static function getRealLibraryPathname(): string
    {
        return match (Architecture::fromEnvironment()) {
            Architecture::Amd64 => match (\PHP_OS_FAMILY) {
                'Windows' => self::DEFAULT_BINARY_DIRECTORY . '/libwebview-windows-amd64.dll',
                'Darwin' => self::DEFAULT_BINARY_DIRECTORY . '/libwebview-darwin-amd64.dylib',
                default => self::DEFAULT_BINARY_DIRECTORY . '/libwebview-linux-amd64.so',
            },
            Architecture::Arm64 => match (\PHP_OS_FAMILY) {
                'Windows' => throw new \OutOfRangeException(\sprintf(
                    'Current architecture (%s) may not be supported for Windows OS',
                    \php_uname('m'),
                )),
                'Darwin' => self::DEFAULT_BINARY_DIRECTORY . '/libwebview-darwin-arm64.dylib',
                default => throw new \OutOfRangeException(\sprintf(
                    'Current architecture (%s) may not be supported for Linux OS',
                    \php_uname('m'),
                )),
            },
            default => throw new \OutOfRangeException(\sprintf(
                'Current architecture (%s) may not be supported',
                \php_uname('m'),
            )),
        };
    }
}
