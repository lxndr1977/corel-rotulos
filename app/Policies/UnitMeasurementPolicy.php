<?php

namespace App\Policies;

use App\Models\UnitMeasurement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UnitMeasurementPolicy
{
   /**
    * Determine whether the user can view any models.
    */
   public function viewAny(User $user): bool
   {
      return $user->isSuperAdmin() || $user->isAdmin() || $user->isUser();
   }

   /**
    * Determine whether the user can view the model.
    */
   public function view(User $user, UnitMeasurement $unitMeasurement): bool
   {
      return $user->isSuperAdmin() || $user->isAdmin() || $user->isUser();
   }

   /**
    * Determine whether the user can create models.
    */
   public function create(User $user): bool
   {
      return $user->isSuperAdmin() || $user->isAdmin() || $user->isUser();
   }

   /**
    * Determine whether the user can update the model.
    */
   public function update(User $user, UnitMeasurement $unitMeasurement): bool
   {
      return $user->isSuperAdmin() || $user->isAdmin() || $user->isUser();
   }

   /**
    * Determine whether the user can delete the model.
    */
   public function delete(User $user, UnitMeasurement $unitMeasurement): bool
   {
      return $user->isSuperAdmin() || $user->isAdmin() || $user->isUser();
   }

   /**
    * Determine whether the user can restore the model.
    */
   public function restore(User $user, UnitMeasurement $unitMeasurement): bool
   {
      return $user->isSuperAdmin() || $user->isAdmin() || $user->isUser();
   }

   /**
    * Determine whether the user can permanently delete the model.
    */
   public function forceDelete(User $user, UnitMeasurement $unitMeasurement): bool
   {
      return $user->isSuperAdmin() || $user->isAdmin() || $user->isUser();
   }
}
