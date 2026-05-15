@if (auth('admin')->user()->isSuperAdmin)
    <x-link :href="route('admin.ticket.edit', $ticket_id)" :title="$ticket['name']" />
@else
    {{ $ticket['name'] }}
@endif
