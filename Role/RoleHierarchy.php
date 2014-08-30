<?php
/**
 * Webiny Framework (http://www.webiny.com/framework)
 *
 * @copyright Copyright Webiny LTD
 */

namespace Webiny\Component\Security\Role;

use Webiny\Component\StdLib\StdLibTrait;
use Webiny\Component\StdLib\StdObject\ArrayObject\ArrayObject;

/**
 * Role Hierarchy class.
 * This class reads the current role hierarchy and creates an array tree of roles for easier access.
 *
 * @package         Webiny\Component\Security\Authorization\Role
 */
class RoleHierarchy
{
    use StdLibTrait;

    /**
     * @var ArrayObject
     */
    private $_map;

    /**
     * Constructor.
     *
     * @param array $hierarchy Role hierarchy array from system configuration.
     */
    function __construct($hierarchy)
    {
        $this->_buildRoleMap($hierarchy);
    }

    /**
     * Returns an array of roles that are accessible by $roles.
     *
     * @param array $roles
     *
     * @return array
     */
    public function getAccessibleRoles(array $roles)
    {
        $accessibleRoles = $roles;
        foreach ($roles as $role) {
            /**
             * @var $role Role
             */
            if (isset($this->_map[$role->getRole()])) {
                foreach ($this->_map[$role->getRole()] as $r) {
                    $accessibleRoles[] = new Role($r);
                }
            }
        }

        return $accessibleRoles;
    }

    /**
     * Private function that parses the hierarchy array and builds up a hierarchy map
     *
     * @param array $hierarchy Role hierarchy array from system configuration.
     */
    private function _buildRoleMap($hierarchy)
    {
        $this->_map = $this->arr();

        foreach ($hierarchy as $main => $roles) {
            $hierarchy[$main] = $this->arr((array)$roles);
        }

        $hierarchy = $this->arr($hierarchy);
        foreach ($hierarchy as $main => $roles) {
            $this->_map->append($main, $roles->val());
            $additionalRoles = clone $roles;
            $parsed = $this->arr();
            $role = '';

            while ($additionalRoles->count() > 0 && $additionalRoles->removeFirst($role)) {
                if (!$hierarchy->keyExists($role)) {
                    continue;
                }

                $parsed->append($role);
                $innerRole = $this->arr($this->_map->key($main));
                $innerRole->merge($hierarchy[$role]->val());
                $this->_map->append($main, $innerRole->val());
                $additionalRoles->merge($hierarchy->key($role)->diff($parsed->val())->val());
            }
        }
    }
}