<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\BorrowRoom;
use App\Models\AdminUserDetail;
use App\Models\Room;
use App\Models\Inventory;
use Carbon\Carbon;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\BorrowOrderMail;
use Illuminate\Support\Facades\Mail;

class BorrowRoomApiController extends Controller
{
    public function storeBorrowRoomWithBorrower(Request $request)
    {
        // dd($request);
        // Set request to variable
        $email =            $request->email;
        $full_name =        ($request->full_name);
        $phone_number =     $request->phone_number;
        $borrower_status =  $request->borrower_status;
        $activity =         $request->activity;
        $data =             json_encode([
            'email' =>              $email,
            'full_name' =>          $full_name,
            'phone_number' =>       $phone_number,
            'borrower_status' =>    $borrower_status,
            'activity' =>           $activity,
        ], true);

        $validator = Validator::make($request->all(), [
            'email' =>              'required|string',
            'full_name' =>          'required|string',
            'phone_number' =>       'required|numeric',
            'borrower_status' =>    'required',
            'activity' =>           'required|string',
            'borrow_at' =>          'required|date|after_or_equal:' . now()->format('d-m-Y H:i'),
            'until_at' =>           'required|date|after_or_equal:borrow_at',
            'room' =>               'required',
            'inventory' =>          'required',
        ], [
            'email.required' =>             'Kolom email wajib diisi.',
            'full_name.required' =>         'Kolom nama lengkap wajib diisi.',
            'phone_number.required' =>      'Kolom nomor telepon wajib diisi.',
            'phone_number.numeric' =>       'Kolom nomor telepon harus berupa nomor.',
            'activity.required' =>          'Kolom aktivitas wajib diisi.',

            'borrow_at.required' =>         'Kolom tgl mulai wajib diisi.',
            'borrow_at.date' =>             'Kolom tgl mulai bukan tanggal yang valid.',
            'borrow_at.after_or_equal' =>   'Kolom tgl mulai harus berisi tanggal setelah atau sama dengan :date.',

            'until_at.required' =>          'Kolom tgl selesai wajib diisi.',
            'until_at.date' =>              'Kolom tgl selesai bukan tanggal yang valid.',
            'until_at.after_or_equal' =>    'Kolom tgl selesai harus berisi tanggal setelah atau sama dengan tgl mulai.',

            'room.required' =>      'Kolom ruangan wajib diisi.',
            'inventory.required' => 'Kolom inventaris wajib diisi.',

            'borrower_status.required' => 'Kolom status wajib diisi.',
        ]);

        $validator->stopOnFirstFailure();

        if ($validator->fails()) {
            $errors = $validator->errors();
        
            // Ensure there are errors and get the first error key
            if ($errors->any()) {
                $firstErrorKey = key($errors->messages());
                $firstErrorMessage = $errors->first($firstErrorKey);
        
                return redirect(route('home'))
                    ->withInput($request->input())
                    ->withErrors([$firstErrorKey => $firstErrorMessage]);
            }
        }

        // Check if admin_user (borrower) is exist
        $admin_user = Administrator::where('username', $email)->first();
        if ($admin_user === null) {
            // Make account for borrower
            $admin_user = Administrator::create([
                'username' =>   $email,
                'name' =>       $full_name,
                'password' =>   Hash::make($request->phone_number)
            ]);

            // Add role borrower
            $admin_role_user = \DB::table('admin_role_users')->insert([
                'role_id' =>    3,
                'user_id' =>    $admin_user->id,
            ]);

            // Make borrower details to user_details table
            $borrower_detail = AdminUserDetail::create([
                'admin_user_id' =>  $admin_user->id,
                'data' =>           $data
            ]);
        }

        // Check if that room already booked at that date range
        $room = Room::find($request->room);
        $borrow_at = $request->borrow_at;
        $already_booked = false;
        foreach ($room->borrow_rooms as $borrow_room) {
            $from = Carbon::make($borrow_room->borrow_at);
            $to =   Carbon::make($borrow_room->until_at);

            $already_booked = Carbon::make($borrow_at)->between($from, $to);
        }

        if ($already_booked)
            return redirect(route('home'))->withInput($request->input())->withErrors([
                'Maaf ruangan tersebut sudah dibooking pada tanggal tersebut, silahkan pilih tanggal lain.'
            ]);

        // Check if borrower already have active borrow_rooms and didn't return the key
        $borrow_rooms = BorrowRoom::where('borrower_id', $admin_user->id);
        $borrow_rooms_is_empty = $borrow_rooms->get()->isEmpty();

        // If any of borrow_rooms query
        if (!$borrow_rooms_is_empty) {
            $borrow_rooms_is_not_finished = $borrow_rooms->isNotFinished()->get()->isEmpty();

            if (!$borrow_rooms_is_not_finished)
                return redirect(route('home'))->withInput($request->input())->withErrors([
                    'Peminjam dengan email ' . $admin_user->username . ' masih memiliki peminjaman yang belum selesai.',
                ]);
        }

        // Add borrow rooms
        $borrow_room = BorrowRoom::create([
            'id' => date('YmdHis'),
            'email' =>              $email,
            'full_name' =>          $full_name,
            'phone_number' =>       $phone_number,
            'borrower_status' =>    $borrower_status,
            'activity' =>           $activity,
            'borrower_id' =>        $admin_user->id,
            'room_id' =>            $request->room,
            'inventory_id' =>       $request->inventory,
            'borrow_at' =>          Carbon::make($request->borrow_at),
            'until_at' =>           Carbon::make($request->until_at),
        ]);

        // Email sending logic
        $order = [
            'id' => $borrow_room->id,
            'email' => $borrow_room->email,
            'full_name' => $borrow_room->full_name,
            'borrower_status' => $borrow_room->borrower_status,
            'admin_approval_status' => $borrow_room->admin_approval_status,
            'returned_at' => $borrow_room->returned_at,
            'processed_at' => $borrow_room->processed_at
];

        Mail::to($borrow_room->email)
            ->cc(['contact@siprig.com'])
            ->send(new BorrowOrderMail($order));

        // Return success create borrow_rooms
        return redirect(route('home'))->withSuccess(true);
    }
}
