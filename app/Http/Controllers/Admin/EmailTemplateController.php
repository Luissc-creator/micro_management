<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::all();
        return view('admin.email_templates.index', compact('templates'));
    }

    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('admin.email_templates.edit', compact('template'));
    }


    public function create(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        logger('emailtemplate' . json_encode($validate));
        EmailTemplate::create($validate);
        return redirect()->route('admin.email_templates.index');
    }
    public function showCreateForm()
    {
        return view('admin.email_templates.create');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $template = EmailTemplate::findOrFail($id);
        $template->update([
            'subject' => $request->subject,
            'body' => $request->body,
        ]);

        return redirect()->route('admin.email_templates.index')->with('success', 'Template updated successfully');
    }
}
