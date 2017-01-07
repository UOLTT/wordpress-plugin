<?php
/**
 * Created by PhpStorm.
 * User: judah
 * Date: 1/7/17
 * Time: 9:56 AM
 */

function pp($DataToPrint,$function='print_r',$cli=false) {
    if (!$cli) {
        print "<pre>";
    }
    $function($DataToPrint);
    if (!$cli) {
        print "</pre>";
    }
}