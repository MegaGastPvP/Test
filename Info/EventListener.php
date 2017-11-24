<?php

namespace KingdomCore;

use pocketmine\utils\Config;
use pocketmine\Player;
use KingdomCore\task\JoinUITask;

class EventListener implements \pocketmine\event\Listener{

    public $plugin;
    public $quay = [];
    public $cordian = [];
    public $dracosis = [];

    public function __construct(Main $plugin){
           $this->plugin = $plugin;  
    }
    
    public function onJoin(\pocketmine\event\player\PlayerJoinEvent $e){
          $p = $e->getPlayer();
     //   $kingdom = $this->plugin->getKingom($p);
        $this->plugin->enabledc[strtolower($p->getName())] = false;
        var_dump($this->plugin->enabledc[strtolower($p->getName())]);
        $this->plugin->cfg[strtolower($p->getName())] = null;
        if($this->plugin->isNew($p->getName())){
            $this->plugin->registerPlayer($p->getName());
            $this->plugin->getServer()->getScheduler()->scheduleRepeatingTask(new JoinUITask($p, $this->plugin), 20);
        }else{
            $p->sendMessage("§eWelcome back, §a" . $p->getName());
            $this->plugin->configs[strtolower($p->getName())] = new Config($this->plugin->getDataFolder() . "/players/" . $p->getName() . ".yml");
        }
       /* switch($kingdom){
            case "Dracosis";
                $this->dracosis[strtolower($p->getName())] = $p;
                break;
            case "Quay";
                $this->quay[strtolower($p->getName())] = $p;
                break;
            case "Cordian";
                $this->cordian[strtolower($p->getName())] = $p;
                break;
        }*/

    }
	
	public function onDataPacketReceive(\pocketmine\event\server\DataPacketReceiveEvent $e){
        $pk = $e->getPacket();
        $p = $e->getPlayer();
		$C = new Config($this->plugin->getDataFolder() . "/players/" . $p->getName() . ".yml");
        if($pk instanceof \pocketmine\network\mcpe\protocol\ModalFormResponsePacket){
            $data = json_decode($pk->formData);
			if($pk->formId == 444){
				if($data == 0){
					if($data !== null){
					$this->plugin->addToKingdom($p, 'Dracosis');
					$p->sendMessage('Dracosis');
					}else{
						$form = new SimpleForm(444, 'nwm');
						$form->setTitle('Select kingdom');
		   $form->addButton('Dracosis');
		 $form->addButton('Quay');
		 $form->addButton('Cordian');
		 $form->sendTo($p);
						
					}
					return false;
				}elseif($data == 1){
					$this->plugin->addToKingdom($p, 'Quay');
					$p->sendMessage('Quay');
					return false;
				}elseif($data == 2){
					$this->plugin->addToKingdom($p, 'Codrian');
					$p->sendMessage('Cordian');
					return false;
				}
				if($data == null){
					$form = new SimpleForm(444, 'nwm');
		    
		   return false;
				}
			}
		}
	}
	

    /*public function onChat(\pockemine\event\player\PlayerChatEvent $e){
        $p = $e->getPlayer();
        /*if($this->plugin->enabledc[strtolower($p->getName())] == true) {
            $e->setCancelled();
            $kingdom = $this->plugin->getKingom($p);
            switch ($kingdom) {
                case "Dracosis";
                    foreach($this->dracosis as $dr){
                        $dr->sendMessage("§b" . $p->getName() . ": §e" . $e->getMessage());
                    }
                    break;
                case "Quay";
                    foreach($this->quay as $dr){
                        $dr->sendMessage("§b" . $p->getName() . ": §e" . $e->getMessage());
                    }
                    break;
                case "Cordian";
                    foreach($this->cordian as $dr){
                        $dr->sendMessage("§b" . $p->getName() . ": §e" . $e->getMessage());
                    }
                    break;
            }
        }*/
  //  }


    public function onInteract(\pocketmine\event\player\PlayerInteractEvent $e){
        $p = $e->getPlayer();
        if($p->getInventory()->getItemInHand()->getId() == 131){
            $this->plugin->sfui($p);
            $p->getInventory()->removeItem($p->getInventory()->getItemInHand());
        }
    }
	
	public function onDamage(\pocketmine\event\entity\EntityDamageEvent $e){
		$p = $e->getPlayer();
		if($p instanceof Player){
			if($e instanceof \pocketmine\event\entity\EntityDamageByEntityEvent){
				$dam = $e->getDamager();
				if($dam instanceof Player){
					if($this->getKingdom($dam) == $this->getKingdom($p)){
						$e->setCancelled();
						$dam->sendMessage('§cYou can not damage players from your kingdom');
					}
				}
			}
		}
	}

    public function onMsg(\pocketmine\event\player\PlayerChatEvent $e) {
        $p = $e->getPlayer();
		$e->setCancelled();
        if($this->plugin->enabledc[strtolower($p->getName())] == true) {
            $kingdom = $this->plugin->getKingdom($p);
            switch ($kingdom) {
                case "Dracosis";
                    $this->dracosis[strtolower($p->getName())] = $p;
                    foreach ($this->dracosis as $dr) {
                        $dr->sendMessage("§b" . $p->getName() . ": §e" . $e->getMessage());
                    }
                    break;
                case "Quay";
                    $this->quay[strtolower($p->getName())] = $p;
                    foreach ($this->quay as $dr) {
                        $dr->sendMessage("§b" . $p->getName() . ": §e" . $e->getMessage());
                    }
                    break;
                case "Cordian";
                    $this->cordian[strtolower($p->getName())] = $p;
                    foreach ($this->cordian as $dr) {
                        $dr->sendMessage("§b" . $p->getName() . ": §e" . $e->getMessage());
                    }
                    break;
            }
			return false;
        }
		$config = new Config($this->plugin->getDataFolder() . "/players/" . $p->getName() . ".json");
		$rank = $this->plugin->pperms->getProvider()->getPlayerData($p)['group'];
		$this->plugin->getServer()->broadcastMessage("§7[§6" . $config->get("kingdom") . "§7] [$rank] " . $p->getName() . ": " . $e->getMessage()); 
    }
}
