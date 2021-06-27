<?php

namespace App\Http\Controllers;

use App\Http\Requests\MakeImageRequest;
use App\Notifications\NewImage;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class MakeImage extends Controller
{
    private $images = [
        'eid1.png' => ['color' => '#323A53', 'dim' => 'x=35 : y=625', 'fontsize' => '60'],
        'eid2.png' => ['color' => '#06365a', 'dim' => 'x=700 : y=800', 'fontsize' => '120'],
        'eid3.png' => ['color' => '#0193a2', 'dim' => 'x=900 : y=600', 'fontsize' => '120'],
        'eid4.png' => ['color' => '#d9dfef', 'dim' => 'x=480 : y=1150', 'fontsize' => '120']
    ];

    public function makeImage(MakeImageRequest $request)
    {


        $data = $request->validated();


        $name = $data['name'];
        $image = $data['image'];
        $image_path = public_path('/img');
        $rand = uniqid();
        $result = "$image_path/result/$rand.jpg";
        $font = storage_path('/font/BFantezy.ttf');
        $fontsize = $this->images[$image]['fontsize'];
        if (!preg_match('/[^A-Za-z0-9]/', $name)) // '/[^a-z\d]/i' should also work.
        {
            $font = storage_path('/font/Almarai-Regular.ttf');
            $fontsize = $fontsize - ($fontsize * 0.5);
        }
        $dim = $this->images[$image]['dim'];
        $color = $this->images[$image]['color'];

        if (strlen($name) > 15) {
            $fontsize = $fontsize - ($fontsize * 0.5);
        }
        exec("ffmpeg -i $image_path/$image -vf \"drawtext=text_shaping=1 : fontfile=$font:text=$name' : fontcolor=$color : fontsize=$fontsize : $dim\" $result");


        $log = ['name' => $name,
            'image' => $image];

//first parameter passed to Monolog\Logger sets the logging channel name
        $orderLog = new Logger('image');
        $orderLog->pushHandler(new StreamHandler(storage_path('logs/image.log')), Logger::INFO);
        $orderLog->info('image', $log);


        try {
            Notification::
            route('slack', '')
                ->notify(new NewImage($log));
        } catch (\Exception $e) {

        }


        return "/img/result/$rand.jpg";
    }
}
