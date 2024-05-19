<?php

declare(strict_types=1);

namespace Serafim\Boson\Exception;

final class WebView2NotAvailableException extends UserInterfaceException
{
    private ?string $suffix = null;

    public static function createWithMessage(string $message): self
    {
        $instance = new self('WebView is not available');
        $instance->suffix = $message;

        return $instance;
    }

    public function __toString(): string
    {
        $message = $this->message;

        if ($this->suffix !== null) {
            $this->message = "$message.\n$this->suffix";
        }

        $result = parent::__toString();

        $this->message = $message;

        return $result;
    }
}
