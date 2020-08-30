<?php

declare(strict_types=1);

namespace Undivided\Module\SSO\Action\SteamAuthorize;

use Undivided\Framework\Infrastructure\BaseController;
use Undivided\Framework\Responder\IResponse;
use Undivided\Framework\Security\Session;
use Undivided\Module\SSO\Application\SteamApplication;

final class Action extends BaseController
{
  private $service;

  public function __construct() {
    $this->service   = new SteamApplication();
    $this->responder = new Responder();
    $this->session = new Session();
  }

  public function index() : IResponse
  {
    $payload = $this->service->authorize($this->request);
    return ($this->responder)($payload);
  }
}
