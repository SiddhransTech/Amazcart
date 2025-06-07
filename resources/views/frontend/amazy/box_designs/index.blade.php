<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Box Designs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">My Box Designs</h1>
        
        <div class="mb-3">
            <a href="{{ route('frontend.box_designs.create') }}" class="btn btn-primary">Create New Box Design</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($box_designs->isEmpty())
            <p>No box designs found.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Dimensions (L x B x H)</th>
                        <th>Thickness</th>
                        <th>Flute Frequency</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($box_designs as $boxDesign)
                        <tr>
                            <td>{{ $boxDesign->id }}</td>
                            <td>{{ $boxDesign->length }} x {{ $boxDesign->breadth }} x {{ $boxDesign->height }}</td>
                            <td>{{ $boxDesign->thickness }}</td>
                            <td>{{ $boxDesign->flute_freq }}</td>
                            <td>
                                @if ($boxDesign->image_path)
                                    <img src="{{ asset('storage/' . $boxDesign->image_path) }}" alt="Box Design" style="max-width: 100px;">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('frontend.box_designs.show', $boxDesign->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('frontend.box_designs.edit', $boxDesign->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('frontend.box_designs.destroy', $boxDesign->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this box design?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $box_designs->links() }}
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>