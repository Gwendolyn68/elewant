<?php

declare(strict_types=1);

namespace Elewant\Herding\Model;

use Rhumsaa\Uuid\Uuid;

final class ShepherdId
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

    public static function fromString(string $shepherdId): self
    {
        return new self(Uuid::fromString($shepherdId));
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
