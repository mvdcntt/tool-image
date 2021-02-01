<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageToolController extends Controller
{
    public function index()
    {
        return view('tool-image.index');
    }

    public function upload(Request $request)
    {
        $image = $request->file('image');
        if ($image) {
            $path = $image->getRealPath();
            $name = $image->getClientOriginalName();
            $ext = $image->getClientOriginalExtension();
            $name = str_replace( '.' . $ext, '', $name);

            $targetPath = public_path('/converted') . '/' . $name;

            if (! File::isDirectory(public_path('/converted'))) {
                File::makeDirectory(public_path('/converted'));
            }

            if (! File::isDirectory(public_path('/converted/' . $name))) {
                File::makeDirectory(public_path('/converted/' . $name));
            }

            shell_exec("convert {$path} -bordercolor none -border 1 -background white -alpha background -bordercolor white " . $targetPath . '/image_border.png');
            shell_exec("convert " . $targetPath . '/image_border.png' . " -alpha off -negate -threshold 0 -type bilevel " . $targetPath . '/image_border0.png');
            $old_path = getcwd();
            chdir(public_path('scripts'));
            shell_exec('bash script.sh ' .  $targetPath);
            chdir($old_path);
        }
    }
}
