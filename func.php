<?php

session_start();

$action = isset($_POST['action']) ? $_POST['action'] : 'get';

$event = isset($_POST['event']) ? json_decode($_POST['event'], true) : '';
$delete = isset($_GET['delete']) ? 1 : 0;
$id = isset($_POST['id']) ? $_POST['id'] : 0;

$file = $_SERVER['DOCUMENT_ROOT'] . '/events/event.txt';


if($action == 'get') {
    echo get();
} elseif($action == 'save') {
    save();
} elseif($action == 'check') {
    echo check();
} elseif($action == 'delete') {
    echo delete();
}

function save()
{
    global $event, $file;
    
    if(count($event)) {
        
        $event['id'] = time() . rand(1000, 9999);
        
        if(file_exists($file)) {
            $current = file_get_contents($file);
            
            $currentJson = json_decode($current, true);

            if($currentJson) {
                
                $currentJson = array_merge($currentJson, [$event]);
            } else {
                $currentJson = [$event];
            }
        } else {
            $currentJson = [$event];
        }
        
        
        
        try {
            
            $to = "t.meglenchev@gmail.com";
            $subject = "Запазване на репетиционна";
            $message = "Здравейте имате нова резервация: 
                        Име: " . $event['title'] . '
                        Телефон: ' . $event['phone'] . ' 
                        Дата: ' . date('d.m.Y H:i', strtotime($event['start'])) . ' 
                        Краен час: ' . date('H:i', strtotime($event['end']));
            
            mail($to, $subject, $message);
        } catch (Exception $e) {
            
        }
        
        
        file_put_contents($file, json_encode($currentJson));
    }
}

function get()
{
    
    global $file;
    
    $current = '';
    
    if(file_exists($file)) {
        $current = file_get_contents($file);
    }

    return $current;
}

function delete()
{
    global $id, $file;

    if($id) {
        
        if(file_exists($file)) {
            $current = file_get_contents($file);
            
            $currentJson = json_decode($current, true);
            
            if($currentJson) {
                
                foreach ($currentJson as $key => $item) {
                    if($item['id'] == $id) {
                        unset($currentJson[$key]);
                        
                        break;
                    }
                }
                
                file_put_contents($file, json_encode($currentJson));
            }
        }
    }
}
function check()
{
    global $event, $file;
    
    $captcha = trim($_POST['captcha']);
    
    if (!isset($_SESSION['captcha']) || strtolower($captcha) !== strtolower($_SESSION['captcha'])) {
        return 'Невалидна код';
        
        exit;
    }
    
    if(count($event)) {
        
        $eventStartDate = strtotime($event['start']);
        $eventEndDate = strtotime($event['end']);
        
        if($eventStartDate >= $eventEndDate) {
            return 'Крайният час е по-малък от началния час';
            
            exit;
        }
        
        if(file_exists($file)) {
            $current = file_get_contents($file);
            
            $currentJson = json_decode($current, true);
            
            if($currentJson) {
                
                foreach ($currentJson as $item) {
                    $dateStart = strtotime($item['start']);
                    $dateEnd = strtotime($item['end']);
                    
                    if($dateStart < $eventEndDate && $dateEnd > $eventStartDate) {
                        return 'В този интервал вече има събитие';
                        
                        exit;
                    }
                }
            }
        }
    }
    
    return '';
}