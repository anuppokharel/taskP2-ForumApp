<?php
error_reporting(E_ERROR);
    function verifyForm($method, $name) {
        if(isset($method[$name]) && !empty($method[$name]) && trim($method[$name])) {
            return true;
        } else {
            return false;
        }
    }

    function checkError($error, $name) {
        $msg = '';
        if(isset($error[$name])) {
            $msg = '<b><span class="error">' . $error[$name] . '.</span></b>';
        }
        return $msg;
    }
?>