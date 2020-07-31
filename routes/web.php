<?php

use Illuminate\Support\Facades\Route;

const FILE_CONFIG = 'configs';

Route::view('/offline', 'offline');

Route::get('/', function(){

    $ratbagctlVersion = trim(shell_exec("ratbagctl -V"));

    if(!version_compare("0.9.905", $ratbagctlVersion, '>=')){

        return view('home');

    } else {

        return view('install');

    }

});

Route::get('/colors/{mouseId}', function($mouseId){

    $colorConfig = shell_exec("ratbagctl $mouseId led get");

    preg_match('/color: (.*)/', $colorConfig, $match);

    $colors = collect(unserialize(file_get_contents(storage_path(FILE_CONFIG))));

    if(count($match) > 1){
        $colors[] = ['hex' => "#{$match[1]}", 'selected' => true];
    }

    return response()->json($colors->keyBy->hex->values());

});

Route::get('/mouses', function(){

    $mouses = collect(explode("\n", shell_exec('ratbagctl')))->filter()->values()->map(function($mouse, $k){

        preg_match('/(.*):(.*)/', $mouse, $data);

        if(count($data) != 3) return null;

        return [
            'id' => $data[1],
            'name' => trim($data[2]),
            'selected' => $k == 0
        ];

    })->filter();

    return response()->json($mouses);

});

Route::post('/update', function(){

    $data = (object) request()->all();

    if(isset($data->mouse)){

        $cmd = collect();

        $mouse = $data->mouse['id'];

        if(isset($data->color)){

            $data->color = str_replace("#", "", $data->color['hex']);
            $cmd[] = "color {$data->color}";

        }

        if(isset($data->mode)){

            if($data->mode == 'on' && isset($data->brightness) && $data->brightness < 255){
                $data->mode = 'breathing';
                $data->duration = 5;
            }

            if(isset($data->brightness) && $data->brightness == 0){
                $data->mode = 'off';
            }

            $cmd[] = "mode {$data->mode}";

        }

        if(isset($data->duration)){

            $cmd[] = "duration {$data->duration}";

        }

        if(isset($data->brightness)){

            $cmd[] = "brightness {$data->brightness}";

        }

        shell_exec("ratbagctl $mouse led 0 set {$cmd->implode(" ")}");

        if(isset($data->dpi)){

            shell_exec("ratbagctl $mouse dpi set {$data->dpi}");

        }

    }

});

Route::post('/set-colors', function(){

    $colors = collect(request('colors'))->map(function($color){
        $color['selected'] = false;
        return $color;
    });

    file_put_contents(storage_path(FILE_CONFIG), serialize($colors->toArray()));

});
