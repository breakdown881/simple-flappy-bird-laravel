<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Player Name</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>Time</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <th>{{ $user->id }}</th>
            <td>{{ $user->name }}</td>
            <td>{{ $user->phone_number }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('Y/m/d H:i:s') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
