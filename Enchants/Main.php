<?php
/**
 * Created by PhpStorm.
 * User: Andre
 * Date: 3/14/2017
 * Time: 3:28 PM
 */

namespace Andre\NetworkSystem;

use Andre\NetworkSystem\API\Title;
use Andre\NetworkSystem\Ban\BanSystem;
use Andre\NetworkSystem\Ban\RemoveBan;
use Andre\NetworkSystem\Lobby\LobbyNetworkGamesUpdate;
use Andre\NetworkSystem\Lobby\LobbyNetworkUpdate;
use Andre\NetworkSystem\Pet\PetSystem;
use Andre\NetworkSystem\Query\FindGame;
use Andre\NetworkSystem\System\FlySystem;
use Andre\NetworkSystem\System\HelpSystem;
use Andre\NetworkSystem\System\ScaleSystem;
use Andre\NetworkSystem\Account\Link;
use Andre\NetworkSystem\System\FriendSystem;
use Andre\NetworkSystem\System\LobbySystem;
use Andre\NetworkSystem\System\MuteSystem;
use Andre\NetworkSystem\System\NickSystem;
use Andre\NetworkSystem\System\RateSystem;
use Andre\NetworkSystem\System\RemoveMuteSystem;
use Andre\NetworkSystem\Party\Party;
use Andre\NetworkSystem\System\ServerSystem;
use Andre\NetworkSystem\System\SpawnSystem;
use Andre\NetworkSystem\System\StaffManagerSystem;
use Andre\NetworkSystem\System\VanishSystem;
use Andre\NetworkSystem\System\XYZ;
use pocketmine\event\Listener;

use pocketmine\network\mcpe\protocol\TransferPacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {

	const PORTAL = "§9§lPortal>§r ";
	const RUN_FROM_CONSOLE = "§cRUN COMMAND AS PLAYER";
	const PERMISSION_BUY_RANK = "§9§lPermission>§r§7 You can't use this, Purchase a rank @ §aShop.Vastlands.net§7 or download our Android app. Search '§aVastlands§7'";
	const PERMISSION_STAFF = "§9§lPermission>§r§7 You don't access to this command";
	const COMMAND_NOT_FOUND = "§9§lCommand>§r§7 That command does not exist";
	const LOBBY_MOTD = "§l§bVast§aLands §l§7» §eBETA!§r";
	const Game_World = array("Paradise", "Murder", "Oasis", "FutureFrenzy", "BookBattle", "Waiting_Lobby", "PVP");
	const ACCOUNT = "§9§lAccount>§r§7";
	const LOGIN = "§9§lLogin>§r§7";
	public $server;
	public $data;
	public $coin;
	public $online;
	public $status;
	public $lobby = array("19132", "19133", "9001");
	public $next = [];
	public static $pets = [];
	public $openBW = [];
	public $openMM = [];
	/** Player Level~ It gets updated by a task */
	public $level = [];
	public $amp = [];
	public $crate = [];
	public $tasks = [];
	public $npcData = [];


	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);


		$this->getServer()->getCommandMap()->registerAll('NetworkSystem', [
			new FlySystem($this),
			new Link($this),
			new Party($this),
			new MuteSystem($this),
			new RemoveMuteSystem($this),
			new VanishSystem($this),
			new BanSystem($this),
			new RemoveBan($this),
			new RateSystem($this),
			new NickSystem($this),
			new ServerSystem($this),
			new LobbySystem($this),
			new FriendSystem($this),
			new ScaleSystem($this),
			new StaffManagerSystem($this),
			new PetSystem($this),
			new XYZ($this),
			new SpawnSystem($this),
			new HelpSystem($this)
		]);

		/*
		 *  Get everything ready for network system.
		 */
		$setup = new Setup($this);
		$setup->int();

	}


	public function isLobby(){
		if(in_array($this->getServer()->getPort(), $this->lobby)){
			return true;
		}else{
			return false;
		}
	}

	public function sendTo($player, $type){

		if($player instanceof Player){
			$pk = new TransferPacket();
			$pk->address = $this->data[$type]['IP'];
			$pk->port = $this->data[$type]['PORT'];
			$player->directDataPacket($pk);
			//$player->close("", "§7[§eLOADING§7] §bSending you to §9$type", true);
			return true;
		}else{
			return false;
		}
	}


	public function getPlayerServer(){
		return $this->server;
	}


	public function getOnline(){

		if($this->online == null){
			return "0";
		}else{
			return $this->online;
		}
	}

	public function setOnline($player){

		$this->online = 0;
		$this->online = $player;
	}

	/*
	 *  Get a specific player count
	 */

	public function getServerCount($type){

		if($this->status[$type]['Count'] == null){

			return "0";
		}else{
			return $this->status[$type]['Count'];
		}
	}

	/*
	 *  Schedule a task that fetch all the online players on the whole network
	 */

	public function updateNetwork(){
		$this->getServer()->getScheduler()->scheduleAsyncTask(new LobbyNetworkUpdate($this));
	}

	/*
	 *  Schedule a task that fetch online players in a specific server
	 */

	public function updateGameNetwork(){
		$this->getServer()->getScheduler()->scheduleAsyncTask(new LobbyNetworkGamesUpdate($this));
	}

	/*
	 *  Only to be used onJoin
	 */

	public function sendTitle($player, $title, $sub){

		if($player instanceof Player){
			$player->removeTitles();
			$this->getServer()->getScheduler()->scheduleDelayedTask(new Title($this, $player, $title, $sub), 16);
		}
	}


	public function getOpenGames(){

		if(!$this->isLobby()){
			if(!in_array($this->getServer()->getPort(), array("5600", "5601", "5602", "5603"))){
				$this->getServer()->getScheduler()->scheduleAsyncTask(new FindGame($this));
			}
		}
	}

	public function cancelTask($id){

		unset($this->tasks[$id]);
		$this->getServer()->getScheduler()->cancelTask($id);
	}

	public function getGameID(){

		switch($this->getServer()->getPort()){

			/*
			 * MurderMystery
			 */

			case "5701":
				return "MM-1";
				break;

			case "5702":
				return "MM-2";
				break;

			case "5703":
				return "MM-3";
				break;

			case "5704":
				return "MM-4";
				break;

			case "5705":
				return "MM-5";
				break;

			case "5706":
				return "MM-6";
				break;

			case "5707":
				return "MM-7";
				break;

			case "5708":
				return "MM-8";
				break;

			case "5709":
				return "MM-9";
				break;

			case "5710":
				return "MM-10";
				break;

			case "5711":
				return "MM-11";
				break;

			case "5712":
				return "MM-12";
				break;

			case "5713":
				return "MM-13";
				break;

			case "5714":
				return "MM-14";
				break;

			case "5715":
				return "MM-15";
				break;

			case "5716":
				return "MM-16";
				break;

			case "5717":
				return "MM-17";
				break;

			case "5718":
				return "MM-18";
				break;

			case "5719":
				return "MM-19";
				break;

			case "5720":
				return "MM-20";
				break;

			/*
			 * Bedwars
			 */

			case "5801":
				return "BW-1";
				break;

			case "5802":
				return "BW-2";
				break;

			case "5803":
				return "BW-3";
				break;

			case "5804":
				return "BW-4";
				break;

			case "5805":
				return "BW-5";
				break;

			case "5806":
				return "BW-6";
				break;

			case "5807":
				return "BW-7";
				break;

			case "5808":
				return "BW-8";
				break;

			case "5809":
				return "BW-9";
				break;

			case "5810":
				return "BW-10";
				break;

			case "5811":
				return "BW-11";
				break;

			case "5812":
				return "BW-12";
				break;

			case "5813":
				return "BW-13";
				break;

			case "5814":
				return "BW-14";
				break;

			case "5815":
				return "BW-15";
				break;

			case "5816":
				return "BW-16";
				break;

			case "5817":
				return "BW-17";
				break;

			case "5818":
				return "BW-18";
				break;

			case "5819":
				return "BW-19";
				break;

			case "5820":
				return "BW-20";
				break;

			/*
			 * SurvivalGame
			 */

			case "1111":
				return "EW-1";
				break;
		}
	}
}