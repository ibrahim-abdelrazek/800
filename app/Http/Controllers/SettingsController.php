<?php
namespace App\Http\Controllers;

use App\Settings;
use App\Traits\SettingsTrait;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::all();
        return view('settings.index')->with('settings' , $settings );
    }

    public function update(Request $request){
        $ALL = $request->all();
        for($i=0; $i < count($ALL['key']); $i++){
            $record = Settings::where(['key' => $ALL['key'][$i]])->first();
            if($record){
                $record->value = $ALL['value'][$i];
                $record->save();
            }
        }
        return redirect(route('settings.index'));
    }
}