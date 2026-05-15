<table>
				<thead>
								<tr>
												<th>id</th>
												<th>admin_id</th>
												<th>lesson_id</th>
								</tr>
				</thead>
				<tbody>
								@foreach ($items as $item)
												<tr>
																<td>{{ $item->id }}</td>
																<td>{{ $item->admin_id }}</td>
																<td>{{ $item->lesson_id }}</td>
												</tr>
								@endforeach
				</tbody>
</table>
