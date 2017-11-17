<?php

namespace PlayerBio;

use pocketmine\plugin\PluginBase; 
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Main extends PluginBase implements Listener {

	public $config;

	public function onEnable() {
		@mkdir($this->getDataFolder());
		$this->config = new Config($this->getDataFolder() . "bios.yml", Config::YAML, array());
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
		if($command->getName() === "bio") {
			if(!isset($args[0])) {
				$sender->sendMessage("§7-§6==§7- §9PlayerBio Commands §-7§6==§7-");
				$sender->sendMessage("§a/bio see <player>");
				$sender->sendMessage("§a/bio set <bio>");
				$sender->sendMessage("§a/bio version");
				return true;
			}else {
				if($args[0] == "version") {
					$sender->sendMessage('§bPlayerBio §2v1.0.0 §emade by §3Kairus Dark Seeker(Twitter: @KairusDS)');
					return true;
				}
				if($args[0] == "see") {
					if(empty($args[1])) {
						$sender->sendMessage("§cPlease specify a player.");
						return true;
					}

					$player = $this->getServer()->getPlayer($args[1]);
					if($player == null) {
						$sender->sendMessage("§cThat player cannot be found.");
						return true;
					}else {
						if(empty($this->getBio($player))) {
							$sender->sendMessage("§cThis player does not have a bio yet.");
							return true;
						}

						$sender->sendMessage("§7-§6==§7- §9" . $player->getName() . "'s Bio' §7-§6==§7-");
						$sender->sendMessage($this->getBio($player));
						return true;
					}
				}

				if($args[0] == "set") {
					$args[0] = "";
					$bio = implode(" ", $args);
					if(trim($bio) === "") {
						$sender->sendMessage("§cPlease enter atleast one word.");
						return true;
					}

					$sender->sendMessage("§aYour Bio has been changed successfully!");
					$this->setBio($sender, $bio);
				}
			}
		}
	}

	public function getBio(Player $player) {
		return base64_decode($this->config->get(strtolower($player->getName())));
	}

	public function setBio(Player $player, $bio) {
		$this->config->set(strtolower($player->getName()), base64_encode($bio));
		$this->config->save();
		$this->config->reload();
	}
}