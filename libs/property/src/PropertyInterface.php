<?php

declare(strict_types=1);

namespace Local\Property;

/**
 * @template TRead of mixed
 * @template TWrite of mixed
 *
 * @template-extends ReadablePropertyInterface<TRead>
 * @template-extends WritablePropertyInterface<TWrite>
 */
interface PropertyInterface extends
    ReadablePropertyInterface,
    WritablePropertyInterface {}
