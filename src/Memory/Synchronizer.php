<?php

declare(strict_types=1);

namespace Serafim\WinUI\Memory;

final class Synchronizer
{
    /**
     * @template TResult of mixed
     * @template TError of mixed
     *
     * @param TResult|null $ptr
     * @param callable():TError $onError
     * @return TResult|TError
     */
    public static function wait(mixed &$ptr, callable $onError): mixed
    {
        $time = \microtime(true);

        while (true) {
            if ($ptr !== null) {
                return $ptr;
            }

            \usleep(100);

            if ((\microtime(true) - $time) > 1.0) {
                return $onError();
            }
        }
    }
}
