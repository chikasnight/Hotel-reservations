<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\UploadImages;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function reservationImage(Request $request,){
        //validate request body
        $request->validate([
            'image' => ['mimes:png,jpeg,gif,bmp', 'max:2048',],
        ]);

        //get the image
        $image = $request->file('image');
        //$image_path = $image->getPathName();
 
        // get original file name and replace any spaces with _
        // example: ofiice card.png = timestamp()_office_card.pnp
        $filename = time()."_".preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
 
        // move image to temp location (tmp disk)
        $tmp = $image->storeAs('uploads/gallery', $filename, 'tmp');
 
        //$this->authorize('create',$newReservation);
        //create
        $reservationImage = Gallery::create([
            'user_id'=>auth()->id(),
            'image'=> $filename,
            'disk'=> config('site.upload_disk'),
           
            
        ]);

        //dispacth job to handle image manipulation
        $this->dispatch(new UploadImages($reservationImage));

        //return cuccess response

        return response()->json([
            'success'=> true,
            'message'=>'successfully created a Reservation',
            
        ]);
    }
}
