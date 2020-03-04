<?php
namespace Nora\CustomCraftRecipe;
use pocketmine\plugin\PluginBase;
use pocketmine\inventory\ShapedRecipe;
use pocketmine\item\Item;
use pocketmine\nbt\JsonNBTParser;
use pocketmine\utils\TextFormat as C;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;


class Main extends PluginBase{


   public function onEnable(){
        foreach($this->getConfig()->getAll() as $craft) {
            $result = $this->getItem($craft["result"]);
            foreach($craft["ench"] as $name => $lv){
	              $ec = Enchantment::getEnchantmentByName($name);
                $result->addEnchantment(new EnchantmentInstance($ec, $lv));
               }
            $rec = new ShapedRecipe(["abc","def","ghi"], [
		    "a" => $this->getItem($craft["shape"][0][0]),
		    "b" => $this->getItem($craft["shape"][0][1]),
		    "c" => $this->getItem($craft["shape"][0][2]),
		    "d" => $this->getItem($craft["shape"][1][0]),
		    "e" => $this->getItem($craft["shape"][1][1]),
		    "f" => $this->getItem($craft["shape"][1][2]),
		    "g" => $this->getItem($craft["shape"][2][0]),
		    "h" => $this->getItem($craft["shape"][2][1]),
		    "i" => $this->getItem($craft["shape"][2][2]),
	    ], [$result]);
            $this->getServer()->getCraftingManager()->registerRecipe($rec);
            $this->getLogger()->info("Registered recipe for " . $this->getItem($craft["result"])->getName());
        }
    }


    public function onLoad(){
        $this->saveDefaultConfig();
    }
    
    
    
    public function getItem(array $item) : Item {
        $result = Item::fromString($item[0]);
        if(isset($item[1])) {
        	$result->setCount((int) $item[1]);
        }
        if(isset($item[2])) {
	          $result->setCustomName(C::RESET . $item[2]);
        }
        if(isset($item[3])) {
	          $result->setLore([C::RESET . $item[3]]);
	      } 
        return $result;
    }
}
