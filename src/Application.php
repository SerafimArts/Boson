<?php

declare(strict_types=1);

namespace Serafim\Boson;

use Serafim\Boson\Core\WebView\Architecture;
use Serafim\Boson\Core\WebView\WebViewLibrary;
use Serafim\Boson\WebView\WebView;
use Serafim\Boson\Window\Bridge\WebViewWindow;
use Serafim\Boson\Window\NewWindowCreateInfo;
use Serafim\Boson\Window\WindowCreateInfo;

final readonly class Application
{
    /**
     * @var non-empty-string
     */
    private const string DEFAULT_BINARY_DIRECTORY = __DIR__ . '/../bin';

    /**
     * Contains the full path to the webview library.
     *
     * @var non-empty-string
     */
    public string $library;

    /**
     * If the value is set to {@see true}, then debugging is enabled
     * or disabled instead
     */
    public bool $debug;

    /**
     * Shared WebView API library
     */
    private WebViewLibrary $api;

    /**
     * Gets application window instance
     */
    public WebViewWindow $window;

    /**
     * Gets application webview instance
     */
    public WebView $webview;

    /**
     * @param non-empty-string|null $library Automatically detects the library
     *        pathname if {@see null}, otherwise it forcibly exposes it
     */
    public function __construct(
        ?bool $debug = null,
        ?string $library = null,
        public WindowCreateInfo $info = new NewWindowCreateInfo(),
    ) {
        $this->debug = $debug ?? self::isDebugEnabledFromEnvironment();
        $this->library = $library ?? self::getRealLibraryPathname();

        $this->api = new WebViewLibrary($this->library);
        $this->window = new WebViewWindow($this->api, $info, $this->debug);
        $this->webview = $this->window->webview;
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

    /**
     * @api
     */
    public function quit(): void
    {
        $this->api->webview_terminate($this->window->handle->webview);
    }

    /**
     * @api
     */
    public function run(): void
    {
        if (\function_exists('\\sapi_windows_set_ctrl_handler')) {
            \sapi_windows_set_ctrl_handler(function () {
                $this->quit();
            });
        }

        $this->window->webview->run();
    }
}
