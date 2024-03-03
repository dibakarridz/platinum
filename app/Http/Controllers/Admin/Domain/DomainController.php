<?php

namespace App\Http\Controllers\Admin\Domain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Models\Domain;
use Response;

class DomainController extends Controller
{
    
    public function index()
    {
        $domains = Domain::latest()->get();
        $activeCount = count($domains);
        $trashedCount = Domain::onlyTrashed()->count();
        return view('backend.domain.index', compact(
            'domains',
            'activeCount',
            'trashedCount'
        ));
    }

    public function create()
    {
        return view('backend.domain.create');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $rules = [
            'domain' => 'required',
            'unique_id' => 'required|unique:domains,unique_id',
            'name' => 'required',
            'email' => 'required|email',
            'driver' => 'required',
            'host' => 'required',
            'port' => 'required',
            'username' => 'required',
            'password' => 'required',
            'encryption' => 'required',
            'title' => 'required',
            'success_message' => 'required',
            'error_message' => 'required',
            'template' => 'required',
        ];
        $customMessages = [
            'domain.required' => 'This field is required',
            'unique_id.required' => 'This field is required',
            'name.required' => 'This field is required',
            'email.required' => 'This field is required',
            'driver.required' => 'This field is required',
            'host.required' => 'This field is required',
            'port.required' => 'This field is required',
            'username.required' => 'This field is required',
            'password.required' => 'This field is required',
            'encryption.required' => 'This field is required',
            'title.required' => 'This field is required',
            'success_message.required' => 'This field is required',
            'error_message.required' => 'This field is required',
            'template.required' => 'This field is required',
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        
        $domain = new Domain();
        $domain->domain_name = $request->domain;
        $domain->unique_id = $request->unique_id;
        $domain->domain = $request->name;
        $domain->reply_email = $request->email;
        $domain->protocol = $request->driver;
        $domain->smtp_host = $request->host;
        $domain->smtp_port = $request->port;
        $domain->smtp_username = $request->username;
        $domain->smtp_password = $request->password;
        $domain->encryption = $request->encryption;
        $domain->email_title = $request->title;
        $domain->success_msg = $request->success_message;
        $domain->error_msg = $request->error_message;
        $domain->template = $request->template;
        $domain->save();
        if($domain){
            return redirect()->route('admin.domains.index')->with(['success' => "Item(s) added successfully"]);
        }else{
            return redirect()->back()->with(['error' => "The domain failed to add"]);
        }
        
    }

    public function edit($id)
    {
        $data = Domain::findOrFail($id);
        return view('backend.domain.edit',compact('data'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'domain' => 'required',
            'unique_id' => 'required|unique:domains,unique_id,'.$id,
            'name' => 'required',
            'email' => 'required|email',
            'driver' => 'required',
            'host' => 'required',
            'port' => 'required',
            'username' => 'required',
            'password' => 'required',
            'encryption' => 'required',
            'title' => 'required',
            'success_message' => 'required',
            'error_message' => 'required',
            'template' => 'required',
        ];
        $customMessages = [
            'domain.required' => 'This field is required',
            'unique_id.required' => 'This field is required',
            'name.required' => 'This field is required',
            'email.required' => 'This field is required',
            'driver.required' => 'This field is required',
            'host.required' => 'This field is required',
            'port.required' => 'This field is required',
            'username.required' => 'This field is required',
            'password.required' => 'This field is required',
            'encryption.required' => 'This field is required',
            'title.required' => 'This field is required',
            'success_message.required' => 'This field is required',
            'error_message.required' => 'This field is required',
            'template.required' => 'This field is required',
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        
        $domain = Domain::findOrFail($id);
        $domain->domain_name = $request->domain;
        $domain->unique_id = $request->unique_id;
        $domain->domain = $request->name;
        $domain->reply_email = $request->email;
        $domain->protocol = $request->driver;
        $domain->smtp_host = $request->host;
        $domain->smtp_port = $request->port;
        $domain->smtp_username = $request->username;
        $domain->smtp_password = $request->password;
        $domain->encryption = $request->encryption;
        $domain->email_title = $request->title;
        $domain->success_msg = $request->success_message;
        $domain->error_msg = $request->error_message;
        $domain->template = $request->template;
        $domain->save();
        return redirect()->route('admin.domains.index')->with(['success' => "Item(s) updated successfully"]);
    }

    public function destroy($id)
    {
        $domain = Domain::findOrFail($id);
        $domain->delete();
        return redirect()->back()->with(['success' => "Item(s) deleted successfully"]);
    }

    public function status(Request $request, $id)
    {
        $domain = Domain::find($id);
        $domain->status = $request->status;
        $domain->save();
        if ($domain) {
            return redirect()->back()->with('success', 'Item(s) status changed Successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function action(Request $request)
    {
        $url = route('admin.domains.index');
        
        // 1 is move to trashed
        if($request->action_value == 1){
            foreach($request->ids as $id){
                $domain = Domain::findOrFail($id);
                $domain->delete();
            }
            
            return Response::json(['status'=>true,'url'=>$url,'msg'=>'Action has been completed.']);
            
        }else{
            // delete permanently
            foreach($request->ids as $id){
                $domain = Domain::findOrFail($id);
                $domain->forceDelete();
            }
            
            return Response::json(['status'=>true,'url'=>$url,'msg'=>'Action has been completed.']);
        }
    }

    public function mail($id)
    {
        $domain = Domain::findOrFail($id);
        $returnHTML = view('backend.domain.domain-mail', ['domain' => $domain])->render();
        return Response::json(['status'=>true,'html'=>$returnHTML]);
    }

    public function sendMail(Request $request, $id)
    {
        $rules = [
            'sender_email' => 'required|email',
        ];
        $customMessages = [
            'sender_email.required' => 'This field is required',
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $getDomain = Domain::findOrFail($id);
        
        $mail = new PHPMailer(true);
        
        //try {
   
            /* Email SMTP Settings */
            $mail->Mailer = $getDomain->protocol;
            $mail->Host = $getDomain->smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $getDomain->smtp_username;
            $mail->Password =  $getDomain->smtp_password;
            $mail->SMTPSecure = $getDomain->encryption;
            $mail->Port = $getDomain->smtp_port;
            $mail->SMTPDebug = 0;
            $mail->isHTML(true);
   
            $mail->setFrom($getDomain->reply_email, $getDomain->domain);
            $mail->addAddress($request->sender_email);
            $mail->Subject = $getDomain->email_title;
            $mail->Body = $getDomain->template;
   
            if( !$mail->send() ) {
                return back()->with(["error" => "Email not sent."])->withErrors($mail->ErrorInfo);
            }
              
            else {
                return redirect()->back()->with(['success' => "Email has been sent"]);
            }
   
        // } catch (Exception $e) {
        //      return back()->with(['error' => 'Message could not be sent.']);
        // }

        
    }
}
