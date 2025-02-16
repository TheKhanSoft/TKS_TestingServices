@extends('adminlte::page')

@section('title', 'User Categories')

@section('content_header')
    <h1>User Categories</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User Categories Listing</h3>
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
                    <i class="fas fa-plus"></i> Add New User Category
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
                    @foreach($userCategories as $userCategory)
                    <tr>
                        <td>{{ $userCategory->id }}</td>
                        <td>{{ $userCategory->name }}</td>
                        <td>{{ $userCategory->description }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#userCategoryViewModal{{ $userCategory->id }}"><i class="fas fa-eye"></i> View</button>
                            <button type="button" class="btn btn-primary btn-sm" wire:click="$emitTo('form-modal', 'showModal', {{ json_encode(['modelId' => $userCategory->id, 'modelType' => 'user-category']) }})"><i class="fas fa-edit"></i> Edit</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure you want to delete this user category?')) { document.getElementById('delete-user-category-{{ $userCategory->id }}').submit(); }"><i class="fas fa-trash"></i> Delete</button>
                            <form id="delete-user-category-{{ $userCategory->id }}" action="{{ route('user-categories.destroy', $userCategory->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @include('user_categories._view_modal', ['userCategory' => $userCategory])
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            {{ $userCategories->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer">
            User Categories Management
        </div>
    </div>

    @livewire('form-modal', [
        'modalId' => 'userCategoryFormModal',
        'modalTitle' => 'Create New User Category',
        'formAction' => route('user-categories.store'),
        'submitButtonLabel' => 'Save User Category',
        'fields' => [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'col' => 6],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'col' => 6],
        ],
    ], key('user-category-create-modal'))

    @livewire('form-modal', [
        'modalId' => 'userCategoryFormModal',
        'modalTitle' => 'Edit User Category',
        'formAction' => route('user-categories.update', ['user_category' => '__modelId__']), // Placeholder
        'submitButtonLabel' => 'Update User Category',
        'fields' => [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'col' => 6],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'col' => 6],
        ],
        'model' => null
    ], key('user-category-edit-modal'))


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
                let modal = $('#userCategoryFormModal');
                let form = modal.find('form');
                let title = modal.find('.modal-title');
                let submitButton = modal.find('button[type="submit"]');

                if (data && data.modelType === 'user-category' && data.modelId) { // Edit mode
                    title.text('Edit User Category');
                    form.attr('action', "{{ route('user-categories.update', '') }}/" + data.modelId);
                    submitButton.text('Update User Category');
                    // Placeholder for data loading - implement fetching user category data if needed
                } else { // Create mode
                    title.text('Create New User Category');
                    form.attr('action', "{{ route('user-categories.store') }}");
                    submitButton.text('Save User Category');
                    form[0].reset();
                }
                modal.modal('show');
            });
        })
    </script>
@stop