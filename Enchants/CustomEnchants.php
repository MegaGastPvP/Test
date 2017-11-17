<?php
namespace ImagicalGamer\CustomEnchants;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;

use pocketmine\utils\TextFormat;

use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;

/* Copyright (C) ImagicalGamer - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Jake C <imagicalgamer@outlook.com>, March 2017
 */

class CustomEnchants extends PluginBase{

  protected $enchantments = [];

  public $data = ["movetime" => []];

  public $ores = [
  14,
  15,
  16,
  73,
  56
  ];

  public $ingot = [
  14 => 266,
  15 => 265,
  16 => 263,
  73 => 331,
  65 => 264
  ];

  public function onEnable()
  {
    $this->getServer()->getPluginManager()->registerEvents((new EventListener($this)), $this);
    $this->enchantments = [
    25 => "Lifesteal", 
    26 => "Blind", 
    27 => "Deathbringer", 
    28 => "Gooey", 
    29 => "Poison", 
    30 => "Block", //not implemented
    31 => "Ice Aspect", 
    32 => "Shockwave",  
    33 => "Autorepair", //not implemented
    34 => "Crippling Strike", 
    35 => "Thundering Blow", 
    36 => "Vampire", 
    37 => "Deep Wounds", 
    38 => "Charge", 
    39 => "Aerial", 
    40 => "Wither", 
    41 => "Headless", //not implemented
    42 => "Disarming", 
    43 => "Explosive", //not implemented
    44 => "Smelting", 
    45 => "Quickening", 
    46 => "Paralyze", 
    47 => "Molotov", 
    48 => "Volley", 
    49 => "Piercing", 
    50 => "Shuffle", 
    51 => "Healing", 
    52 => "Blaze", //not implemented
    53 => "Molten", 
    54 => "Enlighten", 
    55 => "Hardened", 
    56 => "Poisoned", 
    57 => "Frozen", 
    58 => "Obsidian Shield", 
    59 => "Shielded", 
    60 => "Cursed", 
    61 => "Endershift", 
    62 => "Beserker", 
    63 => "Gears", 
    64 => "Springs", 
    65 => "Stomp", 
    66 => "Implants", 
    67 => "Glowing" //not implemented
    ];
    $this->startup();
  }

  public function startup()
  {
    Enchantment::registerEnchantment(25, "Lifesteal", 3, 1, Enchantment::SLOT_SWORD);
    Enchantment::registerEnchantment(26, "Blind", 3, 1, Enchantment::SLOT_SWORD);
    Enchantment::registerEnchantment(27, "Deathbringer", 1, 1, Enchantment::SLOT_SWORD);
    Enchantment::registerEnchantment(28, "Gooey", 3, 1, Enchantment::SLOT_AXE);
    Enchantment::registerEnchantment(29, "Poison", 3, 1, Enchantment::SLOT_SWORD);
    //Enchantment::registerEnchantment(30, "Block", 3, 1, Enchantment::SLOT_SWORD);
    Enchantment::registerEnchantment(31, "Ice Aspect", 3, 1, Enchantment::SLOT_SWORD);
    Enchantment::registerEnchantment(32, "Shockwave", 3, 1, Enchantment::SLOT_SHOVEL);
    Enchantment::registerEnchantment(33, "Autorepair", 3, 1, Enchantment::SLOT_SWORD);
    Enchantment::registerEnchantment(34, "Crippling Strike", 3, 1, Enchantment::SLOT_SWORD);
    Enchantment::registerEnchantment(35, "Thundering Blow", 3, 1, Enchantment::SLOT_SWORD);
    Enchantment::registerEnchantment(36, "Vampire", 3, 1, Enchantment::SLOT_SWORD);
    Enchantment::registerEnchantment(37, "Deep Wounds", 3, 1, Enchantment::SLOT_SWORD);
    Enchantment::registerEnchantment(38, "Charge", 3, 1, Enchantment::SLOT_SWORD);
    Enchantment::registerEnchantment(39, "Aerial", 3, 1, Enchantment::SLOT_SWORD);
    Enchantment::registerEnchantment(40, "Wither", 3, 1, Enchantment::SLOT_SWORD);
    Enchantment::registerEnchantment(41, "Headless", 3, 1, Enchantment::SLOT_SWORD);
    Enchantment::registerEnchantment(42, "Disarming", 3, 1, Enchantment::SLOT_SWORD);
    Enchantment::registerEnchantment(43, "Explosive", 3, 1, Enchantment::SLOT_PICKAXE);
    Enchantment::registerEnchantment(44, "Smelting", 3, 1, Enchantment::SLOT_PICKAXE);
    Enchantment::registerEnchantment(45, "Quickening", 3, 1, Enchantment::SLOT_PICKAXE);
    Enchantment::registerEnchantment(46, "Paralyze", 3, 1, Enchantment::SLOT_BOW);
    Enchantment::registerEnchantment(47, "Molotov", 3, 1, Enchantment::SLOT_BOW);
    Enchantment::registerEnchantment(48, "Volley", 3, 1, Enchantment::SLOT_BOW);
    Enchantment::registerEnchantment(49, "Piercing", 3, 1, Enchantment::SLOT_BOW);
    Enchantment::registerEnchantment(50, "Shuffle", 3, 1, Enchantment::SLOT_BOW);
    Enchantment::registerEnchantment(51, "Healing", 3, 1, Enchantment::SLOT_BOW);
    Enchantment::registerEnchantment(52, "Blaze", 3, 1, Enchantment::SLOT_BOW);
    Enchantment::registerEnchantment(53, "Molten", 3, 1, Enchantment::SLOT_ARMOR);
    Enchantment::registerEnchantment(54, "Enlighten", 3, 1, Enchantment::SLOT_ARMOR);
    Enchantment::registerEnchantment(55, "Hardened", 3, 1, Enchantment::SLOT_ARMOR);
    Enchantment::registerEnchantment(56, "Poisoned", 3, 1, Enchantment::SLOT_ARMOR);
    Enchantment::registerEnchantment(57, "Frozen", 3, 1, Enchantment::SLOT_ARMOR);
    Enchantment::registerEnchantment(58, "Obsidian Shield", 3, 1, Enchantment::SLOT_ARMOR);
    Enchantment::registerEnchantment(59, "Shielded", 3, 1, Enchantment::SLOT_ARMOR);
    Enchantment::registerEnchantment(60, "Cursed", 3, 1, Enchantment::SLOT_ARMOR);
    Enchantment::registerEnchantment(61, "Endershift", 3, 1, Enchantment::SLOT_ARMOR);
    Enchantment::registerEnchantment(62, "Beserker", 3, 1, Enchantment::SLOT_ARMOR);
    Enchantment::registerEnchantment(63, "Gears", 3, 1, Enchantment::SLOT_FEET);
    Enchantment::registerEnchantment(64, "Springs", 3, 1, Enchantment::SLOT_FEET);
    Enchantment::registerEnchantment(65, "Stomp", 3, 1, Enchantment::SLOT_FEET);
    Enchantment::registerEnchantment(66, "Implants", 3, 1, Enchantment::SLOT_HEAD);
    Enchantment::registerEnchantment(66, "Glowing", 3, 1, Enchantment::SLOT_HEAD);
  }

  public function getStringLevel(Enchantment $ench) : String
  { 
    $integer = (int) $ench->getLevel();
    $table = array('M'=> 1000, 'CM'=> 900, 'D'=> 500, 'CD'=> 400, 'C'=> 100, 'XC'=> 90, 'L'=> 50, 'XL'=> 40, 'X'=> 10, 'IX'=> 9, 'V'=> 5, 'IV'=> 4, 'I'=> 1); 
    $return = ''; 
    while($integer > 0) 
    { 
      foreach($table as $rom=>$arb) 
      { 
        if($integer >= $arb) 
        { 
          $integer -= $arb; 
          $return .= $rom; 
          break; 
        } 
      }
    }  
    return $return;
  } 

  public function getEnchantmentName(int $id) : String
  {
    if($id < 25)
    {
      return false;
    }
    if(isset($this->enchantments[$id]))
    {
      return $this->enchantments[$id];
    }
  }

  public function setEnchantmentNames(Item $it) : Item
  {
    $i = Item::get($it->getId(), 0, 1);
    $nwit = clone $i;
    $nwit->setCustomName(TextFormat::RESET . TextFormat::RESET . TextFormat::RED . $i->getName() . "\n" . TextFormat::GRAY);
    foreach($it->getEnchantments() as $enchant)
    {
      if($enchant->getId() < 25)
      {
        continue;
      }
      $nwit->setCustomName($nwit->getCustomName() . TextFormat::GRAY . $this->getEnchantmentName($enchant->getId()) . " " . (string) $this->getStringLevel($enchant) . "\n");
      $nwit->setCustomName(str_replace("\n\n", "\n", $nwit->getCustomName()));
      continue;
    }
    foreach($it->getEnchantments() as $ench)
    {
      $ench->setLevel($ench->getLevel());
      $nwit->addEnchantment($ench);
      continue;
    }
    return $nwit;
  }
}