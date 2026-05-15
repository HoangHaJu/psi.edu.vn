<table>
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>slug</th>
            <th>education_level</th>
            <th>is_active</th>
            <th>avatar</th>
            <th>description</th>
            <th>created_at</th>
            <th>updated_at</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->slug }}</td>
                <td>{{ $item->education_level }}</td>
                <td>{{ $item->is_active }}</td>
                <td>{{ $item->avatar }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->updated_at }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
