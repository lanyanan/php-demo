<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config = array(
    'signup' => array(
        array(
            'field' => 'nick_name',
            'label' => '昵称',
            'rules' => 'required'
        ),
        array(
            'field' => 'login_name',
            'label' => '登录名',
            'rules' => 'required'
        ),
        array(
            'field' => 'password',
            'label' => '密码',
            'rules' => 'required'
        ),
        array(
            'field' => 'passconf',
            'label' => '确认密码',
            'rules' => 'required|matches[password]'
        ),
        array(
            'field' => 'user_sex',
            'label' => '用户性别',
            'rules' => 'required'
        ),
        array(
            'field' => 'mobile',
            'label' => '手机号',
            'rules' => 'required'
        )
    ),
    'editUser' => array(
        array(
            'field' => 'nick_name',
            'label' => '昵称',
            'rules' => 'required'
        ),
        array(
            'field' => 'user_sex',
            'label' => '用户性别',
            'rules' => 'required'
        ),
        array(
            'field' => 'mobile',
            'label' => '手机号',
            'rules' => 'required'
        )
    ),
    'email' => array(
        array(
            'field' => 'emailaddress',
            'label' => 'EmailAddress',
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|alpha'
        ),
        array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'required'
        ),
        array(
            'field' => 'message',
            'label' => 'MessageBody',
            'rules' => 'required'
        )
    )
);