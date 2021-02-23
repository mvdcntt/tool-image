<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
            $name = Str::slug($name);
            $ext = $image->getClientOriginalExtension();
            $name = str_replace( '.' . $ext, '', $name);

            $targetPath = public_path('/converted') . '/' . $name;

            if (! File::isDirectory(public_path('/converted'))) {
                File::makeDirectory(public_path('/converted'));
            }

            if (! File::isDirectory(public_path('/converted/' . $name))) {
                File::makeDirectory(public_path('/converted/' . $name));
            }

            $direction = $request->get('direction');

            if (! isset($direction)) {
                $direction = 'all';
            }

            if ($direction == 'all') {
                shell_exec("convert {$path} -bordercolor none -border 1 -background white -alpha background -bordercolor white " . $targetPath . '/image_border.png');
                shell_exec("convert " . $targetPath . '/image_border.png' . " -alpha off -negate -threshold 0 -type bilevel " . $targetPath . '/image_border0.png');
                $old_path = getcwd();
                chdir(public_path('scripts'));
                shell_exec('bash script.sh ' .  $targetPath);
                chdir($old_path);
            } elseif ($direction == 'vertical') {
                shell_exec("convert \( {$path} -bordercolor none -border 1x0 \) \
                    -size 1x1 xc:black -gravity west -composite \
                    -size 1x1 xc:black -gravity east -composite \
                    -fuzz 10% -trim +repage -bordercolor none -shave 1x0 \
                    " . $targetPath . '/' . $name .'.'. $ext);
            } elseif ($direction == 'horizontal') {
                shell_exec("convert \( {$path} -bordercolor none -border 0x1 \) \
                    -size 1x1 xc:black -gravity north -composite \
                    -size 1x1 xc:black -gravity south -composite \
                    -fuzz 10% -trim +repage -bordercolor none -shave 0x1 \
                     " . $targetPath . '/' . $name .'.'. $ext);
            }
        }
    }
}
