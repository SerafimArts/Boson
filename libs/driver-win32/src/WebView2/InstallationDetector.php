<?php

declare(strict_types=1);

namespace Local\Driver\Win32\WebView2;

use FFI\CData;
use Local\Driver\Win32\Exception\WebView2NotAvailableException;
use Local\Driver\Win32\Lib\Advapi32;

final readonly class InstallationDetector
{
    /**
     * Contains registry key for WebView2 runtime.
     *
     * ```
     *  ((HKEY)(LONG_PTR)(LONG)0x80000002)
     * ```
     */
    private const int HKEY_LOCAL_MACHINE = 0xFFFFFFFF << 32 | 0x80000002;

    /**
     * ```
     * KEY_READ = ( STANDARD_RIGHTS_READ
     *            | KEY_QUERY_VALUE
     *            | KEY_ENUMERATE_SUB_KEYS
     *            | KEY_NOTIFY )
     *      & ~SYNCHRONIZE
     * ```
     */
    private const int KEY_READ = 0x20019;

    /**
     * Contains registry path for x86 WebView2 runtime.
     *
     * @var non-empty-string
     */
    private const string WEBVIEW2_RUNTIME_REG_KEY = 'SOFTWARE\Microsoft\EdgeUpdate\Clients\{F3017226-FE2A-4295-8BDF-00C3A9A7E4C5}';

    /**
     * Contains registry path for x64 WebView2 runtime.
     *
     * @var non-empty-string
     */
    private const string WEBVIEW2_RUNTIME_REG64_KEY = 'SOFTWARE\WOW6432Node\Microsoft\EdgeUpdate\Clients\{F3017226-FE2A-4295-8BDF-00C3A9A7E4C5}';

    private CData $hKey;

    public function __construct(
        private Advapi32 $advapi32,
    ) {
        // @phpstan-ignore-next-line
        $this->hKey = $this->advapi32->cast('HKEY', self::HKEY_LOCAL_MACHINE);
    }

    /**
     * Returns error {@see int} code of the registry opening status by the
     * given key and path or {@see 0} in case of success.
     */
    private function open(string $path): int
    {
        $hKey = $this->advapi32->new('HKEY');

        if ($hKey === null) {
            throw new \RuntimeException('Could not allocate HKEY');
        }

        return $this->advapi32->RegOpenKeyExA(
            $this->hKey,
            $path,
            0,
            self::KEY_READ,
            \FFI::addr($hKey),
        );
    }

    /**
     * Returns {@see true} in case of given path contains in the
     * given registry key or {@see false} otherwise.
     */
    private function has(string $path): bool
    {
        return $this->open($path) === 0;
    }

    /**
     * Returns {@see true} in case of WebView2 (x86) is
     * installed or {@see false} otherwise.
     */
    public function isInstalled32bit(): bool
    {
        return $this->has(self::WEBVIEW2_RUNTIME_REG_KEY);
    }

    /**
     * Returns {@see true} in case of WebView2 (x64) is
     * installed or {@see false} otherwise.
     */
    public function isInstalled64bit(): bool
    {
        return $this->has(self::WEBVIEW2_RUNTIME_REG64_KEY);
    }

    /**
     * Returns {@see true} in case of WebView2 is
     * installed or {@see false} otherwise.
     */
    public function isInstalled(): bool
    {
        return $this->isInstalled32bit() || $this->isInstalled64bit();
    }

    /**
     * Determines whether WebView2 is installed or throws an
     * {@see WebView2NotAvailableException} exception instead.
     *
     * @throws WebView2NotAvailableException
     */
    public function assertIsInstalledOrFail(): void
    {
        if (!$this->isInstalled()) {
            throw WebView2NotAvailableException::createWithMessage(
                <<<'MESSAGE'
                Please download WebView2 runtime using following link:
                https://developer.microsoft.com/en-us/microsoft-edge/webview2?form=MA13LH#download-section
                MESSAGE
            );
        }
    }
}
