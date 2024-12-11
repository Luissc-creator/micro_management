@extends('admin.layout')

@section('content')
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>


    <h1>Create Template</h1>

    <form action="{{ route('admin.email_templates.create') }}" method="POST">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="Name" class="form-label">Name</label>
            <select class="form-select" id="Name" name="name" required>
                <option value="task_completed">Task Completed</option>
                <option value="project_completed">Project Completed</option>
                <option value="task_updated">Task Updated</option>
            </select>
        </div>
        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" name="subject" class="form-control" id="subject" value="">
        </div>

        <div class="form-group">
            <label for="body">Body</label>
            <textarea name="body" class="form-control" id="body" rows='6' style="height: 300px;"></textarea>
        </div>

        <button type="submit" class="btn btn-success mt-3">Create</button>
    </form>


    <script>
        ClassicEditor
            .create(document.querySelector('#body'), {
                toolbar: ['bold', 'italic', 'link'],
                height: '400px'
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
