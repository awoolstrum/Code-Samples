<?php

declare(strict_types=1);

namespace Undivided\Module\SSO\Repository;

use Undivided\Framework\Helpers\DateHelper;
use Undivided\Framework\Repository\UuidField;
use Undivided\Framework\Repository\Repository;
use Undivided\Module\SSO\Logic\Steam\SteamTransform;
use Undivided\Module\SSO\Objects\SteamUser;

final class SteamRepository extends Repository
{

  use UuidField;

  /**
   * @var SteamTransform
   */
  private $transform;

  public function __construct() {
     parent::__construct();
     $this->transform = new SteamTransform();
  }

  public function getSteam($steamId) : ?SteamUser
  {

    $sql = $this->stmt->table('steam' );

    $sql->where( 'steamId', 'steam' )->eq( $steamId );

    $this->getWhere( $sql );

    return $this->transform->mapResultToSteamUser($this->resultArray( $this->query->find( $sql ) ));
  }

  protected function getWhere( &$sql, $params = array() )
  {

    if( isset($params['userId']) && $this->className('userId') == 'Id' ) {
      $sql->where( 'userId', 'user' )->eq( $this->uuidStringToBytes( $params['userId']->toString() ) );
    }

    if( isset($params['isActive']) && $params['isActive'] !== false )
      $sql->where('isActive', 'user' )->eq( 1 );

    if( isset( $params['limit'] ) && $params['limit'] !== false )
      $sql->limit( $params['limit'] );
    elseif( ! isset( $params['limit'] ) )
      $sql->limit( 1 );
  }

  public function setSteam( array $set, $where = array() ) : void
  {

    $stmt = $this->stmt->table( 'steam' );

    if(isset($set['id'])) {
      $stmt->setIsset( 'id', $this->uuidStringToBytes($set['id']->toString() ) );
    }
    if(isset($set['userId'])) {
      $stmt->setIsset( 'userId', $this->uuidStringToBytes($set['userId']->toString() ) );
    }

    $stmt
      //			->setIsset( 'registrationDate', $set['registrationDate'] )
      ->setIsset( 'steamId', $set['steamId'] ?? null)
      ->setIsset( 'visibilityState', $set['visibilityState'] ?? null)
      ->setIsset( 'profileState', $set['profileState'] ?? null)
      ->setIsset( 'lastLogoff', DateHelper::sqlDateFormat($set['lastLogoff'] ?? null))
      ->setIsset( 'profileUrl', $set['profileUrl'] ?? null)
      ->setIsset( 'avatar', $set['avatar'] ?? null)
      ->setIsset( 'avatarMedium', $set['avatarMedium'] ?? null)
      ->setIsset( 'avatarFull', $set['avatarFull'] ?? null)
      ->setIsset( 'personaState', $set['personaState'] ?? null)
      ->setIsset( 'primaryClanId', $set['primaryClanId']?? null )
      ->setIsset( 'timeUpdated', DateHelper::sqlDateFormat() )
      ->setIsset( 'lastResourceCall', $set['lastResourceCall'] ?? null );

    if(empty($where)) {
      $stmt->set('timeCreated', DateHelper::sqlDateFormat());
    }

    if( isset( $where['id'] ) )
      $stmt->where('id')->eq( $this->uuidStringToBytes( $where['id']->toString() ) );

    if( isset( $where['steamId'] ) )
      $stmt->where('steamId')->eq( $where['steamId']);

    if( isset( $where['userId'] ) )
      $stmt->where('userId')->eq( $this->uuidStringToBytes( $where['userId']->toString() ) );

    $this->query->update( $stmt );
  }


  public function setSteamName( array $set, $where = array() ) : void
  {

    $stmt = $this->stmt->table( 'steamName' );

    if(isset($set['id'])) {
      $stmt->setIsset( 'id', $this->uuidStringToBytes($set['id']->toString() ) );
    }

    $stmt
      //			->setIsset( 'registrationDate', $set['registrationDate'] )
      ->setIsset( 'realname', $set['realname'] ?? null)
      ->setIsset( 'personaName', $set['personaName'] ?? null);

    if( isset( $where['id'] ) )
      $stmt->where('id')->eq( $this->uuidStringToBytes( $where['id']->toString() ) );

    $this->query->update( $stmt );
  }
}
