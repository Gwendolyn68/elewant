<?php

declare(strict_types=1);

namespace Elewant\Herding\Model;

use Rhumsaa\Uuid\Uuid;

final class ElePHPantId
{
    /**
     * @var Uuid
     */
    private $uuid;

    private function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $elePHPantId): self
    {
        return new self(Uuid::fromString($elePHPantId));
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals($other): bool
    {
        return ($other instanceof static && $other->uuid->equals($this->uuid));
    }
}
