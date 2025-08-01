<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Setting;

class SettingController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    // Set Env function
    private function setEnv($name, $value){
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name . '=' . env($name), $name . '=' . $value, file_get_contents($path)));
        }
    }

    
    public function Doctorino_settings(Request $request){
    	$settings = Setting::where('user_id', auth()->user()->id)->pluck('option_value','option_name')->toArray();
        // dd($settings);
        $language = ['fr' => 'French', 'en' => 'English', 'es' => 'Spanish', 'it' => 'Italian', 'de' => 'German', 'bn' => 'Bengali', 'tr' => 'Turkish', 'ru' => 'Russian', 'in' => 'Hindi', 'pt' => 'Portuguese', 'id' => 'Indonesian', 'ar' => 'Arabic'];
    	return view('settings.doctorino_settings', ['settings' => $settings, 'language' => $language]);
    }

    public function Doctorino_settings_store(Request $request){

    	 $validatedData = $request->validate([
        	'system_name' => 'required',
        	'title' => 'required',
        	'address' => 'required',
        	'phone' => 'required',
        	'hospital_email' => 'required|email',
            'currency' => 'required',
            'appointment_interval' => 'required',
    	]);

	    	// Setting::update_option('system_name', $request->system_name);
	    	// Setting::update_option('title', $request->title);
	    	// Setting::update_option('address', $request->address);
	    	// Setting::update_option('phone', $request->phone);
	    	// Setting::update_option('hospital_email', $request->hospital_email);
            // Setting::update_option('currency', $request->currency);
            // Setting::update_option('vat', $request->vat);
            // Setting::update_option('language', $request->language);
            $userId = auth()->id();

            Setting::update_option('system_name', $request->system_name, $userId);
            Setting::update_option('title', $request->title, $userId);
            Setting::update_option('address', $request->address, $userId);
            Setting::update_option('phone', $request->phone, $userId);
            Setting::update_option('hospital_email', $request->hospital_email, $userId);
            Setting::update_option('currency', $request->currency, $userId);
            Setting::update_option('vat', $request->vat, $userId);
            Setting::update_option('language', $request->language, $userId);

          //  Setting::update_option('appointment_interval', $request->appointment_interval);

         //   Setting::update_option('saturday_from', $request->saturday_from);
         //   Setting::update_option('saturday_to', $request->saturday_to);

         //   Setting::update_option('sunday_from', $request->sunday_from);
          //  Setting::update_option('sunday_to', $request->sunday_to);

          //  Setting::update_option('monday_from', $request->monday_from);
          //  Setting::update_option('monday_to', $request->monday_to);

         //   Setting::update_option('tuesday_from', $request->tuesday_from);
         //   Setting::update_option('tuesday_to', $request->tuesday_to);

         //   Setting::update_option('wednesday_from', $request->wednesday_from);
          //  Setting::update_option('wednesday_to', $request->wednesday_to);

         //   Setting::update_option('thursday_from', $request->thursday_from);
         //   Setting::update_option('thursday_to', $request->thursday_to);

         //   Setting::update_option('friday_from', $request->friday_from);
         //   Setting::update_option('friday_to', $request->friday_to);



    	return Redirect::route('doctorino_settings.edit')->with('success', __("sentence.Settings edited Successfully") );
    }

    public function prescription_settings(Request $request){

    	return view('settings.prescription_settings');
    }

    public function prescription_settings_store(Request $request)
    {

        if($request->hasfile('logo')){
            $file = $request->file('logo');
            $upload = 'img/';
            $filename = time().$file->getClientOriginalName();
            $path    = move_uploaded_file($file->getPathName(), $upload.$filename);
            Setting::update_option('logo', $upload.$filename);
        }
	    	Setting::update_option('dr_name', $request->dr_name);
	    	Setting::update_option('dr_degree1', $request->dr_degree1);
	    	Setting::update_option('dr_degree2', $request->dr_degree2);
	    	Setting::update_option('dr_bottom_line', $request->dr_bottom_line);
	    	Setting::update_option('header_left', $request->header_left);
	    	Setting::update_option('footer_right', $request->footer_right);
	    	Setting::update_option('footer_left', $request->footer_left);

    	return Redirect::route('prescription_settings.edit')->with('success', __("sentence.Settings edited Successfully"));

	}

    public function sms_settings(){
        return view('settings.sms_settings');
    }

    public function sms_settings_store(Request $request){

            Setting::update_option('NEXMO_KEY', $request->NEXMO_KEY);
            Setting::update_option('NEXMO_SECRET', $request->NEXMO_SECRET);

            
            $this->setEnv('NEXMO_KEY', $request->NEXMO_KEY);
            $this->setEnv('NEXMO_SECRET', $request->NEXMO_SECRET);

        return Redirect::route('sms_settings.edit')->with('success', __("sentence.Settings edited Successfully"));

    }


}
