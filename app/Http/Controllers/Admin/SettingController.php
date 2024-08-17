<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Enums\SettingEnum as SE;

class SettingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = [SE::APP->value => $request->app_name];
            $logo = settings(SE::LOGO->value);

            if ($request->hasFile('logo')) {
                $logo = 'logo.png';
                $request->logo->storeAs('', $logo,'public');
                $logo = 'storage/'.$logo;
            }
            $data[SE::LOGO->value] = $logo;
            settings($data);
            return back()->with('success', 'Saved');
        }
        $settings = collect([
            'app_name' => settings(SE::APP->value),
            'logo' => settings(SE::LOGO->value)
        ]);
        return view('admin.pages.settings.app', compact('settings'));
    }
}
