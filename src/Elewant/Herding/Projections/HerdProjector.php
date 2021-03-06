<?php

declare(strict_types=1);

namespace Elewant\Herding\Projections;

use Doctrine\DBAL\Connection;
use Elewant\Herding\Model\Events\ElePHPantWasAbandonedByHerd;
use Elewant\Herding\Model\Events\ElePHPantWasAdoptedByHerd;
use Elewant\Herding\Model\Events\HerdWasAbandoned;
use Elewant\Herding\Model\Events\HerdWasFormed;
use Elewant\Herding\Model\Events\HerdWasRenamed;

final class HerdProjector
{
    const TABLE_HERD      = 'herd';
    const TABLE_ELEPHPANT = 'elephpant';

    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function onHerdWasFormed(HerdWasFormed $event)
    {
        $this->connection->insert(
            self::TABLE_HERD,
            [
                'herd_id'     => $event->herdId()->toString(),
                'shepherd_id' => $event->shepherdId()->toString(),
                'name'        => $event->name(),
                'formed_on'   => $event->createdAt()->format('Y-m-d H:i:s'),
            ]
        );
    }

    public function onHerdWasRenamed(HerdWasRenamed $event)
    {
        $this->connection->update(
            self::TABLE_HERD,
            [
                'name' => $event->newHerdName(),
            ],
            [
                'herd_id' => $event->herdId()->toString(),
            ]
        );
    }

    public function onElePHPantWasAdoptedByHerd(ElePHPantWasAdoptedByHerd $event)
    {
        $this->connection->insert(
            self::TABLE_ELEPHPANT,
            [
                'elephpant_id' => $event->elePHPantId()->toString(),
                'herd_id'      => $event->herdId()->toString(),
                'breed'        => $event->breed()->toString(),
                'adopted_on'   => $event->createdAt()->format('Y-m-d H:i:s'),
            ]
        );
    }

    public function onElePHPantWasAbandonedByHerd(ElePHPantWasAbandonedByHerd $event)
    {
        $this->connection->delete(
            self::TABLE_ELEPHPANT,
            [
                'elephpant_id' => $event->elePHPantId()->toString(),
            ]
        );
    }

    public function onHerdWasAbandoned(HerdWasAbandoned $event)
    {
        $this->connection->delete(
            self::TABLE_ELEPHPANT,
            [
                'herd_id' => $event->herdId()->toString(),
            ]
        );

        $this->connection->delete(
            self::TABLE_HERD,
            [
                'herd_id' => $event->herdId()->toString(),
            ]
        );
    }


    public function clearAllTables()
    {
        $platform = $this->connection->getDatabasePlatform();

        $this->connection->query('SET FOREIGN_KEY_CHECKS=0');
        $this->connection->executeUpdate($platform->getTruncateTableSQL(self::TABLE_HERD));
        $this->connection->executeUpdate($platform->getTruncateTableSQL(self::TABLE_ELEPHPANT));
        $this->connection->query('SET FOREIGN_KEY_CHECKS=1');
    }
}
