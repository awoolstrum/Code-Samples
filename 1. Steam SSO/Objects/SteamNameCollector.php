<?php

declare(strict_types=1);

namespace Undivided\Module\SSO\Objects;

use Undivided\Framework\Objects\Collector;

final class SteamNameCollector extends Collector
{

  public function isValid($item) : bool
  {
    if( $this->className($item) !== 'SteamName') {
      throw new \Exception("The Steam Name Collector requires instances of Steam Name.");
    }
    return true;
  }

}
