<table>
				<thead>
								<tr>
												<th>id</th>
												<th>admin_id</th>
												<th>teacher_lesson_id</th>
												<th>status</th>
												<th>day_off_type</th>
												<th>note</th>
												<th>file_link</th>
												<th>date</th>
												<th>start_time</th>
												<th>course_name</th>
												<th>student_review</th>
												<th>teacher_review</th>
												<th>interaction</th>
												<th>listening</th>
												<th>communication</th>
												<th>pronunciation</th>
												<th>vocab_grammar</th>
												<th>ticket_date</th>
												<th>created_at</th>
												<th>updated_at</th>
								</tr>
				</thead>
				<tbody>
								@foreach ($items as $item)
												<tr>
																<td>{{ $item->id }}</td>
																<td>{{ $item->admin_id }}</td>
																<td>{{ $item->teacher_lesson_id }}</td>
																<td>{{ $item->status }}</td>
																<td>{{ $item->day_off_type }}</td>
																<td>{{ $item->note }}</td>
																<td>{{ $item->file_link }}</td>
																<td>{{ $item->date }}</td>
																<td>{{ $item->start_time }}</td>
																<td>{{ $item->course_name }}</td>
																<td>{{ $item->student_review }}</td>
																<td>{{ $item->teacher_review }}</td>
																<td>{{ $item->interaction }}</td>
																<td>{{ $item->listening }}</td>
																<td>{{ $item->communication }}</td>
																<td>{{ $item->pronunciation }}</td>
																<td>{{ $item->vocab_grammar }}</td>
																<td>{{ $item->ticket_date }}</td>
																<td>{{ $item->created_at }}</td>
																<td>{{ $item->updated_at }}</td>
												</tr>
								@endforeach
				</tbody>
</table>
