<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Box Design</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Box Design #{{ $boxDesign->id }}</h1>

        <a href="{{ route('frontend.box_designs.index') }}" class="btn btn-secondary mb-3">Back to List</a>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Design Details</h5>
                <p><strong>Length:</strong> {{ $boxDesign->length }}</p>
                <p><strong>Breadth:</strong> {{ $boxDesign->breadth }}</p>
                <p><strong>Height:</strong> {{ $boxDesign->height }}</p>
                <p><strong>Thickness:</strong> {{ $boxDesign->thickness }}</p>
                <p><strong>Flute Frequency:</strong> {{ $boxDesign->flute_freq }}</p>
                <p><strong>Faces:</strong> {{ json_encode($boxDesign->faces) }}</p>
                <p><strong>Model:</strong> 
                    @if ($boxDesign->model_path)
                        <a href="{{ asset('storage/' . $boxDesign->model_path) }}" download>Download Model</a>
                    @else
                        No Model
                    @endif
                </p>
                <p><strong>Image:</strong></p>
                @if ($boxDesign->image_path)
                    <img src="{{ asset('storage/' . $boxDesign->image_path) }}" alt="Box Design" class="img-fluid" style="max-width: 300px;">
                @else
                    <p>No Image</p>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('frontend.box_designs.edit', $boxDesign->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('frontend.box_designs.destroy', $boxDesign->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this box design?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>