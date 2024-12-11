@extends('admin.layout')

@section('content')
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>


    <h1>Edit Template</h1>

    <form action="{{ route('admin.email_templates.update', $template->id) }}" method="POST">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" name="subject" class="form-control" id="subject"
                value="{{ old('subject', $template->subject) }}">
        </div>

        <div class="form-group">
            <label for="body">Body</label>
            <textarea name="body" class="form-control" id="body" rows="6">{{ old('body', $template->body) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update Template</button>
    </form>


    <script>
        ClassicEditor
            .create(document.querySelector('#body'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
