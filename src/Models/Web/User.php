<?php

namespace RistekUSDI\SSO\Laravel\Models\Web;

use RistekUSDI\SSO\Laravel\Models\User as UserModel;

class User extends UserModel
{
    /**
     * Check if user has role(s) in user's roles from client
     * @return boolean
     */
    public function hasRole($roles)
    {
        return !empty(array_intersect((array) $this->getAttribute('client_roles'), (array) $roles));
    }

    /**
     * Check if user has role active from selected roles active
     * @return boolean
     */
    public function hasRoleActive($roles)
    {
        if (!empty($roles)) {
            return (in_array($this->getAttribute('role_active'), (array) $roles)) ? true : false;
        } else {
            return true;
        }
    }

    /**
     * Check if user has permission from role active permissions
     * @return boolean
     */
    public function hasPermission($permissions)
    {
        if (!empty($permissions)) {
            return (array_intersect((array) $this->getAttribute('role_active_permissions'), (array) $permissions)) ? true : false;
        } else {
            return true;
        }
    }
}
