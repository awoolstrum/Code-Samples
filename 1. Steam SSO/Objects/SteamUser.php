<?php

declare(strict_types=1);

namespace Undivided\Module\SSO\Objects;

use InvalidArgumentException;
use Undivided\Framework\Infrastructure\IIdentity;
use Undivided\Module\User\Logic\IUser;

final class SteamUser implements IUser
{
    private $steamId;
    private $visibilityState;
    private $profileState;
    private $lastLogoff;
    private $profileUrl;
    private $avatar;
    private $avatarMedium;
    private $avatarFull;
    private $personaState;
    private $primaryClanId;
    private $timeCreated;
    private $timeUpdated;
    private $lastResourceCall;
    /**
     * @var SteamNameCollector
     */
    private $namesCollector;
  /**
   * @var IIdentity|null
   */
  private $id;
  private $userId;

  public function __construct(
      ?IIdentity $id,
      int $steamId,
      $visibilityState,
      $profileState,
      ?int $lastLogoff,
      ?string $profileUrl,
      ?string $avatar,
      ?string $avatarMedium,
      ?string $avatarFull,
      $personaState,
      ?int $primaryClanId,
      ?int $timeCreated,
      ?int $timeUpdated
    ) {

      if($id !== null) {
        $this->id = $id;
      }

      $dt = new \DateTimeImmutable();
      $this->steamId = $steamId;
      $this->visibilityState = $visibilityState;
      $this->profileState = $profileState;
      $this->lastLogoff = $lastLogoff;
      $this->profileUrl = $profileUrl;
      $this->avatar = $avatar;
      $this->avatarMedium = $avatarMedium;
      $this->avatarFull = $avatarFull;
      $this->personaState = $personaState;
      $this->primaryClanId = $primaryClanId;
      $this->timeCreated = $timeCreated;
      if($timeUpdated!==null){
        $this->timeUpdated = $timeUpdated;
      }

      $this->lastResourceCall = new \DateTimeImmutable();

    }

    public function id() : IIdentity
    {
      return $this->id;
    }

    final public function setUserId(IIdentity $id) : void
    {
      if ($this->userId !== null) {
        throw new InvalidArgumentException("The steam user's userId cannot be changed after it has been set.");
      }
      $this->userId = $id;
    }

    public function steamId() : int
    {
      return $this->steamId;
    }

    public function userId() : IIdentity
    {
      return $this->userId;
    }

    final public function addName(SteamName $name){
      if($this->namesCollector == null){
        $this->namesCollector = new SteamNameCollector();
      }
      $this->namesCollector->add($name);
    }

    public function name() : SteamName
    {
      return $this->namesCollector->last();
    }

    public function lastRefresh() : \DateTimeImmutable
    {
      return $this->lastResourceCall;
    }

    public function visibilityState()
    {
      return $this->visibilityState;
    }

    public function profileState()
    {
      return $this->profileState;
    }

    public function lastLogoff() : ?int
    {
      return $this->lastLogoff;
    }

    public function profileUrl() : ?string
    {
      return $this->profileUrl;
    }

  public function avatar() : ?string
  {
    return $this->avatar;
  }

  public function avatarMedium() : ?string
  {
    return $this->avatarMedium;
  }

  public function avatarFull() : ?string
  {
    return $this->avatarFull;
  }

  public function personaState()
  {
    return $this->personaState;
  }

  public function primaryClanId() : ?int
  {
    return $this->primaryClanId;
  }
}
