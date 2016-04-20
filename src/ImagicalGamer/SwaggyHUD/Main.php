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
  public function getMessage($msg){
    $config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
    $message = $config->get("Message");
    $msg = str_replace("&","§",$message);
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
		$message = $this->plugin->getMessage($msg);
		foreach($allplayers as $p) {
			if($p instanceof Player) {	
                           $p->sendPopup($msg);
			}
		}
	}
}
