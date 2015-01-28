<?php

namespace WorldGameMode;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class MainClass extends PluginBase implements Listener{

	public function onLoad(){
		$this->getLogger()->info(TextFormat::WHITE . "I've been loaded!");
	}

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);

    }

	public function onDisable(){
		$this->getLogger()->info(TextFormat::DARK_RED . "I've been disabled!");
	}

	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		switch($command->getName()){
			case "tpworld":
                Server::getInstance()->loadLevel("creative");
				$sender->teleport(Server::getInstance()->getLevelByName("creative")->getSafeSpawn());

				return true;
			default:
				return false;
		}
	}


	public function checkWorld(PlayerMoveEvent $event){
		$playerLevelName = $event->getPlayer()->getLevel()->getName();
        switch ($playerLevelName) {
            case ('world'):
                $gamemode = 0;
                break;
            case ('creative'):
                $gamemode =  1;
                break;
            default:
                $gamemode = 0;
                break;
        }
        Server::getInstance()->broadcastMessage($event->getPlayer()->getLevel()->getName());

        if ($event->getPlayer()->getGamemode()!= $gamemode){
            $event->getPlayer()->setGamemode($gamemode);
            $event->getPlayer()->sendMessage("Your gamemode has been changed to " . $gamemode);


        }
	}
}
