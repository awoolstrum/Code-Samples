<?php

declare(strict_types=1);

namespace Undivided\Module\SSO\Application;

use Undivided\Framework\Context\Request;
use Undivided\Framework\Exception\ExceptionHandler;
use Undivided\Framework\Infrastructure\Application;
use Undivided\Framework\Infrastructure\Factory;
use Undivided\Framework\Payload\PayloadStatus;
use Undivided\Framework\Payload\ReadablePayloadInterface;
use Undivided\Framework\Security\Session;
use Undivided\Module\Contact\Objects\Id;
use Undivided\Module\SSO\Logic\Steam\LightOpenID;
use Undivided\Module\SSO\Objects\SteamName;
use Undivided\Module\SSO\Objects\SteamUser;

final class SteamApplication extends Application
{

  use ExceptionHandler;

  protected $provider;
  protected $session;
  protected $secrets;
  protected $step;
  protected $steamResponse;

  public function __construct() {


    $factory = new Factory();
    if($factory->include(CUSTOM_PATH.'/Secret/'.CUSTOM_PREFIX.'Steam.php')){
      $classname = '\Undivided\Secret\\'.CUSTOM_PREFIX.'Steam';
      $this->secrets = new $classname();
    }else{
      throw new \Exception("To use Steam SSO, you must set up a custom path/Secret/".
                           CUSTOM_PREFIX ."Steam.php file.");
    }

    $this->provider = $this->initializeProvider();
    $this->session = new Session();

    parent::__construct();
  }

  public function authorize(Request $request) : ReadablePayloadInterface
  {

    $this->step = 0;
    if($request->get('referringURI') !== null ){
      $this->session->set('referringURI', $request->get('referringURI'));
      $this->step = 1;
    }

    try {
      if( ! $this->provider->mode ) {

        $this->provider->identity = 'https://steamcommunity.com/openid';
        $this->step = 2;
        header('Location: ' . $this->provider->authUrl());

      } elseif ($this->provider->mode == 'cancel') {

        $this->step = 3;
        echo 'User has canceled authentication!';

      } else {
        $this->step = 4;
        if($this->provider->validate()) {
          $id = $this->provider->identity;
          $ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
          preg_match($ptn, $id, $matches);

          $steam64 = (int)$matches[1];
          $_SESSION['steamid'] = $matches[1];
          $this->step = 5;

          $this->payload->set( $this->getResourceOwner($steam64) );
          $this->payload->setStatus(PayloadStatus::FOUND);
          $this->step = 6;
          return $this->payload;
        } else {
          $this->step = 7;
          $this->payload->setStatus(PayloadStatus::NOT_AUTHENTICATED);
          $this->notAuthenticatedResponse("There was an issue logging in with Steam. 
           The user is not logged in.\n");
        }
      }
    } catch (\Throwable $ex) {
      return $this->error($ex, [
        'steam64' => 'session: '. json_encode($_SESSION),
        'referringURI' => 'referring uri: '.$request->get('referringURI'),
        'request' => 'request: '.$request->__toString(),
        'payloadOutput' => 'output: '. json_encode($this->payload->getOutput()),
        'payloadMessages' => 'msgs: '. json_encode($this->payload->getMessages()),
        'step' => 'step: '.$this->step,
        'steamResponse' => 'steam response: '.json_encode($this->steamResponse)
      ]);
    }
    $this->payload->setStatus(PayloadStatus::FOUND);
    $this->payload->setOutput("Complete");
    return $this->payload;
  }

  public function initializeProvider() : LightOpenID
  {
    return new LightOpenID(strtolower(WEBSITE_PATH));
  }

  public function getResourceOwner( int $steam64 ) : ?SteamUser
  {
    $this->step = 5.1;
    $url = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" .
                             $this->secrets::API_KEY . "&steamids=" . $steam64);

    $this->step = 5.2;
    $content = json_decode($url, true);

    $this->steamResponse = $content['response']['players'][0];

    if( ! isset($this->steamResponse['steamid'])){
      throw new \Exception("We did not get the steamid from Valve.");
    }

    $this->step = 5.3;
    $id = new Id();
    $steamUser = new SteamUser(
      $id->new(),
      (int) $this->steamResponse['steamid'],
      (isset($this->steamResponse['communityvisibilitystate'])) ? $this->steamResponse['communityvisibilitystate'] : null,
      (isset($this->steamResponse['profilestate'])) ? $this->steamResponse['profilestate'] : null,
      (isset($this->steamResponse['lastlogoff'])) ? (int) $this->steamResponse['lastlogoff'] : 0,
      (isset($this->steamResponse['profileurl'])) ? (string) $this->steamResponse['profileurl'] : "",
      (isset($this->steamResponse['avatar'])) ? (string) $this->steamResponse['avatar'] : "",
      (isset($this->steamResponse['avatarmedium'])) ? (string) $this->steamResponse['avatarmedium'] : "",
      (isset($this->steamResponse['avatarfull'])) ? (string) $this->steamResponse['avatarfull'] : "",
      (isset($this->steamResponse['personastate'])) ? $this->steamResponse['personastate'] : null,
      (isset($this->steamResponse['primaryclanid']) && is_int($this->steamResponse['primaryclanid'])) ? $this->steamResponse['primaryclanid'] : null,
      (isset($this->steamResponse['timecreated'])) ? (int) $this->steamResponse['timecreated'] : null,
      (isset($this->steamResponse['uptodate'])) ? (int) $this->steamResponse['uptodate'] : null
    );

    $this->step = 5.4;
    if(! isset($this->steamResponse['realname'])) $this->steamResponse['realname'] = '';
    if(! isset($this->steamResponse['personaname'])) $this->steamResponse['personaname'] = '';
    $name = new SteamName($id, $this->steamResponse['realname'] ?? "", $this->steamResponse['personaname'] ?? "");
    $steamUser->addName($name);

    $this->step = 5.5;
    $this->session->set('SteamUser', $steamUser);

    return $steamUser;
  }
}