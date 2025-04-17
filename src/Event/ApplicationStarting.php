<?php

declare(strict_types=1);

namespace Serafim\Boson\Event;

use Serafim\Boson\Shared\Marker\AsApplicationEvent;

#[AsApplicationEvent]
final class ApplicationStarting extends ApplicationIntention {}
