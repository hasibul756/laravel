<h1>This is the student index page</h1>

@foreach ($students as $student)
    <p>{{ $student->name }} - {{ $student->email }}</p>
@endforeach