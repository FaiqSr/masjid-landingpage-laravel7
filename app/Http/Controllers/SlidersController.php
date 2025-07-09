<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SlidersController extends Controller
{
    public function index()
    {
        $data = DB::table('sliders')->orderby('sliders.id', 'desc')->get();

        return view('dashboard.sliders.index', ['data' => $data]);
    }

    public function create()
    {
        return view('dashboard.sliders.add');
    }

    public function add(Request $request)
    {
        if ($request->hasFile('image1')) {
            //foto1
            $image_name = $_FILES['image1']['name'];
            $tmp_name = $_FILES['image1']['tmp_name'];
            $directory_name = public_path('/img/uploads/');
            $file_name = $directory_name . $image_name;
            move_uploaded_file($tmp_name, $file_name);

            $compress_file = 'img_' . date('YmdHis') . $image_name;
            $compressed_img = $directory_name . $compress_file;
            $compress_image = $this->compress($file_name, $compressed_img);
            $foto1 = "$compress_file";

            DB::table('sliders')->insert([
                'image_url' => $foto1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            unlink($file_name);
        }

        return redirect('dashboard/sliders/index')->with('add_sukses', 1);
    }

    public function edit($id)
    {
        $row = DB::table('sliders')->where('sliders.id', $id)->first();

        return view('dashboard.sliders.edit', [
            'row' => $row,
        ]);
    }

    public function update(Request $request)
    {
        if ($request->hasFile('image1')) {
            //foto1
            $image_name = $_FILES['image1']['name'];
            $tmp_name = $_FILES['image1']['tmp_name'];
            $directory_name = public_path('/img/uploads/');
            $file_name = $directory_name . $image_name;
            move_uploaded_file($tmp_name, $file_name);

            $compress_file = 'img_' . date('YmdHis') . $image_name;
            $compressed_img = $directory_name . $compress_file;
            $compress_image = $this->compress($file_name, $compressed_img);
            $foto1 = "$compress_file";

            DB::table('sliders')
                ->where('id', $request->id)
                ->update([
                    'image_url' => $foto1,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            unlink($file_name);

            return redirect('dashboard/sliders/index')->with('edit_sukses', 1);
        }
    }

    public function delete($id)
    {
        DB::table('sliders')->where('id', $id)->delete();
        return redirect()->back()->with('delete_sukses', 1);
    }

    function compress($source_image, $compress_image)
    {
        $image_info = getimagesize($source_image);
        if ($image_info['mime'] == 'image/jpeg') {
            $source_image = imagecreatefromjpeg($source_image);
            imagejpeg($source_image, $compress_image, 100); //for jpeg or gif, it should be 0-100
        } elseif ($image_info['mime'] == 'image/png') {
            $source_image = imagecreatefrompng($source_image);
            imagepng($source_image, $compress_image, 3);
        }
        return $compress_image;
    }
}
