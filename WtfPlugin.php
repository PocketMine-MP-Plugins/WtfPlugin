<?php

/**
 * @name WtfPlugin
 * @main WtfPlugin\WtfPlugin
 * @author Ne0sW0rld
 * @version Final
 * @api 3.0.0
 * @description Test Plugin
 */
 

namespace WtfPlugin;


use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\event\player\PlayerCreationEvent;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\network\SourceInterface;


class WtfPlugin extends PluginBase
{

    public function onEnable ()
    {

		$this->getServer()->getPluginManager()->registerEvents (new class implements Listener
		{

			public function onCreated (PlayerCreationEvent $event)
			{

				$event->setPlayerClass (TestPlayer::class);

			}

		}, $this);

    }

}

class TestPlayer extends Player
{
	
	public $cool;
	
	public function __construct(SourceInterface $interface, string $ip, int $port)
	{
		
		parent::__construct ($interface, $ip, $port);
		$this->cool = 0;
		
	}

	public function onCollideWithPlayer (Player $player) : void
	{
		
		if ($player->getScale() === $this->getScale())
			return;
		
		if ($player->getScale() < $this->getScale())
		{
			
			if ($player->cool > time())
				return;
			
			$player->cool = time() + 1;

			$player->setMotion ($player->getDirectionVector()->multiply (-$this->getScale()));
			$player->sendMessage ($this->getName() . ': 아.. 야 왜 시비거냐?');
			
			return;
			
		}

		if ($this->cool > time())
			return;
		
		$this->cool = time() + 1;

		$this->setMotion ($this->getDirectionVector()->multiply (-$player->getScale()));
		$this->sendMessage ($player->getName() . ': 아.. 야 왜 시비거냐?');

	}

}
