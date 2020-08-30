<?php

declare(strict_types=1);

namespace Undivided\Module\SSO\Action\SteamAuthorize;

use Undivided\Framework\Helpers\Url;
use Undivided\Framework\Responder\ApiResponder;
use Undivided\Framework\Responder\IResponse;
use Undivided\Framework\Security\Session;

final class Responder extends ApiResponder
{
    public function found() : IResponse
    {
      $session = new Session();
        // SSO OAuth responses do not follow JSON Api specification
      if(
        $session->get('referringURI') !== null
        && $session->get('SteamUser') !== null
      ) {
        $r = $session->get('referringURI');
        $session->unset('referringURI');
        Url::redirect(WEBSITE_PATH.$r );
      }
        return $this;
    }
}
