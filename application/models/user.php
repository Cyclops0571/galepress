<?php

/**
 * @property int $UserID Description
 * @property int $UserTypeID Description
 * @property int $CustomerID Description
 * @property int $Username Description
 * @property int $FbUsername Description
 * @property int $Password Description
 * @property int $FirstName Description
 * @property int $LastName Description
 * @property int $Email Description
 * @property int $FbEmail Description
 * @property int $FbAccessToken Description
 * @property int $Timezone Description
 * @property int $PWRecoveryCode Description
 * @property int $PWRecoveryDate Description
 * @property int $StatusID Description
 * @property int $CreatorUserID Description
 * @property int $DateCreated Description
 * @property int $ProcessUserID Description
 * @property int $ProcessDate Description
 * @property int $ProcessTypeID Description
 * @property int $ConfirmCode Description
 * @property Customer $Customer Description
 */
class User extends Eloquent
{

    public static $timestamps = false;
    public static $table = 'User';
    public static $key = 'UserID';

    /**
     *
     * @return Application[]
     */
    public function Application($statusID = eStatus::Active)
    {

        if ($this->UserTypeID == eUserTypes::Manager) {
            $applications = Application::where('StatusID', '=', $statusID)->get();
        } else {
            $applications = $this->Customer()->Applications($statusID);
        }
        return $applications;
    }

    /**
     *
     * @return Customer
     */
    public function Customer()
    {
        return $this->belongs_to('Customer', 'CustomerID');
    }

    /**
     *
     * @param type $take
     * @param type $skip
     * @return Sessionn
     */
    public function Session($take = 1, $skip = 0)
    {
        $query = Sessionn::where('UserID', '=', Auth::user()->UserID)
            ->where('StatusID', '=', eStatus::Active)
            ->order_by('SessionID', 'DESC')
            ->take($take)
            ->skip($skip);
        if ($take == 1) {
            return $query->first();
        } else {
            return $query->get();
        }
    }

}
