<?php

function get_request_field_array($fields, $req = FALSE)
{
    $request = json_decode(@file_get_contents("php://input"), true);
    if (empty($request) && $req !== FALSE) {
        return get_request_field_array_by_post($fields, $req);
    }
    $data = array();
    foreach ($fields as $field) {
        if (! empty($request[$field])) {
            $data[$field] = $request[$field];
        }
    }
    return $data;
}
function get_request_field_array_by_post($fields, $request) {
    $data = array();
    foreach ($fields as $field) {
        $value = $request-> input->post($field);
        if (! empty($value)) {
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
        $limit = 10;
    }
    return array('begin' => ($page - 1) * $limit, 'end' => $page * $limit);
}

