<?php
declare ( strict_types = 1 );
namespace lukeeey\waterdog;

use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\network\mcpe\raklib\RakLibInterface;
use ReflectionClass;

class Main extends PluginBase implements Listener {

    public function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
public function onLogin(PlayerLoginEvent $event){
        $clientdata = $event->getPlayer()->getPlayerInfo()->getExtraData();
	foreach ( $this->getServer()->getNetwork()->getInterfaces() as $interface ) {
						  if ( $interface instanceof RakLibInterface ) {
								$interface->setPacketLimit(900000000000);
						  }
					 }
        if(isset($clientdata["Waterdog_IP"])){
			$class = new ReflectionClass($event->getPlayer()->getNetworkSession());
                $prop = $class->getProperty("ip");
                $prop->setAccessible(true);
                $prop->setValue($event->getPlayer()->getNetworkSession(), $clientdata["Waterdog_IP"]);
        }
	if(isset($clientdata["Waterdog_XUID"])){
		$class = new ReflectionClass($event->getPlayer());
		$prop = $class->getProperty("xuid");
		$prop->setAccessible(true);
		$prop->setValue($event->getPlayer(), $clientdata["Waterdog_XUID"]);
	}
}
}
