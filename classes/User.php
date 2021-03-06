<?php

class User {

    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct($user = null) {
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);

                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    $this->logout();
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function update($fields = array(), $id = null) {

        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->id_user;
        }

        if (!$this->_db->update('users', $id, $fields)) {
            throw new Exception('There was a problem updating.');
        }
    }

    public function create($fields = array()) {
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception('There was a problem creating an account');
        }
    }

    public function find($user = null) {
        if ($user) {
            $field = (is_numeric($user)) ? 'id_user' : 'email';
            $data = $this->_db->get('users', array($field, '=', $user));

            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function login($email = null, $password = null, $remember = false) {
        if (!$email && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->id_user);
        } else {
            $user = $this->find($email);
            if ($user) {
                if (password_verify($password, $this->data()->password)) {
                    Session::put($this->_sessionName, $this->data()->id_user);

                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', array('id_user', '=', $this->data()->id_user));

                        if (!$hashCheck->count()) {
                            $this->_db->insert('users_session', array(
                                'id_user' => $this->data()->id_user,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));

                    }

                    return true;
                }
            }
        }

        return false;
    }

    public function hasPermission($key) {
        $group = $this->_db->get('groups', array('id_group', '=', $this->data()->id_group));

        if ($group->count()) {
            $permissions = json_decode($group->first()->permissions, true);

            if ($permissions[$key] == true) {
                return true;
            }
        }
        return false;
    }

    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }

    public function logout() {

        $this->_db->delete('users_session', array('id_user', '=', $this->data()->id_user));

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public function data() {
        return $this->_data;
    }

    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }

    public function getName() {
        if ($this->data()->first_name && $this->data()->middle_name && $this->data()->last_name) {
            return "{$this->data()->first_name} {$this->data()->middle_name} {$this->data()->last_name}";
        }

        if ($this->data()->first_name && $this->data()->last_name) {
            return "{$this->data()->first_name} {$this->data()->last_name}";
        }

        if ($this->data()->first_name) {
            return $this->data()->first_name;
        }

        return null;
    }

    public function getNameOrUsername() {
        return $this->getName() ?: $this->data()->username;
    }

    public function getFirstNameOrUsername() {
        return $this->data()->first_name ?: $this->data()->username;
    }

}