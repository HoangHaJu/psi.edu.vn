<table>
    <thead>
        <tr>
            <th>STT</th>
            <th>ID</th>
            <th>Tên Học Viên</th>
            <th>Tên Khóa Học</th>
            <th>Số Sao</th>
            <th>Nội Dung Đánh Giá</th>
            <th>Ngày Đánh Giá</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->admin_id }}</td>
                <td>{{ $item->fullname }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->rating }}</td>
                <td>{{ $item->content }}</td>
                <td>{{ $item->updated_at->format('d/m/Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
