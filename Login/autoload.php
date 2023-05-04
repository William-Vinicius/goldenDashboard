<?php 

spl_autoload_register(
    function($filename){

        if(file_exists('registrations/' . $filename . '.php')){
            require 'registrations/' . $filename . '.php';
        }
        elseif(file_exists('graphs/' . $filename . '.php')){
            require 'graphs/' . $filename . '.php';
        }
        elseif(file_exists('header/' . $filename . '.php')){
            require 'header/' . $filename . '.php';
        }
        elseif(file_exists('classes/' . $filename . '.php')){
            require 'classes/' . $filename . '.php';
        }

        
        elseif(file_exists('../registrations/' . $filename . '.php')){
            require 'registrations/' . $filename . '.php';
        }
        elseif(file_exists('../graphs/' . $filename . '.php')){
            require 'graphs/' . $filename . '.php';
        }
        elseif(file_exists('../header/' . $filename . '.php')){
            require 'header/' . $filename . '.php';
        }
        elseif(file_exists('../classes/' . $filename . '.php')){
            require 'classes/' . $filename . '.php';
        }
        
    }
);
