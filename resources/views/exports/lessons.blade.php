<table>
    <thead>
        <tr>
            <th>id</th>
            <th>start_time</th>
            <th>teacher_lesson_id</th>
            <th>created_at</th>
            <th>updated_at</th>
            <th>course_id</th>
            <th>date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lessons as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->start_time }}</td>
                <td>{{ $item->teacher_lesson_id }}</td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->updated_at }}</td>
                <td>{{ $item->course_id }}</td>
                <td>{{ $item->date }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
