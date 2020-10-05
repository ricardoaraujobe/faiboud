<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!function_exists('extract_rgb')) {

    function extract_red($valor) {

        $red = substr($valor, -6, 2);
        return $red;
    }

    function extract_green($valor) {

        $green = substr($valor, -4, 2);
        return $green;
    }

    function extract_blue($valor) {

        $blue = substr($valor, -2, 2);
        return $blue;
    }

    function compara_cores($num1, $num2, $precisao = 7) {
        $desprezar = pow(0.1, $precisao);
        $diff = abs($num1 - $num2);
        if ($diff < $desprezar) {
            return 0;
        }
        return $num1 < $num2 ? -1 : 1;
    }
    
    function calcula_distancia($cor_tecnica_final, $valor_pref, $peso_r, $peso_g, $peso_b, $peso_cor){
        
        $resultado=sqrt(pow(abs(hexdec(extract_red($cor_tecnica_final)) - hexdec(extract_red($valor_pref))),2) * $peso_r +
                                    pow(abs(hexdec(extract_green($cor_tecnica_final)) - hexdec(extract_green($valor_pref))),2) * $peso_g +
                                    pow(abs(hexdec(extract_blue($cor_tecnica_final)) - hexdec(extract_blue($valor_pref))),2) * $peso_b) * $peso_cor;
        
        return $resultado;
    }
    function calcula_distancia_sem_peso($cor_tecnica_final, $valor_pref, $peso_r, $peso_g, $peso_b, $peso_cor){
        
        $resultado=sqrt(pow(abs(hexdec(extract_red($cor_tecnica_final)) - hexdec(extract_red($valor_pref))),2) +
                                    pow(abs(hexdec(extract_green($cor_tecnica_final)) - hexdec(extract_green($valor_pref))),2) +
                                    pow(abs(hexdec(extract_blue($cor_tecnica_final)) - hexdec(extract_blue($valor_pref))),2) ) ;
        
        return $resultado;
    }

}
