@extends('adminlte::page')

@section('title', 'Subjects')

@section('content_header')
    <h1>Subjects</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Subjects Listing</h3>
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
                    <i class="fas fa-plus"></i> Add New Subject
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
                    @foreach($subjects as $subject)
                    <tr>
                        <td>{{ $subject->id }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->description }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#subjectViewModal{{ $subject->id }}"><i class="fas fa-eye"></i> View</button>
                            <button type="button" class="btn btn-primary btn-sm" wire:click="$emitTo('form-modal', 'showModal', {{ json_encode(['modelId' => $subject->id]) }})"><i class="fas fa-edit"></i> Edit</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure you want to delete this subject?')) { document.getElementById('delete-subject-{{ $subject->id }}').submit(); }"><i class="fas fa-trash"></i> Delete</button>
                            <form id="delete-subject-{{ $subject->id }}" action="{{ route('subjects.destroy', $subject->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @include('subjects._view_modal', ['subject' => $subject])
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            {{ $subjects->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer">
            Subjects Management
        </div>
    </div>

    @livewire('form-modal', [
        'modalId' => 'subjectFormModal',
        'modalTitle' => 'Create New Subject',
        'formAction' => route('subjects.store'),
        'submitButtonLabel' => 'Save Subject',
        'fields' => [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'col' => 6],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'col' => 6],
        ],
    ], key('subject-create-modal'))

    @livewire('form-modal', [
        'modalId' => 'subjectFormModal',
        'modalTitle' => 'Edit Subject',
        'formAction' => route('subjects.update', ['subject' => '__subjectId__']), // Placeholder for subject ID
        'submitButtonLabel' => 'Update Subject',
        'fields' => [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'col' => 6],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'col' => 6],
        ],
        'model' => null // We'll load the model dynamically
    ], key('subject-edit-modal'))


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
                let modal = $('#subjectFormModal');
                let form = modal.find('form');
                let title = modal.find('.modal-title');
                let submitButton = modal.find('button[type="submit"]');

                if (data && data.modelId) { // Edit mode
                    title.text('Edit Subject');
                    form.attr('action', "{{ route('subjects.update', '') }}/" + data.modelId);
                    submitButton.text('Update Subject');
                    // Fetch subject data and populate form fields (you'll need to implement this part - e.g., using another Livewire call or AJAX)
                    // For now, let's assume you have subject data available in the listing view already and can pass it.
                    // In a real application, you'd likely fetch the subject data from the server when the edit button is clicked.

                } else { // Create mode
                    title.text('Create New Subject');
                    form.attr('action', "{{ route('subjects.store') }}");
                    submitButton.text('Save Subject');
                    form[0].reset(); // Reset form fields
                }


                modal.modal('show');
            });
        })
    </script>
@stop