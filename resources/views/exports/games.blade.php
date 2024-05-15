<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Player Name</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>Score</th>
        <th>Won Prize</th>
        <th>Reward</th>
        <th>Time</th>
    </tr>
    </thead>
    <tbody>
    @foreach($games as $game)
        <tr>
            <th>{{ $game->id }}</th>
            <td>{{ $game->user->name }}</td>
            <td>{{ $game->user->phone_number }}</td>
            <td>{{ $game->user->email }}</td>
            <td>{{ $game->score }}</td>
            <td>{{ $game->won_prize ? 'Yes' : 'No' }}</td>
            <td>{{ $game->reward }}</td>
            <td>{{ \Carbon\Carbon::parse($game->created_at)->format('Y/m/d H:i:s') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
