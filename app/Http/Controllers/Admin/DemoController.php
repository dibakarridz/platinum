<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class DemoController extends Controller
{
    public function index()
    {
        $queries = DB::table('tk_queries')->get();
        $modified = $queries->map(function ($item, $key) {
            //dd(Carbon::now());
            if($item->status == 'New Quote' || $item->status == ''){
                $status = 1;
            }else if($item->status == 'Quoted'){
                $status = 2;
            }else if($item->status == 'Forward'){
                $status = 3;
            }else if($item->status == 'Booked'){
                $status = 4;
            }else if($item->status == ''){
                $status = 'New Quote';
            }else{
                $status = '';
            }
           
            if($item->is_archive == 'Yes'){
                $is_archive = Carbon::parse($item->datetime);
            }else{
                $is_archive = null;
            }
            
            $item->deleted_at = $is_archive;

            DB::table('queries')
            ->insert([
                'id' => $item->id,
                'prefix_quoteid' => $item->prefix_quoteid ?? '', 
                'comes_website'=> $item->comes_website ?? '', 
                'full_name'=> $item->full_name ?? '', 
                'email'=> $item->email ?? '',
                'phone' => $item->phone ?? '', 
                'mobile'=> $item->mobile ?? '', 
                'address'=> $item->address ?? '', 
                'city'=> $item->city ?? '',
                'postcode' => $item->postcode ?? '',
                'status' => $status ?? '',
                'booked_comment'=> $item->booked_comment ?? '', 
                'datetime'=> $item->datetime ?? '', 
                'ip_address'=> $item->ip ?? '',
                'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => $is_archive,
                
            ]);
            return $item;
        });
        $data = $modified->all();
        //dd($data);
        return redirect()->route('admin.dashboard.index')->with(['success' => 'Table data copy successfully']);

    }

    public function booking()
    {
        $queries = DB::table('tk_query_booking')->get();
        $modified = $queries->map(function ($item, $key) {
          
            if($item->returning_datetime == '0000-00-00 00:00:00' || $item->returning_datetime =='0001-01-01 00:00:00' || $item->returning_datetime ==''){
                $returning_datetime = '2018-11-25 17:00:00';
            }else{
                $returning_datetime = $item->returning_datetime;
            }
            if($item->pick_datetime == '0000-00-00 00:00:00' || $item->pick_datetime =='0006-10-19 00:00:00' || $item->pick_datetime =='0001-01-01 00:00:00' || $item->pick_datetime =='0305-02-02 00:00:00' || $item->pick_datetime =='0807-02-02 10:45:00' || $item->pick_datetime == '1106-02-02 00:00:00'){
               $pick_datetime = '2018-11-10 00:00:00';
            }else if($item->pick_datetime == '0002-11-19 11:15:00' || $item->pick_datetime == '0004-07-19 18:00:00' || $item->pick_datetime =='0702-02-02 02:00:00' || $item->pick_datetime =='0702-02-02 00:00:00' || $item->pick_datetime =='1106-02-02 01:00:00' || $item->pick_datetime ==''){
                $pick_datetime = '2018-11-10 00:00:00';
            }else{
                $pick_datetime = $item->pick_datetime;
            }
            $item->returning_datetime = $returning_datetime;
            $item->pick_datetime = $pick_datetime;

            DB::table('bookings')
            ->insert([
                'id' => $item->id,
                'query_id' => $item->query_id ?? '', 
                'booking_pickupPoint'=> $item->booking_pickupPoint ?? '', 
                'booking_postcode'=> $item->booking_postcode ?? '', 
                'pick_datetime'=> $item->pick_datetime ?? '',
                'noOf_passenger' => $item->noOf_passenger ?? '', 
                'booking_return'=> $item->booking_return ?? '', 
                'destination'=> $item->destination ?? '', 
                'destination_postcode'=> $item->destination_postcode ?? '',
                'returning_datetime' => $item->returning_datetime ?? '',
                'journey_details' => $item->journey_details ?? '',
                'occasion'=> $item->occasion ?? '',
                'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                
            ]);
            return $item;
        });
        $data = $modified->all();
        //dd($data);
        return redirect()->route('admin.dashboard.index')->with(['success' => 'Table data copy successfully']);

    }

    public function quoted()
    {
        $queries = DB::table('tk_query_quoted')->get();
        $modified = $queries->map(function ($item, $key) {
          
            DB::table('quoteds')
            ->insert([
                'id' => $item->id,
                'query_id' => $item->query_id ?? '', 
                'prices'=> $item->prices ?? '', 
                'quotation_details'=> $item->quotation_details ?? '', 
                'datetime'=> $item->datetime ?? '',
                
            ]);
            return $item;
        });
        $data = $modified->all();
        //dd($data);
        return redirect()->route('admin.dashboard.index')->with(['success' => 'Table data copy successfully']);

    }

    public function forward()
    {
        $queries = DB::table('tk_query_forward')->get();
        $modified = $queries->map(function ($item, $key) {
          
            DB::table('forwards')
            ->insert([
                'id' => $item->id,
                'query_id' => $item->query_id ?? '', 
                'forwarded_email'=> $item->forwarded_email ?? '', 
                'datetime'=> $item->datetime ?? '',
                
            ]);
            return $item;
        });
        $data = $modified->all();
        //dd($data);
        return redirect()->route('admin.dashboard.index')->with(['success' => 'Table data copy successfully']);

    }

    public function vehicle()
    {
        $queries = DB::table('tk_vehicles')->get();
        $modified = $queries->map(function ($item, $key) {
          
            DB::table('vehicles')
            ->insert([
                'name' => $item->vehicle_name ?? '', 
                'description'=> '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>', 
                'order_by'=> $item->order_by ?? '',
                'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                
            ]);
            return $item;
        });
        $data = $modified->all();
        //dd($data);
        return redirect()->route('admin.dashboard.index')->with(['success' => 'Table data copy successfully']);

    }
    public function domain()
    {
        $queries = DB::table('tk_domain')->get();
        $modified = $queries->map(function ($item, $key) {
          
            DB::table('domains')
            ->insert([
                'unique_id' => $item->unique_id ?? '', 
                'domain_name'=> $item->domain_name ?? '',
                'domain'=> $item->domain ?? '',
                'reply_email' => $item->reply_email ?? '', 
                'protocol'=> $item->protocol ?? '',
                'smtp_host'=> $item->smtp_host ?? '',
                'smtp_port' => $item->smtp_port ?? '', 
                'smtp_username'=> $item->smtp_username ?? '',
                'smtp_password'=> $item->smtp_password ?? '',
                'encryption' => $item->encryption ?? '', 
                'email_title'=> $item->email_title ?? '',
                'template'=> $item->template ?? '',
                'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                
            ]);
            return $item;
        });
        $data = $modified->all();
        //dd($data);
        return redirect()->route('admin.dashboard.index')->with(['success' => 'Table data copy successfully']);

    }

    public function migrateUpdate()
    {
        Artisan::call('migrate');
        return redirect()->route('admin.dashboard.index')->with('success', 'Migrated Successfully');
    }

    public function multi_image()
    {
        return view('backend.demo.images');
    }
}
