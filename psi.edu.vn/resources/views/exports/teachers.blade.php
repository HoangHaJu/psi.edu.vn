<table>
    <thead>
        <tr>
            <th>id</th>
            <th>fullname</th>
            <th>username</th>
            <th>email</th>
            <th>phone</th>
            <th>skype_id</th>
            <th>birthday</th>
            <th>avatar</th>
            <th>audio</th>
            <th>gender</th>
            <th>address</th>
            <th>password</th>
            <th>note</th>
            <th>education_level</th>
            <th>token_active_account</th>
            <th>token_get_password</th>
            <th>remember_token</th>
            <th>remaining_leave_requests</th>
            <th>updated_at</th>
            <th>created_at</th>
            <th>is_active</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->fullname }}</td>
                <td>{{ $item->username }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->skype_id }}</td>
                <td>{{ $item->birthday }}</td>
                <td>{{ $item->avatar }}</td>
                <td>{{ $item->audio }}</td>
                <td>{{ $item->gender }}</td>
                <td>{{ $item->address }}</td>
                <td>{{ $item->password }}</td>
                <td>{{ $item->note }}</td>
                <td>{{ $item->education_level }}</td>
                <td>{{ $item->token_active_account }}</td>
                <td>{{ $item->token_get_password }}</td>
                <td>{{ $item->remember_token }}</td>
                <td>{{ $item->remaining_leave_requests }}</td>
                <td>{{ $item->updated_at }}</td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->is_active }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
