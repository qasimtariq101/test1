<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Datatables;
use Illuminate\Http\Request;
use Validator;

class LanguageController extends Controller
{
    public function index()
    {
        return view('admin.language.index')->with('page_title', __('Site Languages'));
    }

    public function create()
    {
        return view('admin.language.create')->with('page_title', __('Site Languages'));
    }

    public function edit($id)
    {
        $language = Language::findOrfail($id);
        return view('admin.language.edit', compact('language'))->with('page_title', __('Site Languages'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:30|eco_string|unique:languages,name',
            'code' => 'required|min:2|max:3|alpha|unique:languages,code',
            'site_layout' => 'required|in:rtl,ltr'
        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages_admin($validator->errors()->all(),'error');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $language       = new Language();
            $language->name = $request->name;
            $language->code = $request->code;
            $language->site_layout = $request->site_layout;
            $language->save();
            if($request->ajax()) return alert_messages_admin(__('Successfully added'));
            return redirect()->back()->withSuccess(__('Successfully added'));
        }
    }

    public function update($id, Request $request)
    {
        $language  = Language::findOrfail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:30|eco_string|unique:languages,name,' . $language->id,
            'site_layout' => 'required|in:rtl,ltr'
        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages_admin($validator->errors()->all(),'error');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $language->name = $request->name;
            $language->site_layout = $request->site_layout;
            $language->save();
            if($request->ajax()) return alert_messages_admin(__('Successfully updated'));
            return redirect()->back()->withSuccess(__('Successfully updated'));
        }
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $languages = Language::select(['id', 'name', 'code']);
            return Datatables::of($languages)
                ->addColumn('action', function ($language) {
                    return '<a class="btn btn-sm btn-default" href="' . url('admin/site-languages/' . $language->id . '/translations') . '"><i class="fa fa-language"></i> '.__('Translations').'</a> <a class="btn btn-sm btn-default" href="' . url('admin/site-languages/' . $language->id . '/edit') . '"><i class="fa fa-edit"></i> '.__('Edit').'</a> <a class="btn btn-sm btn-danger eco_link" href="' . url('admin/site-languages/' . $language->id . '/delete') . '"><i class="fa fa-trash"></i> '.__('Delete').'</a> ';
                })
                ->make(true);
        }
    }

    public function destroy(Request $request)
    {
        Language::where('code','!=','en')->where('id', $request->id)->delete();
        if($request->ajax()) return alert_messages_admin(__('Successfully deleted'));
        return redirect()->back()->withSuccess(__('Successfully deleted'));
    }


    public function translationsEdit($id)
    {
        $language     = Language::findOrfail($id);

        $path = '../resources/lang';
        if (!file_exists($path)) {
            $path = 'resources/lang';
        }

        $default_data = file_get_contents($path.'/en.json');
        if (file_exists($path.'/' . $language->code . '.json')) {
            $data = file_get_contents($path.'/' . $language->code . '.json');
        } else {
            $data = file_get_contents($path.'/en.json');
        }
        $default_words = json_decode($default_data);
        $words         = json_decode($data);
        return view('admin.language.translation', compact('language', 'default_words', 'words'))->with('page_title', 'Site Languages');
    }

    public function translationsUpdate($id, Request $request)
    {
        $language = Language::findOrfail($id);

        $path = '../resources/lang';
        if (!file_exists($path)) {
            $path = 'resources/lang';
        }

        $array    = [];
        foreach ($request->trans as $key => $value) {
            if ($key == '_token') {
                continue;
            }

            $key         = str_replace('_', ' ', $key);
            $key         = trim($key);
            $array[$key] = $value;
        }
        $translations = json_encode($array, JSON_UNESCAPED_UNICODE);

        chmod($path.'/', 0775);
        file_put_contents($path.'/' . $language->code . '.json', $translations);

        if($request->ajax()) return alert_messages_admin(__('Successfully updated'));
        return redirect()->back()->withSuccess(__('Successfully updated'));
    }    
}
