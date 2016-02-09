<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Регистрация пользователя
 */
class RegForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string', 'max' => 100] 
        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        // Создаем объект пользователя
        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        
        return $user->save() ? Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0) : false;
    }
}
