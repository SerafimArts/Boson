<?php

declare(strict_types=1);

namespace Serafim\Boson\Core;

use Serafim\Boson\Core\Runtime\Architecture;

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
     * If the value is set to {@see true}, then debugging is enabled
     * or disabled instead
     */
    public bool $debug;

    /**
     * Contains the full path to the webview library.
     *
     * @var non-empty-string
     */
    public string $library;

    /**
     * @param bool|null $debug Automatically detects debug mode if {@see null}
     *        is passed, otherwise forces it to be enabled or disabled
     * @param non-empty-string|null $library Automatically detects the library
     *        pathname if {@see null}, otherwise it forcibly exposes it
     */
    public function __construct(
        ?bool $debug = null,
        ?string $library = null,
        /**
         * Contains the title set for the webview window when created
         */
        public string $title = '',
    ) {
        $this->debug = $debug ?? self::isDebugEnabledFromEnvironment();
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

    /**
     * Gets debug value from environment's "zend.assertions" status
     */
    private static function isDebugEnabledFromEnvironment(): bool
    {
        $debug = false;

        /**
         * Enable debug mode if "zend.assertions" is 1.
         *
         * @link https://www.php.net/manual/en/function.assert.php
         *
         * @phpstan-ignore-next-line PHPStan false-positive
         */
        assert($debug = true);

        return $debug;
    }
}
