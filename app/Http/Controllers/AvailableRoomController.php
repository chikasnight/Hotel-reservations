<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AvailableRoom;
use Session;
use Stripe;
use App\Http\Resources\AvailableRoomResource;


class AvailableRoomController extends Controller
{
    public function newReservation(Request $request){
        //validate request body
        $request->validate([
            'name'=>['required'],
            'price'=>['required'],
            'description'=>['required'],            

          
        ]);

    
        //create a grocery
        $newReservation = AvailableRoom::create([
            'user_id'=>auth()->id(),
            'name'=> $request->name,
            'price'=> $request->price,
            'description'=> $request->description,
            
        ]);


        //return cuccess response

        return response()->json([
            'success'=> true,
            'message'=>'successfully created a Reservation',
            'data' => new AvailableRoomResource($newReservation),
        ]);
    }
    public function getReservation(Request $request, $availableRoomId){
        $newReservation = AvailableRoom::find($availableRoomId);
        if(!$newReservation) {
            return response() ->json([
                'success' => false,
                'message' => 'Reservation not found'
            ]);
        }

        return response() ->json([
            'success'=> true,
            'message'  => 'Reservation found',
            'data'   => [
                'grocery'=> $newReservation
                
            ]
        ]);
    }
    public function deleteReservation( $availableRoomId){

        $newReservation = AvailableRoom::find($availableRoomId);
        if(!$newReservation) {
            return response() ->json([
                'success' => false,
                'message' => 'Reservation not found'
            ]);
        }

        

        $this->authorize('delete',$newReservation);
        //delete newReservation
        $newReservation-> delete();

        return response() ->json([
            'success' => true,
            'message' => 'Reservation deleted'
            ]); 
    } 

    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => 100 * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);
      
        Session::flash('success', 'Payment successful!');
              
        return back();
    }

}
