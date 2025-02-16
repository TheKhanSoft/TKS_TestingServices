@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Users</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Users Listing</h3>
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
                    <i class="fas fa-plus"></i> Add New User
                </button>
            </div>
            <table class="table table-bordered dataTable dtr-inline collapsed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->userCategory->name?? 'N/A' }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#userViewModal{{ $user->id }}"><i class="fas fa-eye"></i> View</button>
                            <button type="button" class="btn btn-primary btn-sm" wire:click="$emitTo('form-modal', 'showModal', {{ json_encode(['modelId' => $user->id, 'modelType' => 'user']) }})"><i class="fas fa-edit"></i> Edit</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure you want to delete this user?')) { document.getElementById('delete-user-{{ $user->id }}').submit(); }"><i class="fas fa-trash"></i> Delete</button>
                            <form id="delete-user-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @include('users._view_modal', ['user' => $user])
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">
                            {{ $users->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer">
            Users Management
        </div>
    </div>

    @livewire('form-modal', [
        'modalId' => 'userFormModal',
        'modalTitle' => 'Create New User',
        'formAction' => route('users.store'),
        'submitButtonLabel' => 'Save User',
        'fields' => [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'col' => 6],
            ['name' => 'email', 'label' => 'Email', 'type' => 'text', 'col' => 6],
            ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'col' => 6],
            ['name' => 'user_category_id', 'label' => 'User Category', 'type' => 'select', 'col' => 6, 'options' => $userCategories->pluck('name', 'id')->toArray()],
        ],
    ], key('user-create-modal'))

    @livewire('form-modal', [
        'modalId' => 'userFormModal',
        'modalTitle' => 'Edit User',
        'formAction' => route('users.update', ['user' => '__modelId__']), // Placeholder
        'submitButtonLabel' => 'Update User',
        'fields' => [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'col' => 6],
            ['name' => 'email', 'label' => 'Email', 'type' => 'text', 'col' => 6],
            ['name' => 'user_category_id', 'label' => 'User Category', 'type' => 'select', 'col' => 6, 'options' => $userCategories->pluck('name', 'id')->toArray()],
        ],
        'model' => null
    ], key('user-edit-modal'))


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
                let modal = $('#userFormModal');
                let form = modal.find('form');
                let title = modal.find('.modal-title');
                let submitButton = modal.find('button[type="submit"]');

                if (data && data.modelType === 'user' && data.modelId) { // Edit mode
                    title.text('Edit User');
                    form.attr('action', "{{ route('users.update', '') }}/" + data.modelId);
                    submitButton.text('Update User');
                     // Placeholder for data loading - implement fetching user data if needed
                } else { // Create mode
                    title.text('Create New User');
                    form.attr('action', "{{ route('users.store') }}");
                    submitButton.text('Save User');
                    form[0].reset();
                }
                modal.modal('show');
            });
        })
    </script>
@stop