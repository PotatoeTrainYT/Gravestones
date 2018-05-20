<?php

declare(strict_types=1);

namespace Gravestones;

use pocketmine\entity\Human;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\Player;
use pocketmine\utils\Config;

class Gravestone extends Human{

    /**
     * Gravestone constructor
     *
     * @param Level       $level
     * @param CompoundTag $nbt
     * @param Player|null $player
     * @param Item[]      $drops
     */
    public function __construct(Level $level, CompoundTag $nbt, Player $player = null, array $drops){
        $nbt = new CompoundTag("", [
            new ListTag("Pos", [
                new DoubleTag("", $player->getX()),
                new DoubleTag("", $player->getY() - 1),
                new DoubleTag("", $player->getZ())
            ]),
            new ListTag("Motion", [
                new DoubleTag("", 0),
                new DoubleTag("", 0),
                new DoubleTag("", 0)
            ]),
            new ListTag("Rotation", [
                new FloatTag("", 2),
                new FloatTag("", 2)
            ])
        ]);
        $nbt->setTag($player->namedtag->getTag("Skin"));
        parent::__construct($level, $nbt);
        $this->getDataPropertyManager()->setBlockPos(Human::DATA_PLAYER_BED_POSITION, new Vector3($player->getX(), $player->getY(), $player->getZ()));
        $this->setPlayerFlag(Human::DATA_PLAYER_FLAG_SLEEP, true);
        $this->setHealth(1);
        $this->getInventory()->setContents($drops);
    }
}