<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\WebView;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson
 */
enum Architecture
{
    case Amd64;
    case Arm64;
    case Unknown;

    /**
     * @var array<non-empty-string, self>
     */
    private const array UNAME_MAPPINGS = [
        'AMD64' => self::Amd64,
        'amd64' => self::Amd64,
        'x86' => self::Amd64,
        'x64' => self::Amd64,
        'x86_64' => self::Amd64,
        'arm64' => self::Arm64,
        'aarch64' => self::Arm64,
    ];

    /**
     * @var list<non-empty-string>
     */
    private const array UNAME_ENV_DEFS = [
        'BOSON_CPU_ARCH',
        'PROCESSOR_ARCHITECTURE',
    ];

    /**
     * @return non-empty-string
     */
    private static function getArchitectureStringFromEnvironment(): string
    {
        foreach (self::UNAME_ENV_DEFS as $env) {
            if (isset($_SERVER[$env]) && \is_string($_SERVER[$env]) && $_SERVER[$env] !== '') {
                return $_SERVER[$env];
            }
        }

        /** @var non-empty-string */
        return \php_uname('m');
    }

    public static function fromEnvironment(): self
    {
        $uname = self::getArchitectureStringFromEnvironment();

        if (isset(self::UNAME_MAPPINGS[$uname])) {
            return self::UNAME_MAPPINGS[$uname];
        }

        return self::Unknown;
    }
}
