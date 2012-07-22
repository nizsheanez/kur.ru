<?
 
class WebUser extends CWebUser
{
    private $_model = null;

    private static $_role;

    public function getRole()
    {	
        if (self::$_role == null)
        {
            if($user = $this->getModel())
            {
                self::$_role = $user->role->name;
            }
            else
            {
                self::$_role = AuthItem::ROLE_GUEST;
            }
        }

        return self::$_role;
    }


    public static function setRole($role)
    {
        self::$_role = $role;
    }


    public function isRootRole()
    {
        if($user = $this->getModel())
        {
            return $user->isRootRole();
        }
    }


    public function getModel()
    {
        if (!$this->isGuest && $this->_model === null)
        {
            $this->_model = User::model()->findByPk($this->id);
        }

        return $this->_model;
    }


    public function checkAccess($auth_item, $params=array(), $allowCaching=true)
    {
        return true;
    }
}
