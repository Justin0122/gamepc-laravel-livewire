<?php

namespace App;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AuditTrail as AT;

class AuditTrail
{


    private static function createLogEntry($table, $partId, $action, $field, $oldValue, $newValue)
    {
        $userId = Auth::id();
        AT::create([
            'action' => $action,
            'partId' => $partId,
            'FKUserId' => $userId,
            'table_name' => $table,
            'field_name' => $field,
            'old_value' => $oldValue,
            'new_value' => $newValue,
        ]);
    }

    public static function logTransactionCreate($input, string $tableName, $id = null)
    {

            self::createLogEntry($tableName, $id, 'Ordered', 'all', null, 'all');

    }

    public static function logCreate($input, string $tableName, $id = null)
    {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                self::createLogEntry($tableName, $id, 'Create', $key, null, $value);
            }
        } else {
            self::createLogEntry($tableName, $id, 'Create', 'all', null, $input);
        }
    }

    public static function logUpdate($input, string $tableName, $id, $model = null)
    {

        $sql = "SELECT * FROM " . "`" . strtolower($tableName) . "s`" . " WHERE id = " . $id;

        $result = (new AuditTrail)->sql($sql, $tableName, $id, $model);

        if ($result) {
            $oldValue = $result->getAttributes();
            array_pop($oldValue);
            array_pop($oldValue);
            array_pop($oldValue);

            foreach ($oldValue as $key => $value) {
                //skip the keys that aren't set
                if (!isset($input[$key])) {
                    continue;
                }
                self::createLogEntry($tableName, $id, 'Update', $key, $value, $input[$key]);
            }
        }
    }

    public static function logDelete(string $tableName, $id)
    {
        self::createLogEntry($tableName, $id, 'Deleted', 'all', $id, null);
    }

    public static function logRestore(string $tableName, $id)
    {
        self::createLogEntry($tableName, $id, 'Restored', 'all', null, $id);
    }

    public static function logUserRegister()
    {
        $lastUser = DB::table('users')->latest('id')->first();
        $id = $lastUser->id;

        self::createLogEntry('users', $id, 'Registered', 'all', null, $id);
    }

    public static function logUserUpdateBasic($input)
    {
        $sql = "SELECT * FROM `users`" . " WHERE Id = " . Auth::user()->id;

        $result = (new AuditTrail)->sqlUser($sql);
        $oldValue = $result->getAttributes();

        array_pop($oldValue);
        array_pop($oldValue);
        array_pop($oldValue);

        unset($oldValue['password']);
        unset($oldValue['two_factor_secret']);
        unset($oldValue['two_factor_recovery_codes']);
        unset($oldValue['remember_token']);

        foreach ($oldValue as $key => $value) {
            if ($input[$key] != $value) {
                self::createLogEntry('users', Auth::user()->id, 'Updated User', $key, $value, $input[$key]);
            }

        }
    }

    public static function logUserUpdateAddress($input)
    {
        $sql = "SELECT city, street, house_number, postcode FROM `users`" . " WHERE Id = " . Auth::user()->id;

        $result = (new AuditTrail)->sqlUser($sql);
        $oldValue = $result->getAttributes();
        $array = array_slice($oldValue, 11, 4, true);

        array_pop($oldValue);
        array_pop($oldValue);
        array_pop($oldValue);
        unset($oldValue['password']);
        unset($oldValue['two_factor_secret']);
        unset($oldValue['two_factor_recovery_codes']);
        unset($oldValue['remember_token']);

        foreach ($array as $key => $value) {
            if ($input[$key] != $value) {

                self::createLogEntry('users', Auth::user()->id, 'Updated User', $key, $value, $input[$key]);
            }

        }

    }

    public static function logUserDelete()
    {
        self::createLogEntry('users', Auth::user()->id, 'Deleted User', 'all', Auth::user()->id, null);
    }


    private function sql($sql, $modelName, $partId, $model = null)
    {
        $connection = app('db')->connection();
        if ($model) {
            $modelClass = 'App\\Models\\' . $model;
        } else {
            $modelClass = 'App\\Models\\Parts\\' . ucfirst($modelName);
        }
        $part = $modelClass::withTrashed()->find($partId);
        $connection->statement($sql);
        return $part;
    }

    private function sqlUser($sql)
    {
        $connection = app('db')->connection();
        $user = User::withTrashed()->find(Auth::user()->id);
        $connection->statement($sql);
        return $user;
    }
}
