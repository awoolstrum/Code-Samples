<?php

declare(strict_types=1);

namespace Undivided\Module\SSO\Objects;

use Undivided\Framework\Infrastructure\IIdentity;
use Undivided\Framework\Objects\ICollectable;

final class SteamName implements ICollectable
{

    private $id;
    private $realname;
    private $personaname;


  public function __construct(
    IIdentity $id,
    ?string $realname,
    ?string $personaname
    )
  {

    if($id !== null) {
      $this->id = $id;
    }
    $this->realname = $realname;
    $this->personaname = $personaname;
  }

  public function id() : IIdentity
  {
    return $this->id;
  }

  public function realname() : string
  {
    return $this->realname;
  }

  public function personaName()
  {
    return $this->personaname;
  }

  public function __toString() : string
  {
   return $this->get();
  }

  public function get() : string
  {
    return (string) $this->personaName();
  }
}
