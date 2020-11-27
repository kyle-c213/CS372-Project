<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mail;
use App\Models\User;
use App\Models\Listing;

class MailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Mail will be used for communication between buyers and sellers
    public function index()
    {
        // loads the users inbox
        $userid = auth()->user()->id;
        // get all mail sent to user & is not deleted
        $rec_mails = Mail::where('to', $userid)->where('to_deleted', false)->orderBy('created_at', 'desc')->get();
        return view('Mails.index', compact('rec_mails'));
    }

    public function send($to_id, $listing_id)
    {
        $user = User::findOrFail($to_id);
        $listing = Listing::findOrFail($listing_id);
        return view('Mails.send', compact('user', 'listing'));
    }

    public function send_post(Request $request)
    {
        $mail = new Mail();
        $mail->to = $request->to_id;
        $mail->from = auth()->user()->id;
        $mail->title = $request->title;
        $mail->content = $request->body;

        if ($request->child_of != null)
        {
            $mail->child_of = $request->child_of;
        }

        $mail->save();
        return redirect(Route('listing.index'));
    }

    public function show($mail_id)
    {
        $mail = Mail::findOrFail($mail_id);

        // mark mail as opened
        $mail->opened = true;
        $mail->save();

        return view('Mails.show', compact('mail'));
    }

    public function delete(Request $request)
    {
        $mail = Mail::findOrFail($request->mail_id);
        $mail->to_deleted = true;
        $mail->save();
        return redirect(route('mail.index'));
    }
}
