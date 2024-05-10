<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\WebView2;

use Serafim\WinUI\Driver\Win32\Lib\Advapi32;
use Serafim\WinUI\Driver\Win32\Lib\HKey;
use Serafim\WinUI\Driver\Win32\Lib\Key;
use Serafim\WinUI\Exception\WebView2NotAvailable;

final readonly class InstallationDetector
{
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

    private Advapi32 $advapi32;

    public function __construct(
        ?Advapi32 $advapi32 = null,
    ) {
        $this->advapi32 = $advapi32 ?? Advapi32::getInstance();
    }

    /**
     * Returns error {@see int} code of the registry opening status by the
     * given key and path or {@see 0} in case of success.
     */
    private function open(HKey $key, string $path): int
    {
        $hKey = $this->advapi32->new('HKEY');

        if ($hKey === null) {
            throw new \RuntimeException('Could not allocate HKEY');
        }

        return $this->advapi32->RegOpenKeyExA(
            $key->toCData(),
            $path,
            0,
            Key::KEY_READ,
            \FFI::addr($hKey),
        );
    }

    /**
     * Returns {@see true} in case of given path contains in the
     * given registry key or {@see false} otherwise.
     */
    private function has(HKey $key, string $path): bool
    {
        return $this->open($key, $path) === 0;
    }

    /**
     * Returns {@see true} in case of WebView2 (x86) is
     * installed or {@see false} otherwise.
     */
    public function isInstalled32bit(): bool
    {
        return $this->has(HKey::HKEY_LOCAL_MACHINE, self::WEBVIEW2_RUNTIME_REG_KEY);
    }

    /**
     * Returns {@see true} in case of WebView2 (x64) is
     * installed or {@see false} otherwise.
     */
    public function isInstalled64bit(): bool
    {
        return $this->has(HKey::HKEY_LOCAL_MACHINE, self::WEBVIEW2_RUNTIME_REG64_KEY);
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
     * {@see WebView2NotAvailable} exception instead.
     *
     * @throws WebView2NotAvailable
     */
    public function assertIsInstalledOrFail(): void
    {
        if (!$this->isInstalled()) {
            throw WebView2NotAvailable::createWithMessage(
                <<<'MESSAGE'
                Please download WebView2 runtime using following link:
                https://developer.microsoft.com/en-us/microsoft-edge/webview2?form=MA13LH#download-section
                MESSAGE
            );
        }
    }
}
