<?php

function connectRedis() {
    $redis = new Redis;
    $redis->connect('172.17.0.3', 6379);
    return $redis;
}

function saveRequestIpForLike($id, $table) {
    $redis = connectRedis();
    $key = $table.'_'.$id;
    $redis->sAdd($key, ip()); 
}

function getLikeByArray($dataArray, $table = NULL) {
    foreach($dataArray as  $key=>$value) {
        if (empty($table)) {
            if ($dataArray[$key]['res_type'] == '0') {
                $table = "res_video";
            }else {
                $table = "res_album";
            }
        }
        $dataArray[$key] = getLike($dataArray[$key], $table);
    }
    return $dataArray;
}

function getLike($data, $table) {
    $key = $table.'_'.$data['id'];
    $redis = connectRedis();
    $like_count = strval($redis->sCard($key));
    if (empty($like_count)) {
        $data['like_count'] = '0';
    } else {
        $data['like_count'] = $like_count;
    }
    $data['like_count'] = $like_count;
    $data['isLike'] =  strval($redis->sIsMember($key,ip()));
//     echo json_encode($data);
    return $data;
}

function ip() {
    //strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
}

function get_request_field_array($fields, $req = FALSE)
{
    $request = json_decode(file_get_contents("php://input"), true);
    
    if (empty($request) && $req !== FALSE) {
        return get_request_field_array_by_post($fields, $req);
    }
    $data = array();
    foreach ($fields as $field) {
        if (!empty($request) && is_array($request) && array_key_exists($field, $request) && $request[$field] != NULL) {
            $data[$field] = $request[$field];
        }
    }
    return $data;
}

function get_request_field_array_by_post($fields, $request) {
    $data = array();
    foreach ($fields as $field) {
        $value = $request-> input->post($field);
        if ($value != NULL) {
            $data[$field] = $value;
        }
    }
    return $data;
}

function get_request_field_array_by_get($fields, $request) {
    $data = array();
    foreach ($fields as $field) {
        $value = $request-> input->get($field);
        if ($value != NULL) {
            $data[$field] = $value;
        }
    }
    return $data;
}

function get_limit($request) {
    $page = $request-> input->get('page');
    if (empty($page)) {
        $page = 1;
    }
    $limit = $request-> input->get('limit');
    if (empty($limit)) {
        $limit =10;
    }
    return array('begin' => ($page - 1) * $limit, 'limit' => $limit);
}

