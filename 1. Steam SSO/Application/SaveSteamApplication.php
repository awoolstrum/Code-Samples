<?php

declare(strict_types=1);

namespace Undivided\Module\SSO\Application;

use Undivided\Framework\Exception\ExceptionHandler;
use Undivided\Framework\Infrastructure\Application;
use Undivided\Module\SSO\Objects\SteamUser;
use Undivided\Module\SSO\Repository\SteamRepository;

final class SaveSteamApplication extends Application
{

  use ExceptionHandler;

  public function __construct() {

    $this->repo = new SteamRepository();
    parent::__construct();
  }

  public function save(SteamUser $steamUser)
  {

    $this->repo->setSteam([
      'id' => $steamUser->id(),
      'userId' => ($steamUser->userId() !== null) ? $steamUser->userId() : null,
      'steamId' => $steamUser->steamId(),
      'visibilityState' => $steamUser->visibilityState(),
      'profileState' => $steamUser->profileState(),
      'lastLogoff' => ($steamUser->lastLogoff() !== null) ? $steamUser->lastLogoff() : null,
      'profileUrl' => $steamUser->profileUrl(),
      'avatar' => $steamUser->avatar(),
      'avatarMedium' => $steamUser->avatarMedium(),
      'avatarFull' => $steamUser->avatarFull(),
      'personaState' => $steamUser->personaState(),
      'primaryClanId' => $steamUser->primaryClanId()
       ]);

    if($steamUser->name() !== null){
      $this->repo->setSteamName([
        'id' => $steamUser->id(),
        'realname' => $steamUser->name()->realname(),
        'personaName' => $steamUser->name()->personaName()
      ]);
    }

    return;
  }
}