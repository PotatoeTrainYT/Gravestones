<?php

declare(strict_types=1);

namespace Gravestones;

use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\Listener;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{

    public function onEnable(): void{
        Entity::registerEntity(Gravestone::class, true);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onDeath(EntityDeathEvent $event): void{
        $entity = $event->getEntity();
        if($entity instanceof Player){
            Entity::createEntity("Gravestone", $entity->getLevel(), new CompoundTag(), $entity, $event->getDrops())->spawnToAll();
            $event->setDrops([]);
        }
    }
}