<?php

declare(strict_types=1);

namespace Elewant\Domain;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class HerdId
{
    /**
     * @var Uuid
     */
    private $uuid;

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function generate(): self
    {
        return new self (Uuid::uuid4());
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
