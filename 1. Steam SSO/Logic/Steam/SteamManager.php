<?php

declare(strict_types=1);

namespace Undivided\Module\SSO\Logic\Steam;

use Undivided\Module\SSO\Repository\SteamRepository;
use Undivided\Module\User\Logic\IUser;

final class SteamManager
{

  public function __construct() {
    $this->steamRepo = new SteamRepository();
  }

  public function findUserBySteamId(int $steamId) : ?IUser
  {
    return $this->steamRepo->getSteam($steamId);
  }
}
