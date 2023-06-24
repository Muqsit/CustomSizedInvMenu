# CustomSizedInvMenu
To be able to build custom-sized `InvMenu` instances, you must install the [tedo0627/InventoryUIResourcePack](https://github.com/tedo0627/InventoryUIResourcePack) resource pack on your server.

### Example API Usage
To build a 5-slot InvMenu, use `CustomSizedInvMenu::create(5)`:
```php
/** @var Player $player */
$menu = CustomSizedInvMenu::create(5);
$menu->setName("This is a 5-slot Inventory");
$menu->send($player);
```

### Example Command Usage
Run `/cinvmenu <numSlots> [title]` to open an InvMneu of `numSlots` number of slots:
- `/cinvmenu 36 "36-slot Inventory"`

  ![image](https://github.com/Muqsit/CustomSizedInvMenu/assets/15074389/721ee351-3247-4b37-8a42-da04851d66cb)

- `/cinvmenu 59 "59-slot Inventory"`

  ![image](https://github.com/Muqsit/CustomSizedInvMenu/assets/15074389/602e2fdc-b675-4b7f-9e2e-b76c700c64a3)


### Resources
- [tedo0627/InventoryUI](https://github.com/tedo0627/InventoryUI)
- [tedo0627/InventoryUIResourcePack](https://github.com/tedo0627/InventoryUIResourcePack)
