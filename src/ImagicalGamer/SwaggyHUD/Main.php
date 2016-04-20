<?php
namespace ImagicalGamer\SwaggyHUD;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;
use pocketmine\scheduler\PluginTask;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat as C;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

  public function onEnable(){
    $this->saveDefaultConfig();
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getLogger()->info(C::GREEN . "Enabled!");
    $this->getServer()->getScheduler()->scheduleRepeatingTask(new SwaggyHUD($this), 1);
  }
}
class SwaggyHUD extends PluginTask {
  
	public function __construct($plugin)
	{
		$this->plugin = $plugin;
		parent::__construct($plugin);
	}
  
	public function onRun($tick){
		$allplayers = $this->plugin->getServer()->getOnlinePlayers();
		$config = $this->getConfig();
		$format = $config->get("Format");
		$message1 = $config->get("Message");
		$message = str_replace("&","§",$message1);
		foreach($allplayers as $p) {
			if($p instanceof Player) {	
			if($format === "Popup"){
				$p->sendPopup($message);
			}
			if($format === "Tip"){
				$player->sendTip($message);
			}
			}
		}
	}
}
