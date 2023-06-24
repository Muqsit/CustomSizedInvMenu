<?php

declare(strict_types=1);

namespace muqsit\customsizedinvmenu;

use muqsit\invmenu\type\graphic\InvMenuGraphic;
use muqsit\invmenu\type\graphic\network\InvMenuGraphicNetworkTranslator;
use pocketmine\inventory\Inventory;
use pocketmine\player\Player;

final class CustomSizedActorInvMenuGraphic implements InvMenuGraphic{

	public function __construct(
		readonly private InvMenuGraphic $inner,
		readonly private ?string $name,
		readonly private int $length
	){}

	public function send(Player $player, ?string $name) : void{
		$this->inner->send($player, "§{$this->length}§r§r§r§r§r§r§r§r§r§r" . ($name ?? $this->name ?? "Inventory"));
	}

	public function sendInventory(Player $player, Inventory $inventory) : bool{
		return $this->inner->sendInventory($player, $inventory);
	}

	public function remove(Player $player) : void{
		$this->inner->remove($player);
	}

	public function getNetworkTranslator() : ?InvMenuGraphicNetworkTranslator{
		return $this->inner->getNetworkTranslator();
	}

	public function getAnimationDuration() : int{
		return $this->inner->getAnimationDuration();
	}
}