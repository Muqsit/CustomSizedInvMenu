<?php

declare(strict_types=1);

namespace muqsit\customsizedinvmenu;

use muqsit\invmenu\inventory\InvMenuInventory;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\type\graphic\ActorInvMenuGraphic;
use muqsit\invmenu\type\graphic\InvMenuGraphic;
use muqsit\invmenu\type\graphic\network\ActorInvMenuGraphicNetworkTranslator;
use muqsit\invmenu\type\InvMenuType;
use pocketmine\entity\Entity;
use pocketmine\inventory\Inventory;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataCollection;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataProperties;
use pocketmine\network\mcpe\protocol\types\entity\MetadataProperty;
use pocketmine\network\mcpe\protocol\types\inventory\WindowTypes;
use pocketmine\player\Player;
use function intdiv;
use function min;

final class CustomSizedInvMenuType implements InvMenuType{

	public static function ofSize(int $size) : self{
		$length = intdiv($size, 9) + ($size % 9 === 0 ? 0 : 1);
		$length = min($length, 6);
		return new self($size, $length);
	}

	readonly private int $actor_runtime_identifier;
	readonly private ActorInvMenuGraphicNetworkTranslator $network_translator;

	/** @var array<int, MetadataProperty> */
	readonly private array $actor_metadata;

	public function __construct(
		readonly private int $size,
		readonly private int $length
	){
		$this->actor_runtime_identifier = Entity::nextRuntimeId();
		$this->network_translator = new ActorInvMenuGraphicNetworkTranslator($this->actor_runtime_identifier);

		$properties = new EntityMetadataCollection();
		$properties->setByte(EntityMetadataProperties::CONTAINER_TYPE, WindowTypes::INVENTORY);
		$properties->setInt(EntityMetadataProperties::CONTAINER_BASE_SIZE, $this->size);
		$this->actor_metadata = $properties->getAll();
	}

	public function createGraphic(InvMenu $menu, Player $player) : ?InvMenuGraphic{
		return new CustomSizedActorInvMenuGraphic(
			new ActorInvMenuGraphic("inventoryui:inventoryui", $this->actor_runtime_identifier, $this->actor_metadata, $this->network_translator),
			$menu->getName(),
			$this->length
		);
	}

	public function createInventory() : Inventory{
		return new InvMenuInventory($this->size);
	}
}