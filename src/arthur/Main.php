<?php

namespace arthur;

use pocketmine\{
	level\Level,
	math\Vector3,
	entity\Entity,
	event\Listener,
	plugin\PluginBase,
	block\BlockFactory,
	resourcepacks\ZippedResourcePack
	};


class Main extends PluginBase implements Listener
{
    /**
     * When the plugin enables
     *
     * @return void
     */
    public function onEnable()
    {
        //3D Guns Loader
		if (!file_exists($this->getDataFolder())) {
			mkdir($this->getDataFolder());
		}
        $downRP = false;
        if (!file_exists($this->getDataFolder() . "Guns.mcpack")) {
            $downRP = true;
            file_put_contents($this->getDataFolder() . "Guns.mcpack");
        }
        //Replaces Bow With a 3D GUN
        $pack = new ZippedResourcePack($this->getDataFolder() . "Guns.mcpack");
        $r = new \ReflectionClass("pocketmine\\resourcepacks\\ResourcePackManager");
        $resourcePacks = $r->getProperty("resourcePacks");
        $resourcePacks->setAccessible(true);
        $rps = $resourcePacks->getValue($this->getServer()->getResourceManager());
        $rps[] = $pack;
        $resourcePacks->setValue($this->getServer()->getResourceManager(), $rps);
        $resourceUuids = $r->getProperty("uuidList");
        $resourceUuids->setAccessible(true);
        $uuids = $resourceUuids->getValue($this->getServer()->getResourceManager());
        $uuids[$pack->getPackId()] = $pack;
        $resourceUuids->setValue($this->getServer()->getResourceManager(), $uuids);
        $forceResources = $r->getProperty("serverForceResources");
        $forceResources->setAccessible(true);
        $forceResources->setValue($this->getServer()->getResourceManager(), true);
    }
}
