<?php

namespace App\Services;

use App\Models\User;
use App\Enum\Roles;
/**
 *
 */
class SystemStatutes
{

  /**
   * Возвращает true, если в системе больше одного Leader.
   * @return boolean
   */
  public static function isNotLastLeader()
  {
      return User::active()->where('role', Roles::LEADER)->count() > 1;
  }

  /**
   * Проверяет, можно ли изменить роль пользователя, чтобы не оставить систему без Leader
   * @param  integer $userId        ID пользователя системы, которого изменяют
   * @param  \App\Enum\Roles $role  Новая роль в системе
   * @param  boolean $blockStatus   Новое состояние блокировки
   * @return boolean
   */
  public static function canChangeRole($userId, $role, $blockStatus)
  {
    return !self::isNotLastLeader() && ($blockStatus || $role != Roles::LEADER) && $userId == \Auth::user()->id;
  }

}
