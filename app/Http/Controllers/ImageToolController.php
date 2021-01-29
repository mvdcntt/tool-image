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
            $name = $image->getClientOriginalName();
            $ext = $image->getClientOriginalExtension();

            $nameNoExt = str_replace($ext, '', $name);
            $nameNoExt = str_replace('.', '', $nameNoExt);

            $mime = $image->getMimeType();
            if ($mime != 'image/png') {
                return;
            }
            $path = $image->getRealPath();
            shell_exec("convert {$path} -bordercolor none -border 1 -background white -alpha background -bordercolor white " . public_path('converted/image_border.png'));
            shell_exec("convert " . public_path('converted/image_border.png') . " -alpha off -negate -threshold 0 -type bilevel " . public_path('converted/image_border0.png'));
            $old_path = getcwd();
            $target_path = public_path('/converted/' . $nameNoExt);

            if (! File::isDirectory($target_path)) {
                File::makeDirectory($target_path);
            }

            chdir(public_path('/scripts'));
            exec("./script.sh $target_path, $nameNoExt");
            chdir($old_path);
        }
    }
}
