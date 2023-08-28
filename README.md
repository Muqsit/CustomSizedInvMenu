# CustomSizedInvMenu
To be able to build custom-sized `InvMenu` instances, you must install the [tedo0627/InventoryUIResourcePack](https://github.com/tedo0627/InventoryUIResourcePack) resource pack on your server.

A custom-sized InvMenu provides several advantages over traditional ways of displaying menus (`InvMenu::TYPE_CHEST`, `InvMenu::TYPE_DOUBLE_CHEST`):
1. **Dynamic:** To create a menu that can hold `n` items, you need not know the size of a chest or a double chest inventory. Instead, simply create a menu of the preferred size: `CustomSizedInvMenu::create(n)`.
2. **Block-less:** Backed by an invisible entity, this menu does not require rendering a chest block strategically placed behind a player. Besides, rendering a chest block opens the server to an exploit where players can 'levitate' in the air by standing onto a fake chest block.
3. **More Portable:** Backed by an invisible entity, this menu can be sent to players anywhere, regardless of their Y-axis position. Block-backed menus can only be sent when the player's Y value falls within the world's minimum and maximum block height (because blocks cannot be set outside world bounds).
4. **Low Latency:** CustomSizedInvMenu renders right away, no delay necessary. On the other hand, `InvMenu::TYPE_DOUBLE_CHEST` is notoriously slow due to a 'delay' that is necessary to let the game render 'two individual chests transforming into a double chest'.

### Example API Usage
To build a 5-slot InvMenu, use `CustomSizedInvMenu::create(5)`:
```php
/** @var Player $player */
$menu = CustomSizedInvMenu::create(5);
$menu->setName("This is a 5-slot Inventory");
$menu->send($player);
```

### Example Command Usage
Run `/cinvmenu <numSlots> [title]` to open an InvMenu of `numSlots` number of slots:
- `/cinvmenu 36 "36-slot Inventory"`

  ![image](https://github.com/Muqsit/CustomSizedInvMenu/assets/15074389/721ee351-3247-4b37-8a42-da04851d66cb)

- `/cinvmenu 59 "59-slot Inventory"`

  ![image](https://github.com/Muqsit/CustomSizedInvMenu/assets/15074389/602e2fdc-b675-4b7f-9e2e-b76c700c64a3)


### Resources
- [tedo0627/InventoryUI](https://github.com/tedo0627/InventoryUI)
- [tedo0627/InventoryUIResourcePack](https://github.com/tedo0627/InventoryUIResourcePack)
