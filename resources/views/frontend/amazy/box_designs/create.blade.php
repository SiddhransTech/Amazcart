<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Box Design</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Create New Box Design</h1>

        <a href="{{ route('frontend.box_designs.index') }}" class="btn btn-secondary mb-3">Back to List</a>

        <form id="createBoxDesignForm" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="length" class="form-label">Length</label>
                <input type="number" class="form-control" id="length" name="length" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="breadth" class="form-label">Breadth</label>
                <input type="number" class="form-control" id="breadth" name="breadth" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="height" class="form-label">Height</label>
                <input type="number" class="form-control" id="height" name="height" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="thickness" class="form-label">Thickness</label>
                <input type="number" class="form-control" id="thickness" name="thickness" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="flute_freq" class="form-label">Flute Frequency</label>
                <input type="number" class="form-control" id="flute_freq" name="flute_freq" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Model File (GLTF)</label>
                <input type="file" class="form-control" id="model" name="model" accept=".glb" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image File (PNG/JPG)</label>
                <input type="file" class="form-control" id="image" name="image" accept=".png,.jpg,.jpeg" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="seller_id" class="form-label">Seller ID</label>
                <input type="number" class="form-control" id="seller_id" name="seller_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Box Design</button>
        </form>

        <div id="formFeedback" class="mt-3"></div>
    </div>

    <script>
        document.getElementById('createBoxDesignForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const boxData = {
                parameters: {
                    length: parseFloat(formData.get('length')),
                    breadth: parseFloat(formData.get('breadth')),
                    height: parseFloat(formData.get('height')),
                    thickness: parseFloat(formData.get('thickness')),
                    fluteFreq: parseFloat(formData.get('flute_freq'))
                },
                faces: [] // Add face data if needed
            };
            
            formData.set('boxData', JSON.stringify(boxData));

            try {
                const response = await fetch('/api/box-designs/save', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                });

                const result = await response.json();
                const feedback = document.getElementById('formFeedback');

                if (response.ok) {
                    feedback.innerHTML = `<div class="alert alert-success">${result.message}</div>`;
                    setTimeout(() => window.location.href = '{{ route('frontend.box_designs.index') }}', 2000);
                } else {
                    feedback.innerHTML = `<div class="alert alert-danger">${result.message}: ${JSON.stringify(result.errors || result.error)}</div>`;
                }
            } catch (error) {
                document.getElementById('formFeedback').innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>