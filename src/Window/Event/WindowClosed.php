<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Event;

use Serafim\Boson\Shared\Marker\AsWindowEvent;

#[AsWindowEvent]
final class WindowClosed extends WindowEvent {}
