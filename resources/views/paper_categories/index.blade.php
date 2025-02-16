@extends('adminlte::page')

@section('title', 'Paper Categories')

@section('content_header')
    <h1>Paper Categories</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Paper Categories Listing</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <button type="button" class="btn btn-primary" wire:click="$emitTo('form-modal', 'showModal')" >
                    <i class="fas fa-plus"></i> Add New Category
                </button>
            </div>
            <table class="table table-bordered dataTable dtr-inline collapsed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paperCategories as $paperCategory)
                    <tr>
                        <td>{{ $paperCategory->id }}</td>
                        <td>{{ $paperCategory->name }}</td>
                        <td>{{ $paperCategory->description }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#paperCategoryViewModal{{ $paperCategory->id }}"><i class="fas fa-eye"></i> View</button>
                            <button type="button" class="btn btn-primary btn-sm" wire:click="$emitTo('form-modal', 'showModal', {{ json_encode(['modelId' => $paperCategory->id, 'modelType' => 'paper-category']) }})"><i class="fas fa-edit"></i> Edit</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure you want to delete this paper category?')) { document.getElementById('delete-paper-category-{{ $paperCategory->id }}').submit(); }"><i class="fas fa-trash"></i> Delete</button>
                            <form id="delete-paper-category-{{ $paperCategory->id }}" action="{{ route('paper-categories.destroy', $paperCategory->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @include('paper_categories._view_modal', ['paperCategory' => $paperCategory])
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            {{ $paperCategories->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer">
            Paper Categories Management
        </div>
    </div>

    @livewire('form-modal', [
        'modalId' => 'paperCategoryFormModal',
        'modalTitle' => 'Create New Paper Category',
        'formAction' => route('paper-categories.store'),
        'submitButtonLabel' => 'Save Category',
        'fields' => [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'col' => 6],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'col' => 6],
        ],
    ], key('paper-category-create-modal'))

    @livewire('form-modal', [
        'modalId' => 'paperCategoryFormModal',
        'modalTitle' => 'Edit Paper Category',
        'formAction' => route('paper-categories.update', ['paper_category' => '__modelId__']), // Placeholder
        'submitButtonLabel' => 'Update Category',
        'fields' => [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'col' => 6],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'col' => 6],
        ],
        'model' => null
    ], key('paper-category-edit-modal'))


@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('.dataTable').DataTable({
                responsive: true,
                autoWidth: false,
            });
        });

        document.addEventListener('livewire:load', function () {
            Livewire.on('showModal', function (data) {
                let modal = $('#paperCategoryFormModal');
                let form = modal.find('form');
                let title = modal.find('.modal-title');
                let submitButton = modal.find('button[type="submit"]');

                if (data && data.modelType === 'paper-category' && data.modelId) { // Edit mode
                    title.text('Edit Paper Category');
                    form.attr('action', "{{ route('paper-categories.update', '') }}/" + data.modelId);
                    submitButton.text('Update Category');
                     // Placeholder for data loading - implement fetching paper category data if needed
                } else { // Create mode
                    title.text('Create New Paper Category');
                    form.attr('action', "{{ route('paper-categories.store') }}");
                    submitButton.text('Save Category');
                    form.reset();
                }
                modal.modal('show');
            });
        })
    </script>
@stop