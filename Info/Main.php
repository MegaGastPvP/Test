<?php

namespace MegaGastPvP\FacsUI;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use jojoe77777\FormAPI;
use pocketmine\utils\TextFormat as c;
use pocketmine\Player;
use pocketmine\plugin\PluginManager;
use pocketmine\Server;

class Main extends PluginBase implements Listener {
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        switch($cmd->getName()){
            case "fac":
                if($sender instanceof Player){
                    $a = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
                    if($a === null || $a->isDisabled()){
                        
                    }
                    $f = $a->createSimpleForm(function (Player $sender, array $data){
                    $r = $data[0];
                    if($r === null){
                        
                    }
                    switch($r){
                        case 0:
                               $command = "claim";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 1:
                               $command = "overclaim";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 2:
                               $command = "unclaim";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 3:
                               $command = "topfactions";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 4;
                               $command = "del";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 5;
                               $command = "leave";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 6;
                               $command = "homer";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 7;
                               $command = "unsethomer";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 8;
                               $command = "ourmembers";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 9;
                               $command = "ourofficers";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 10;
                                $command = "ourleader";
                                $this->getServer()->getCommandMap()->dispatch($sender, $command);
                                break;
                        case 11;
                                $command = "chat";
                                $this->getServer()->getCommandMap()->dispatch($sender, $command);
                                break;
                    }
                    });
                    $f->setTitle(c::GOLD . "Faction Commands");
                    $f->setContent(c::AQUA . "What Command Will you run?");
                    $f->addButton(c::RED . "Claim");
                    $f->addButton(c::RED . "OverClaim");
                    $f->addButton(c::RED . "UnClaim");
                    $f->addButton(c::RED . "Top Factions");
                    $f->addButton(c::RED . "Delete");
                    $f->addButton(c::RED . "Leave");
                    $f->addButton(c::RED . "home");
                    $f->addButton(c::RED . "unsethome");
                    $f->addButton(c::RED . "MyMembers");
                    $f->addButton(c::RED . "MyOfficers");
                    $f->addButton(c::RED . "MyLeader");
                    $f->addButton(c::RED . "FactionChat");
                    $f->sendToPlayer($sender);
                }
             return true;
            case "claim":
                if($sender instanceof Player){
                    $a = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
                    if($a === null || $a->isDisabled()){
                        
                    }
                    $f = $a->createSimpleForm(function (Player $sender, array $data){
                    $r = $data[0];
                    if($r === null){
                        
                    }
                    switch($r){
                        case 0:
                               $command = "f claim";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 1:
                               $command = "fac";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                    }
                    });
                    $f->setTitle(c::GOLD . "Claim");
                    $f->setContent(c::AQUA . "Are you sure you what to claim land?");
                    $f->addButton(c::GREEN . "Yes");
                    $f->addButton(c::DARK_RED . "No");
                    $f->sendToPlayer($sender);
                }
        }
        return true;
    }
}
