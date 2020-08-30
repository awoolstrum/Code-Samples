<?php

declare(strict_types=1);

namespace Undivided\Module\SSO\Logic\Steam;

use Undivided\Module\Contact\Objects\Id;
use Undivided\Module\SSO\Objects\SteamName;
use Undivided\Module\SSO\Objects\SteamUser;

final class SteamTransform
{

    public function mapResultToSteamUser(array $result) : ?SteamUser
    {
      if(empty($result)) {
        return null;
      }

      $r = $result[0];

      $id = new Id();
      $steamUser = new SteamUser(
        $id->fromBytes($r['id']),
        (int) $r['steamId'],
        $r['visibilityState'],
        $r['profileState'],
        (int) $r['lastLogoff'],
        (string) $r['profileUrl'],
        (string) $r['avatar'],
        (string) $r['avatarMedium'],
        (string) $r['avatarFull'],
        $r['personaState'],
        is_int($r['primaryClanId']) ? $r['primaryClanId'] : null,
        (int) $r['timeCreated'] ?? null,
        (isset($r['timeUpdated'])) ? (int) $r['timeUpdated'] : null
      );

      if(isset($r['personaName']) || isset($r['realName'])) {
        $name = new SteamName($id, (string) $r['realname'] ?? null, $r['personaName'] ?? null );
        $steamUser->addName($name);
      }


      if(isset($r['userId'])) {
        $userId = new Id();
        $steamUser->setUserId( $userId->fromBytes($r['userId']) );
      }

      return $steamUser;
    }
}
