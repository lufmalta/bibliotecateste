<?php

namespace App\Models;

use App\Enums\GroupEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * Model da entidade grupos (groups).
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 14/01/2025 
 * @version 1.0.0
 */
class Group extends Model {

    protected $table = "groups";
    public $timestamps = false;

    private $permissions = [
        GroupEnum::ADMIN => ['users.*', 'books.*', 'lending-books.*'],
        GroupEnum::ATTENDANT => ['books.*', 'lending-books.*'],
        GroupEnum::LIBRARY_USER => ['loans.list']
    ];

    /**
     * Verifica se o grupo do usuário que esta acessando possui permissão para acesso.
     *
     * @param [type] $permission
     * @return boolean
     */
    public function verifyPermission($permission) {

        $allowedPermissions = $this->permissions[$this->id];

        $permissionParts = explode('.', $permission);

        //Verifica se possui a permissão, ou se possui todas as permissões na permissão informada.
        if (in_array($permission, $allowedPermissions) || in_array($permissionParts[0].".*", $allowedPermissions)) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Obtém as permissões do grupo pela regra informada.
     * @param String $groupPermission
     * @param array $permissions
     */
    public function getAllPermissions($groupPermission, $permissions = []) {

        //Verifica se existem permissões informadas.
        if (count($permissions)) {

            $variables = [];

            //Lista as permissões
            foreach ($permissions as $permission) {

                $words = explode('-', $permission);

                if (count($words) == 1) {

                    //Constroi a string.
                    $string = 'can'.ucfirst($permission);

                } else {

                    foreach ($words as $w => $word) {
                        $words[$w] = ucfirst($word);
                    }

                    //Constroi a string.
                    $string = 'can'.implode('', $words);

                }

                $variables[$string] = $this->verifyPermission($groupPermission.'.'.$permission);

            }

        } else {

            //Obtém as permissões padrão.
            $variables = [
                'canInsert' => $this->verifyPermission($groupPermission.'.insert'),
                'canUpdate' => $this->verifyPermission($groupPermission.'.update'),
                'canDelete' => $this->verifyPermission($groupPermission.'.delete')
            ];

        }

        return $variables;

    }
    
}
