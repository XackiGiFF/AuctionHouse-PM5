<?php

namespace shock95x\auctionhouse\economy;

use cooldogedev\BedrockEconomy\api\BedrockEconomyAPI;
use cooldogedev\BedrockEconomy\api\type\LegacyAPI;
use cooldogedev\BedrockEconomy\api\util\ClosureContext;
use pocketmine\player\Player;
use pocketmine\Server;

class BedrockEconomyProvider implements EconomyProvider {

	protected ?LegacyAPI $economy;

	public function __construct(){
		$this->economy = BedrockEconomyAPI::legacy();
	}

	public function addMoney(string|Player $player, float $amount, callable $callback) : void {
		if($player instanceof Player) $player = $player->getName();
		$this->economy->addToPlayerBalance($player, (int) $amount, ClosureContext::create(fn (bool $r) => $callback($r)));
	}

	public function subtractMoney(string|Player $player, float $amount, callable $callback): void {
		if($player instanceof Player) $player = $player->getName();
		$this->economy->subtractFromPlayerBalance($player, (int) $amount, ClosureContext::create(fn (bool $r) => $callback($r)));
	}

	public function getCurrencySymbol() : string{
        $eco = Server::getInstance()->getPluginManager()->getPlugin(self::getName());
		return $eco->getCurrencyManager()->getSymbol();
	}

	public static function getName(): string {
		return "BedrockEconomy";
	}
}
