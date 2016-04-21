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
    $config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
    $format = $config->get("Format");
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getLogger()->info(C::GREEN . "Enabled!");
    $this->getServer()->getScheduler()->scheduleRepeatingTask(new SwaggyHUD($this), 1);
    $this->getLogger()->notice(C::AQUA . "Message Format: " . $format);
  }
  public function getMessage(){
    $config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
    $message = $config->get("Message");
    $m = str_replace("&","§",$message);
    $msg = str_replace("{LINE}","\n",$message);
	return $msg;
  }
  public function getFormat(){
  	$config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
	$format = $config->get("Format");
	return $format;
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
		$message = $this->plugin->getMessage();
		$format = $this->plugin->getFormat();
		foreach($allplayers as $p) {
			if($p instanceof Player) {	
                           if($format === "Popup"){
				$p->sendPopup($message);
			        }
				if($format === "Tip"){
				$p->sendTip($message);
				}
			}
		}
	}
}
