<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Box Design</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Box Design #{{ $boxDesign->id }}</h1>

        <a href="{{ route('frontend.box_designs.index') }}" class="btn btn-secondary mb-3">Back to List</a>

        <form id="editBoxDesignForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="length" class="form-label">Length</label>
                <input type="number" class="form-control" id="length" name="length" step="0.01" value="{{ $boxDesign->length }}" required>
            </div>
            <div class="mb-3">
                <label for="breadth" class="form-label">Breadth</label>
                <input type="number" class="form-control" id="breadth" name="breadth" step="0.01" value="{{ $boxDesign->breadth }}" required>
            </div>
            <div class="mb-3">
                <label for="height" class="form-label">Height</label>
                <input type="number" class="form-control" id="height" name="height" step="0.01" value="{{ $boxDesign->height }}" required>
            </div>
            <div class="mb-3">
                <label for="thickness" class="form-label">Thickness</label>
                <input type="number" class="form-control" id="thickness" name="thickness" step="0.01" value="{{ $boxDesign->thickness }}" required>
            </div>
            <div class="mb-3">
                <label for="flute_freq" class="form-label">Flute Frequency</label>
                <input type="number" class="form-control" id="flute_freq" name="flute_freq" step="0.01" value="{{ $boxDesign->flute_freq }}" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Model File (GLTF)</label>
                <input type="file" class="form-control" id="model" name="model" accept=".glb">
                <small class="form-text">Current: {{ $boxDesign->model_path ? basename($boxDesign->model_path) : 'None' }}</small>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image File (PNG/JPG)</label>
                <input type="file" class="form-control" id="image" name="image" accept=".png,.jpg,.jpeg">
                <small class="form-text">Current: {{ $boxDesign->image_path ? basename($boxDesign->image_path) : 'None' }}</small>
            </div>
            <button type="submit" class="btn btn-primary">Update Box Design</button>
        </form>

        <div id="formFeedback" class="mt-3"></div>
    </div>

    <script>
        document.getElementById('editBoxDesignForm').addEventListener('submit', async function(e) {
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
                faces: {{ json_encode($boxDesign->faces) }} // Preserve existing faces
            };
            
            formData.set('boxData', JSON.stringify(boxData));

            try {
                const response = await fetch('/api/box-designs/{{ $boxDesign->id }}', {
                    method: 'PUT',
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



<!-- This is from the dashboard.blade.php -->
<div class="col-lg-6">
                            <div class="dashboard_white_box bg-white mb_25 amazy_full_height">
                                <div class="dashboard_white_box_header d-flex align-items-center gap_15 amazy_bb3 pb_10 mb_5">
                                    <h3 class="font_20 f_w_700 mb-0 flex-fill">{{ __('amazy.Custom Box Designs') }}</h3>
                                    <a href="{{ route('frontend.box_designs.index') }}" class="amaz_badge_btn2 text-uppercase">
                                        {{ __('common.see_all') }}
                                    </a>
                                </div>
                                <div class="dashboard_white_box_body">
                                    <div class="dash_product_lists">
                                        @forelse($carts->where('product_type', 'box_design') as $cart)
                                            <div class="dashboard_order_list d-flex align-items-center flex-wrap gap_20">
                                                <!-- Box Preview Image -->
                                                <div class="thumb">
                                                    <img 
                                                        src="{{ $cart->boxDesign->image_url }}" 
                                                        alt="Custom Box Design" 
                                                        class="img-fluid"
                                                    >
                                                </div>

                                                <!-- Box Details -->
                                                <div class="dashboard_order_content flex-grow-1">
                                                    <h4 class="font_16 f_w_700 mb-1 lh-base theme_hover">
                                                        {{ __('amazy.Custom Box') }}
                                                    </h4>

                                                    <!-- Dimensions -->
                                                    <div class="font_12 mb-1">
                                                        <span class="f_w_500">{{ __('amazy.Dimensions') }}:</span>
                                                        <span>
                                                            {{ $cart->boxDesign->length }} cm (L) × 
                                                            {{ $cart->boxDesign->breadth }} cm (W) × 
                                                            {{ $cart->boxDesign->height }} cm (H)
                                                        </span>
                                                    </div>

                                                    <!-- Thickness -->
                                                    <div class="font_12 mb-1">
                                                        <span class="f_w_500">{{ __('amazy.Thickness') }}:</span>
                                                        <span>{{ $cart->boxDesign->thickness }} mm</span>
                                                    </div>

                                                    <!-- Flute Frequency -->
                                                    <div class="font_12 mb-2">
                                                        <span class="f_w_500">{{ __('amazy.Flute Frequency') }}:</span>
                                                        <span>{{ $cart->boxDesign->flute_freq }} flutes/cm</span>
                                                    </div>

                                                    <!-- Price -->
                                                    <p class="font_14 f_w_500 d-flex align-items-center gap-2">
                                                        <span class="secondary_text">{{ single_price($cart->price) }}</span>
                                                    </p>

                                                    <!-- Actions -->
                                                    <div class="d-flex gap-2 mt-2">
                                                        <a 
                                                            href="{{ route('frontend.box_designs.edit', $cart->boxDesign->id) }}" 
                                                            class="btn btn-sm btn-outline-primary"
                                                        >
                                                            <i class="fas fa-edit"></i> {{ __('amazy.Edit') }}
                                                        </a>
                                                        <form 
                                                            action="{{ route('cart.remove', $cart->id) }}" 
                                                            method="POST"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash"></i> {{ __('common.Remove') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <!-- Empty State -->
                                            <div class="text-center py-4">
                                                <img 
                                                    src="{{ asset('public/frontend/amazy/img/empty-box.png') }}" 
                                                    alt="No boxes" 
                                                    width="100" 
                                                    class="mb-3"
                                                >
                                                <p class="text-muted">{{ __('amazy.No custom boxes in cart') }}</p>
                                                <a 
                                                    href="{{ route('frontend.box_designs.create') }}" 
                                                    class="btn btn-primary btn-sm"
                                                >
                                                    {{ __('amazy.Design a Box') }}
                                                </a>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Editing Box Design -->
                        <div class="modal fade" id="editBoxModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('amazy.Edit Box Design') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- This will be loaded dynamically via AJAX -->
                                        <div class="text-center py-5">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @push('scripts')
                        <script>
                        $(document).ready(function() {
                            // Handle edit box design button click
                            $('.edit-box-btn').on('click', function() {
                                const boxId = $(this).data('box-id');
                                const cartId = $(this).data('cart-id');
                                
                                $('#editBoxModal').modal('show');
                                
                                // Load the box designer in the modal
                                $.get(`/box-designs/${boxId}/edit?cart_id=${cartId}`, function(data) {
                                    $('#editBoxModal .modal-body').html(data);
                                }).fail(function() {
                                    $('#editBoxModal .modal-body').html(
                                        '<div class="alert alert-danger">Failed to load box designer</div>'
                                    );
                                });
                            });
                            
                            // Handle remove box from cart
                            $('.remove-box-btn').on('click', function() {
                                const cartId = $(this).data('cart-id');
                                
                                if(confirm('Are you sure you want to remove this box from your cart?')) {
                                    $.ajax({
                                        url: `/cart/${cartId}`,
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        success: function() {
                                            window.location.reload();
                                        },
                                        error: function() {
                                            alert('Failed to remove box from cart');
                                        }
                                    });
                                }
                            });
                        });
                        </script>
                        @endpush
                    </div>