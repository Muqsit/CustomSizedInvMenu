<?php

declare(strict_types=1);

namespace muqsit\customsizedinvmenu;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\cache\StaticPacketCache;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use RuntimeException;
use function array_rand;
use function assert;
use function is_numeric;

final class CustomSizedInvMenu extends PluginBase{

	private const RESOURCE_PACK_ID = "21f0427f-572a-416d-a90e-c5d9becb0fa3";
	private const TYPE_DYNAMIC_PREFIX = "muqsit:customsizedinvmenu_";

	public static function create(int $size) : InvMenu{
		static $ids_by_size = [];
		if(!isset($ids_by_size[$size])){
			$id = self::TYPE_DYNAMIC_PREFIX . $size;
			InvMenuHandler::getTypeRegistry()->register($id, CustomSizedInvMenuType::ofSize($size));
			$ids_by_size[$size] = $id;
		}
		return InvMenu::create($ids_by_size[$size]);
	}

	protected function onEnable() : void{
		if($this->getServer()->getResourcePackManager()->getPackById(self::RESOURCE_PACK_ID) === null){
			$this->getLogger()->warning("Resource pack 'Inventory UI Resource Pack' could not be found.");
			$this->getLogger()->warning("This plugin cannot be loaded. Please download the resource pack from: https://github.com/tedo0627/InventoryUIResourcePack");
			throw new RuntimeException("Resource pack 'Inventory UI Resource Pack' has not been loaded");
		}

		if(!InvMenuHandler::isRegistered()){
			InvMenuHandler::register($this);
		}

		$packet = StaticPacketCache::getInstance()->getAvailableActorIdentifiers();
		$tag = $packet->identifiers->getRoot();
		assert($tag instanceof CompoundTag);
		$id_list = $tag->getListTag("idlist");
		assert($id_list !== null);
		$id_list->push(CompoundTag::create()
			->setString("bid", "")
			->setByte("hasspawnegg", 0)
			->setString("id", CustomSizedInvMenuType::ACTOR_NETWORK_ID)
			->setByte("summonable", 0)
		);
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		if(!($sender instanceof Player)){
			$sender->sendMessage(TextFormat::RED . "Please use this command in-game.");
			return true;
		}

		if(!isset($args[0]) || !is_numeric($args[0]) || (int) $args[0] <= 0){
			$sender->sendMessage(TextFormat::RED . "/" . $command . " <numSlots : int> [title : string]");
			return true;
		}

		$menu = CustomSizedInvMenu::create((int) $args[0]);
		$menu->setName($args[1] ?? null);

		$items = VanillaItems::getAll();
		for($i = 0, $max = $menu->getInventory()->getSize(); $i < $max; $i++){
			$menu->getInventory()->setItem($i, $items[array_rand($items)]);
		}

		$menu->send($sender);
		return true;
	}
}