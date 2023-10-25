<?php

declare(strict_types=1);

namespace muqsit\customsizedinvmenu;

use muqsit\invmenu\type\graphic\InvMenuGraphic;
use muqsit\invmenu\type\graphic\network\InvMenuGraphicNetworkTranslator;
use pocketmine\inventory\Inventory;
use pocketmine\player\Player;

final class CustomSizedActorInvMenuGraphic implements InvMenuGraphic{

	readonly private string $size_data;

	public function __construct(
		readonly private InvMenuGraphic $inner,
		readonly private ?string $name,
		readonly private int $length,
		readonly private bool $scrollbar
	){
		$scroll = (int) $this->scrollbar;
		$this->size_data = "§{$this->length}§{$scroll}§r§r§r§r§r§r§r§r§r§r";
	}

	public function send(Player $player, ?string $name) : void{
		$this->inner->send($player, $this->size_data . ($name ?? $this->name ?? "Inventory"));
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