<?php
namespace app\models;

class User extends AddModel
{
    protected $id;
    protected $login;
    protected $email;
    protected $password;
    public $pass_repeat;

    public function tableName()
    {
        return 'user';
    }

    public function passwordValid()
    {
        return $this->password == $this->pass_repeat;
    }

    public function passwordVerify($password)
    {
        return password_verify($password, $this->password);
    }

    public function passwordHash()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function getUser()
    {
        return User::findOne(['login' => $this->login]);
    }

    public function reg()
    {
        if($this->passwordValid()){
            if( !$this->getUser() ){
                $this->passwordHash();
                if( $this->save() ){
                    return $this;
                }
            } else {
                return 'Пользователь с таким логиком уже зарегистирован.';
            }
        } else {
            return 'Пароли не совпадают';
        }
    }
}