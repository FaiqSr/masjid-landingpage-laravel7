<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $data = DB::table('news')->orderby('news.id', 'desc')->get();

        return view('dashboard.news.index', ['data' => $data]);
    }

    public function create()
    {
        return view('dashboard.news.add');
    }

    public function add(Request $request)
    {
        /* DB::table('news')->insert([
            'title' => $request->title,
            'content' => $request->content,
            'image_url' => $request->image_url,
            'admin_photo_url' => $request->admin_photo_url,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect('news/index')->with('add_sukses', 1); */

        if ($request->hasFile('image_url')) {
            //image_url
            $image_name1 = $_FILES['image_url']['name'];
            $tmp_name1 = $_FILES['image_url']['tmp_name'];
            $directory_name1 = public_path('/img/uploads/');
            $file_name1 = $directory_name1 . $image_name1;
            move_uploaded_file($tmp_name1, $file_name1);

            $compress_file1 = 'image_url_' . date('YmdHis') . $image_name1;
            $compressed_img1 = $directory_name1 . $compress_file1;
            $compress_image = $this->compress($file_name1, $compressed_img1);
            $image_url = "$compress_file1";

            //admin_photo_url
            $image_name2 = $_FILES['admin_photo_url']['name'];
            $tmp_name2 = $_FILES['admin_photo_url']['tmp_name'];
            $directory_name2 = public_path('/img/uploads/');
            $file_name2 = $directory_name2 . $image_name2;
            move_uploaded_file($tmp_name2, $file_name2);

            $compress_file2 = 'admin_photo_url_' . date('YmdHis') . $image_name2;
            $compressed_img2 = $directory_name2 . $compress_file2;
            $compress_image2 = $this->compress($file_name2, $compressed_img2);
            $admin_photo_url = "$compress_file2";

            DB::table('news')->insert([
                'slug' => Str::slug($request->title),
                'title' => $request->title,
                'content' => $request->content,
                'image_url' => $image_url,
                'admin_photo_url' => $admin_photo_url,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            unlink($file_name1);
            unlink($file_name2);
        }

        return redirect('dashboard/news/index')->with('add_sukses', 1);
    }

    public function edit($id)
    {
        $row = DB::table('news')->where('news.id', $id)->first();

        return view('dashboard.news.edit', [
            'row' => $row,
        ]);
    }

    public function update(Request $request)
    {
        DB::table('news')
            ->where('id', $request->id)
            ->update([
                'title' => $request->title,
                'content' => $request->content,
                'image_url' => $request->image_url,
                'admin_photo_url' => $request->admin_photo_url,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        return redirect('dashboard/news/index')->with('edit_sukses', 1);
    }

    public function delete($id)
    {
        DB::table('news')->where('id', $id)->delete();
        return redirect()->back()->with('delete_sukses', 1);
    }

    function compress($source_image, $compress_image)
    {
        $image_info = getimagesize($source_image);
        if ($image_info['mime'] == 'image/jpeg') {
            $source_image = imagecreatefromjpeg($source_image);
            imagejpeg($source_image, $compress_image, 20); //for jpeg or gif, it should be 0-100
        } elseif ($image_info['mime'] == 'image/png') {
            $source_image = imagecreatefrompng($source_image);
            imagepng($source_image, $compress_image, 3);
        }
        return $compress_image;
    }

    public function detail($id)
    {
        $new = DB::table('news')->where('id', $id)->first();

        return view('dashboard.news.detail', compact('new'));
    }
}
