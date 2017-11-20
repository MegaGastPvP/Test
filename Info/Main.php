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
            case "facs":
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
                               $command = "fa claim";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 1:
                               $command = "fa overclaim";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 2:
                               $command = "fa unclaim";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 3:
                               $command = "fa topfactions";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 4;
                               $command = "fa del";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 5;
                               $command = "fa leave";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 6;
                               $command = "fa home";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 7;
                               $command = "fa unsethome";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 8;
                               $command = "fa ourmembers";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 9;
                               $command = "fa ourofficers";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 10;
                                $command = "fa ourleader";
                                $this->getServer()->getCommandMap()->dispatch($sender, $command);
                                break;
                        case 11;
                                $command = "fa c";
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
            case "fa claim":
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
                    $f->setTitle(c::AQUA . c::BOLD . "Claim");
                    $f->setContent(c::RED . "Are you sure you what to claim");
                    $f->addButton(c::GREEN . "Yes Im Sure");
                    $f->addButton(c::DARK_RED . "Never Mind");
                }
            case "fa unclaim":
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
                               $command = "f unclaim";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                        case 1:
                               $command = "fac";
                               $this->getServer()->getCommandMap()->dispatch($sender, $command);
                               break;
                    }
                    });
                    $f->setTitle(c::AQUA . c::BOLD . "UnClaim");
                    $f->setContent(c::RED . "Are you sure you what to UnClaim");
                    $f->addButton(c::GREEN . "Yes Im Sure");
                    $f->addButton(c::DARK_RED . "Never Mind");
                } 
        }
        return true;
    }
}