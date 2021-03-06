<?php

declare(strict_types=1);

namespace Elewant\Herding\Model;

use Rhumsaa\Uuid\Uuid;

final class HerdId
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

    public static function fromString(string $herdId): self
    {
        return new self(UUid::fromString($herdId));
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
