<?php

namespace shock95x\auctionhouse\economy;

use cooldogedev\BedrockEconomy\BedrockEconomy;
use cooldogedev\BedrockEconomy\libs\cooldogedev\libSQL\context\ClosureContext;
use pocketmine\player\Player;

class BedrockEconomyProvider implements EconomyProvider {

	protected ?BedrockEconomy $economy;

	public function __construct() {
		$this->economy = BedrockEconomy::getInstance();
	}

	public function addMoney(Player $player, float $amount, array $labels, int $usage, callable $callback): void {
		if($player instanceof Player) $player = $player->getName();
		$this->economy->getAPI()->addToPlayerBalance($player, $amount, ClosureContext::create(fn (bool $r) => $callback($r)));
	}

	public function subtractMoney(Player $player, float $amount, array $labels, int $usage, callable $callback): void {
		if($player instanceof Player) $player = $player->getName();
		$this->economy->getAPI()->subtractFromPlayerBalance($player, $amount, ClosureContext::create(fn (bool $r) => $callback($r)));
	}

	public function getCurrencySymbol(): string {
		return $this->economy->getCurrencyManager()->getSymbol();
	}

	public static function getName(): string {
		return "BedrockEconomy";
	}
}
