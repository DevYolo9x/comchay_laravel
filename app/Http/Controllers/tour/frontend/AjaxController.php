<?php

namespace App\Http\Controllers\tour\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\TourBook;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Components\Comment;
class AjaxController extends Controller
{
    protected $comment;
    public function __construct()
    {
        $this->comment = new Comment();
    }
    //đặt tour
    public function bookTour(Request $request){
        $tour_id = Tour::findOrFail($request->tour_id);
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'date' => 'required',
        ], [
            'fullname.required' => 'The Fullname field is required.',
            'date.required' => 'The travel date field is required.',
        ]);
        $date = explode('/',$request->date);
        $id = TourBook::insertGetId([
            'code'=>'DH.'.date('m.y').'.'.bin2hex(random_bytes(3)),
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'date' => trim($date[2]).'-'.trim($date[0]).'-'.trim($date[1]),
            'adult' => !empty($request->adult)?$request->adult:'',
            'children' => !empty($request->children)?$request->children:'',
            'message' => $request->message,
            'tour_id' => $tour_id->id,
            'status' => 'pending',
            'type' => 'tours',
            'created_at' => Carbon::now()
        ]);
        if($id > 0){
            //gui email
             $sendMail = array(
                'subject' => 'Thông báo! Đặt tour thành công',
                'id' => $id,
            );
            Mail::to(env('MAIL_CC_SEND'))->cc($request->email)->send(new \App\Mail\SendMailTour($sendMail));
            //end
            return response()->json(['success'=> '200']);

        }else{
            return response()->json(['error'=>'500']);
        }
    }
    //inquiry tour
    public function inquiryTour(Request $request){
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'adult' => 'required',
            'children' => 'required',
            'destination' => 'required',
            'tourstyle' => 'required',
            'arrivalDate' => 'required',
            'LengthofStay' => 'required',
            'budget' => 'required',
        ], [
            'firstname.required' => 'The First Name field is required.',
            'lastname.required' => 'The Last Name field is required.',
            'adult.required' => 'The Number Adult field is required.',
            'children.required' => 'The Number Children field is required.',
            'tourstyle.required' => 'The Tour Styles field is required.',
            'LengthofStay.required' => 'The Length Of Stay field is required.',
            'budget.required' => 'The Max Budget field is required.',
        ]);
        $html = '';
        $html.='<p style="margin:10px 0"><b>Number adult: </b>'.$request->adult.'</p>';
        $html.='<p style="margin:10px 0"><b>Number children: </b>'.$request->children.'</p>';
        $html.='<p style="margin:10px 0"><b>Destination: </b>'.$request->destination.'</p>';
        $html.='<p style="margin:10px 0"><b>Departure City: </b>'.$request->departure.'</p>';
        $html.='<p style="margin:10px 0"><b>Arrival Date: </b>'.$request->arrivalDate.'</p>';
        $html.='<p style="margin:10px 0"><b>Length Of Stay: </b>'.$request->LengthofStay.'</p>';
        $html.='<p style="margin:10px 0"><b>Max Budget: </b>$'.$request->budget.'</p>';
        $html.='<p style="margin:10px 0"><b>Accomodation: </b>'.$request->accomodation.'</p>';

        $id = TourBook::insertGetId([
            'code'=>'TI.'.date('m.y').'.'.bin2hex(random_bytes(3)),
            'fullname' => $request->firstname.' '.$request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            //inquiryTour
            'inquiryTour' => $html,
            //end
            'message' => $request->message,
            'status' => 'pending',
            'type' => 'inquiry',
            'created_at' => Carbon::now()
        ]);
        if($id > 0){
            //gui email
             $sendMail = array(
                'subject' => 'Thông báo! Inquiry',
                'id' => $id,
            );
            Mail::to(env('MAIL_CC_SEND'))->cc($request->email)->send(new \App\Mail\SendMailInquiryTour($sendMail));
            //end
            return response()->json(['status'=> '200']);
        }else{
            return response()->json(['status'=>'500']);
        }
    }


}