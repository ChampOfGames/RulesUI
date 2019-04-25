<?php
declare(strict_types=1);
 
namespace ChampOfGames\Rules;
 
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;
 
class Main extends PluginBase implements Listener{
 
    public function onEnable() : void{
        $this->saveResource("rules.yml");
        $this->saveResource("info.yml");
     $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
 
 public function onJoin(PlayerJoinEvent $event){
    
    $config = new Config($this->getDataFolder() . "rules.yml", Config::YAML);
    $info = new Config($this->getDataFoler(). "info.yml", Config ::YAML);
    $player = $event->getPlayer();
  
    if($config->get("open_at_first_join") == true){
 if(!$player->hasPlayedBefore() == true){ 
$this->openHelpUI($player);

  }
}
}
 
    public function openHelpUI($player) { // ACHTUNG: hier ist $player nicht $sender
        $form = new SimpleForm(function (Player $player, int $data = null){
 
            $result = $data;
            if($result === null){
                return true;
            }
            switch($result){
                case 0:
                    break;
            }
 
        });
 
        $form->setTitle($this->getRules()->get("Title"));
        $form->setContent($this->getRules()->get("Content"));
        $form->addButton($this->getRules()->get("Button"));
        $form->sendToPlayer($player); // Hier $player! Weil oben auch $player als Spieler definiert wurde!
        return $form;
    }
 
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        switch($command->getName()){
            case "rules":
                if($sender instanceof Player) {
                    $this->openHelpUI($sender);
                }
                return true;
            default:
                return false;
        }
    }
 
    public function onDisable() : void{
       $this->getLogger()->info("Bye");
    }
}
