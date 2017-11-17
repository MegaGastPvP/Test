<?php
namespace ImagicalGamer\CustomEnchants;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\event\Listener;

use pocketmine\item\Item;
use pocketmine\item\DiamondSword;
use pocketmine\item\IronAxe;
use pocketmine\item\Bow;
use pocketmine\item\Tool;

use pocketmine\entity\Entity;
use pocketmine\entity\Arrow;
use pocketmine\entity\Effect;
use pocketmine\entity\Projectile;

use pocketmine\block\Block;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerMoveEvent;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageByChildEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityShootBowEvent;

use pocketmine\event\block\BlockBreakEvent;

use pocketmine\level\Level;
use pocketmine\level\Position;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ShortTag;

/* Copyright (C) ImagicalGamer - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Jake C <imagicalgamer@outlook.com>, March 2017
 */

class EventListener implements Listener{

  public function __construct(CustomEnchants $plugin)
  {
    $this->plugin = $plugin;
  }

  public function onEntityDamage(EntityDamageEvent $ev)
  {
    if($ev->isCancelled())
    {
      return false;
    }
    if($ev instanceof EntityDamageByEntityEvent)
    {
      if(($dm = $ev->getDamager()) && $dm instanceof Player && ($p = $ev->getEntity()) && $p instanceof Player)
      {
        if($this->isFactionsLoaded($this->plugin->getServer(), "FactionsPro"))
        {
          $fac = $this->plugin->getServer()->getPluginManager()->getPlugin("FactionsPro");
          if($fac->sameFaction($p->getName(), $dm->getName()) == true or $fac->areAllies($p->getName(), $dm->getName()) == true)
          {
            $ev->setCancelled(true);
            return false;
          }
        }
        if(($item = $dm->getInventory()->getItemInHand()) && ($item instanceof Bow || $item instanceof DiamondSword || $item instanceof IronAxe) && $item->hasEnchantments())
        {
          foreach($item->getEnchantments() as $ench)
          {
            switch($ench->getId())
            {
              case 25:
                $dm->setHealth($dm->getHealth() + 1);
              break;
              case 26:
                $p->addEffect(Effect::getEffect(Effect::BLINDNESS)->setAmplifier(($ench->getLevel() / 1) * 10)->setDuration(($ench->getLevel() * 2)* 20));
              break;
              case 27:
                $ev->setDamage($ev->getDamage() * 1.2);
              break;
              case 28:
                if($item instanceof IronAxe)
                {
                  $ev->setKnockBack($ench->getLevel() * 1.2);
                }
              break;
              case 29:
                $p->addEffect(Effect::getEffect(Effect::POISON)->setAmplifier(($ench->getLevel() / 0.75) * 8)->setDuration(($ench->getLevel() * 3)* 15));
              break;
              case 31:
                $p->addEffect(Effect::getEffect(Effect::SLOWNESS)->setAmplifier(($ench->getLevel() / 1) * 8)->setDuration(($ench->getLevel() * 2)* 15));
              break;
              case 34:
                $p->addEffect(Effect::getEffect(Effect::SLOWNESS)->setAmplifier(($ench->getLevel() / 2) * 8)->setDuration(($ench->getLevel() * 2)* 15));
                $p->addEffect(Effect::getEffect(Effect::WEAKNESS)->setAmplifier(($ench->getLevel() / 2) * 8)->setDuration(($ench->getLevel() * 2)* 15));
              break;
              case 36:
                $dm->setHealth($dm->getHealth() + ($ev->getDamage() / 4));
              break;
              case 37:
                $p->addEffect(Effect::getEffect(Effect::HARMING)->setAmplifier(($ench->getLevel()) / 2)->setDuration(($ench->getLevel())* 15));
              break;
              case 38:
                $end = microtime();
                $start = $this->plugin->data["movetime"][$dm->getName()];
                $tt = number_format($end - $start, 3);
                if($tt <= 2)
                {
                  $dm->addEffect(Effect::getEffect(Effect::STRENGTH)->setAmplifier(($ench->getLevel() / 2) * 3)->setDuration(($ench->getLevel() * 2) * 20));
                  $ev->setDamage($ev->getDamage() * 0.4);
                }  
              break;
              case 39:
                $pos1 = $p->getY();
                $pos2 = $dm->getY();
                $hb = $dm->getLevel()->getHighestBlockAt($dm->getX(), $dm->getZ());
                if(($pos2 > $pos1) or (($hb + 2 ) < $pos2))
                {
                  $dm->addEffect(Effect::getEffect(Effect::STRENGTH)->setAmplifier(($ench->getLevel() / 2) * 3)->setDuration(($ench->getLevel() * 2) * 20));
                  $ev->setDamage($ev->getDamage() * 0.4);
                }
              case 40:
                $p->addEffect(Effect::getEffect(Effect::WITHER)->setAmplifier(($ench->getLevel() * 0.75) * 5)->setDuration(($ench->getLevel() * 3) * 20));
              break;
              case 42:
                $i = clone $p->getInventory()->getItemInHand();
                $p->getInventory()->setItemInHand(Item::get(0, 0, 0));
                $p->getInventory()->addItem($i);
                $p->getInventory()->sendContents($p);
                $p->sendPopup("YOU HAVE BEEN DISARMED!\n\n");
              break;
            }
          }
        }
        foreach($p->getInventory()->getArmorContents() as $item)
        {
          foreach($item->getEnchantments() as $ench)
          {
            switch($ench->getId())
            {
              case 53:
                $dm->setOnFire(($ench->getLevel() / 0.5) * 10);
              break;
              case 54:
                $p->setHealth($dm->getHealth() + 0.5);
              break;
              case 56:
                $dm->addEffect(Effect::getEffect(Effect::POISON)->setAmplifier(($ench->getLevel() / 1) * 10)->setDuration(($ench->getLevel() * 2)* 20));
              break;
              case 57:
                $dm->addEffect(Effect::getEffect(Effect::SLOWNESS)->setAmplifier(($ench->getLevel() / 1) * 10)->setDuration(($ench->getLevel() * 2)* 20));
              break;
              case 59:
                $p->addEffect(Effect::getEffect(Effect::DAMAGE_RESISTANCE)->setAmplifier(($ench->getLevel() / 1) * 10)->setDuration(($ench->getLevel() * 2)* 20));
              break;
              case 60:
                $dm->addEffect(Effect::getEffect(Effect::WITHER)->setAmplifier(($ench->getLevel() / 1) * 10)->setDuration(($ench->getLevel() * 2)* 20));
              break;
              case 61:
                if($p->getHealth() < ($p->getMaxHealth() / 2))
                {
                  $p->addEffect(Effect::getEffect(Effect::SPEED)->setAmplifier(($ench->getLevel() / 1) * 10)->setDuration(($ench->getLevel() * 2)* 20));
                  $p->setHealth($p->getHealth() + (2 * $ench->getLevel()));
                }
              break;
              case 62:
                if($p->getHealth() < ($p->getMaxHealth() / 2.5))
                {
                  $p->addEffect(Effect::getEffect(Effect::STRENGTH)->setAmplifier(($ench->getLevel() * 2) * 20)->setDuration(($ench->getLevel() * 2)* 20));
                }
              break;
            }
          }
        }
      }
      if(($dm = $ev->getDamager()) && $dm instanceof Arrow && ($p = $ev->getEntity()) && $p instanceof Player)
      {
        $dm = $dm->shootingEntity;
        if($dm->getInventory()->getItemInHand()->hasEnchantments() && $dm->getInventory()->getItemInHand() instanceof Bow)
        {
          foreach($dm->getInventory()->getItemInHand()->getEnchantments() as $ench)
          {
            switch($ench->getId())
            {
              case 46:
                $p->addEffect(Effect::getEffect(Effect::SLOWNESS)->setAmplifier(($ench->getLevel() / 1) * 10)->setDuration(($ench->getLevel() * 2)* 20));
                $p->addEffect(Effect::getEffect(Effect::WEAKNESS)->setAmplifier(($ench->getLevel() / 1) * 10)->setDuration(($ench->getLevel() * 2)* 20));
                $p->addEffect(Effect::getEffect(Effect::BLINDNESS)->setAmplifier(($ench->getLevel() / 1) * 10)->setDuration(($ench->getLevel() * 2)* 20));
              break;
              case 49:
                $ev->setDamage($ev->getDamage() * 2);
              break;
              case 50:
                $pos1 = clone $dm->getLocation();
                $pos2 = clone $p->getLocation();
                $dm->teleport($pos2);
                $p->teleport($pos1);
              break;
              case 51:
                $p->setHealth($p->getHealth() + 1);
                $ev->setCancelled(true);
              break;
            }
          }
        }
      }
    }
  }

  public function onDamage(EntityDamageEvent $ev)
  {
    if($ev->isCancelled())
    {
      return;
    }
    if($ev->getEntity() instanceof Player)
    {
      if($ev->getCause() === EntityDamageEvent::CAUSE_FALL)
      {
        if($ev->getEntity()->getInventory()->getBoots()->hasEnchantments())
        {
          foreach($ev->getEntity()->getInventory()->getBoots()->getEnchantments() as $ench)
          {
            switch($ench->getId())
            {
              case 65:
                foreach($ev->getEntity()->getLevel()->getNearbyEntities($ev->getEntity()->getBoundingBox()->grow(5, 5, 5)) as $nearby) 
                {
                  if(!$nearby instanceof Player)
                  {
                    continue;
                  }
                  if($nearby->getName() === $ev->getEntity()->getName())
                  {
                    continue;
                  }
                  if($this->isFactionsLoaded($this->plugin->getServer(), "FactionsPro"))
                  {
                    $fac = $this->plugin->getServer()->getPluginManager()->getPlugin("FactionsPro");
                    if($fac->sameFaction($ev->getEntity()->getName(), $nearby->getName()) == true or $fac->areAllies($p->getName(), $dm->getName()) == true)
                    {
                      continue;
                    }
                  }
                  $nv = new EntityDamageEvent($nearby, EntityDamageEvent::CAUSE_ENTITY_ATTACK, $ev->getDamage() * 2);
                  $nearby->attack($ev->getDamage() * 2, $nv);
                }
                $ev->setCancelled();
              break;
            }
          }
        }
      }
    }
  }

  public function onMove(PlayerMoveEvent $ev)
  {
    if($ev->isCancelled())
    {
      return;
    }
    $this->plugin->data["movetime"][$ev->getPlayer()->getName()] = microtime();
    foreach($ev->getPlayer()->getInventory()->getArmorContents() as $item)
    {
      if($item->hasEnchantments())
      {
        foreach($item->getEnchantments() as $ench)
        {
          switch($ench->getId())
          {
            case 63:
              $ev->getPlayer()->addEffect(Effect::getEffect(Effect::SPEED)->setAmplifier($ench->getLevel() / 2)->setDuration(($ench->getLevel() * 2)* 20));
            break;
            case 64:
              $ev->getPlayer()->addEffect(Effect::getEffect(Effect::JUMP)->setAmplifier($ench->getLevel() / 2)->setDuration(($ench->getLevel() * 2)* 20));
            break;
            case 66:
              $ev->getPlayer()->setFood($ev->getPlayer()->getFood() + 0.2);
            break;
            case 67:
              $ev->getPlayer()->addEffect(Effect::getEffect(Effect::NIGHT_VISION)->setAmplifier($ench->getLevel() / 2)->setDuration(($ench->getLevel() * 2)* 20));
            break;
          }
        }
      }
    }
  }

  public function onHeld(PlayerItemHeldEvent $ev)
  {
    if($ev->getItem()->hasEnchantments())
    {
      $n = explode("\n", $ev->getItem()->getCustomName());
      if($n[0] == \pocketmine\utils\TextFormat::RED . $ev->getItem()->getName() . "\n")
      {
        return false;
      }
      $it = $this->plugin->setEnchantmentNames($ev->getItem());
      $ev->getPlayer()->getInventory()->setItemInHand($it);
      $ev->getPlayer()->getInventory()->sendContents($ev->getPlayer());
    }
  }

  public function onShoot(EntityShootBowEvent $ev)
  {
    if($ev->isCancelled())
    {
      return;
    }
    if(($shooter = $ev->getEntity()) && $shooter instanceof Player)
    {
      if(($bow = $ev->getBow()) && $bow instanceof Bow)
      {
        if($bow->hasEnchantments())
        {
          foreach($bow->getEnchantments() as $ench)
          {
            switch($ench->getId())
            {
              case 47:
                $ev->getProjectile()->setOnFire(($ench->getLevel() * 2)* 20);
              break;
              case 48:
                if(!$shooter->getInventory()->contains(Item::get(Item::ARROW, 0, 4)))
                {
                  break;
                }
                for($i=0; $i < 3; $i++) 
                { 
                  $arrow = Item::get(Item::ARROW, 0, 1);
                $nbt = new CompoundTag("", [
                  "Pos" => new ListTag("Pos", [
                    new DoubleTag("", $shooter->x),
                    new DoubleTag("", $shooter->y + ($shooter->getEyeHeight() + mt_rand(0, 1.5))),
                    new DoubleTag("", $shooter->z)
                  ]),
                  "Motion" => new ListTag("Motion", [
                    new DoubleTag("", -sin($shooter->yaw / 180 * M_PI) * cos($shooter->pitch / 180 * M_PI)),
                    new DoubleTag("", -sin($shooter->pitch / 180 * M_PI)),
                    new DoubleTag("", cos($shooter->yaw / 180 * M_PI) * cos($shooter->pitch / 180 * M_PI))
                  ]),
                  "Rotation" => new ListTag("Rotation", [
                    new FloatTag("", $shooter->yaw),
                    new FloatTag("", $shooter->pitch)
                  ]),
                  "Fire" => new ShortTag("Fire", $shooter->isOnFire() ? 45 * 60 : 0),
                  "Potion" => new ShortTag("Potion", $arrow->getDamage())
                ]);
                $ar = new Arrow($shooter->getLevel(), $nbt, $shooter, true);
                $ar->setMotion($ar->getMotion()->multiply($ev->getForce()));
                $ar->spawnToAll();
                $shooter->getInventory()->removeItem(Item::get(Item::ARROW, 0, 3));
              }
            }
          }
        }
      }
    }
  }

  public function onBreak(BlockBreakEvent $ev)
  {
    if($ev->isCancelled())
    {
      return;
    }
    if($ev->getPlayer()->getInventory()->getItemInHand()->hasEnchantments())
    {
      foreach($ev->getPlayer()->getInventory()->getItemInHand()->getEnchantments() as $ench)
      {
        switch($ench->getId())
        {
          case 44:
            foreach($this->plugin->ores as $ore)
            {
              if($ev->getBlock()->getId() === $ore && $ev->getBlock()->getToolType() === Tool::TYPE_PICKAXE)
              {
                $ev->setDrops([]);
                $ev->getPlayer()->getInventory()->addItem(Item::get($this->plugin->ingot[$ore], 0, 1));
                $ev->getBlock()->getLevel()->setBlock($ev->getBlock(), Block::get(0,0));
              }
            }
          break;
          case 45:
            if(!$ev->getBlock()->getToolType() === Tool::TYPE_PICKAXE)
            {
              continue;
            }
            $ev->getPlayer()->addEffect(Effect::getEffect(Effect::SPEED)->setAmplifier($ench->getLevel() * 2)->setDuration(($ench->getLevel() * 4)* 20));
          break;
        }
      }
    }
  }

  public function isFactionsLoaded(Server $server, string $pluginName){
      return ($plugin = $server->getPluginManager()->getPlugin($pluginName)) !== null and $plugin->isEnabled();
  }
}