@extends('layouts.app')

@section('content')
    <h1>Items</h1>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.items.create') }}">Create Item</a>

    <table border="1" cellpadding="8">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Action</th>
        </tr>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->stock }}</td>
                <td>
                    <a href="{{ route('admin.items.edit', $item) }}">Edit</a>
                    <form action="{{ route('admin.items.destroy', $item) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Delete this item?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {{ $items->links() }}
@endsection
