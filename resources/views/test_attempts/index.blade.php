@extends('adminlte::page')

@section('title', 'Test Attempts')

@section('content_header')
    <h1>Test Attempts</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Test Attempts Listing</h3>
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
                    <i class="fas fa-plus"></i> Add New Test Attempt
                </button>
            </div>
            <table class="table table-bordered dataTable dtr-inline collapsed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Paper</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Score</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($testAttempts as $testAttempt)
                    <tr>
                        <td>{{ $testAttempt->id }}</td>
                        <td>{{ $testAttempt->user->name?? 'N/A' }}</td>
                        <td>{{ $testAttempt->paper->name?? 'N/A' }}</td>
                        <td>{{ $testAttempt->start_time }}</td>
                        <td>{{ $testAttempt->end_time }}</td>
                        <td>{{ $testAttempt->score }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#testAttemptViewModal{{ $testAttempt->id }}"><i class="fas fa-eye"></i> View</button>
                            <button type="button" class="btn btn-primary btn-sm" wire:click="$emitTo('form-modal', 'showModal', {{ json_encode(['modelId' => $testAttempt->id, 'modelType' => 'test-attempt']) }})"><i class="fas fa-edit"></i> Edit</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure you want to delete this test attempt?')) { document.getElementById('delete-test-attempt-{{ $testAttempt->id }}').submit(); }"><i class="fas fa-trash"></i> Delete</button>
                            <form id="delete-test-attempt-{{ $testAttempt->id }}" action="{{ route('test-attempts.destroy', $testAttempt->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @include('test_attempts._view_modal', ['testAttempt' => $testAttempt])
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">
                            {{ $testAttempts->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer">
            Test Attempts Management
        </div>
    </div>

    @livewire('form-modal', [
        'modalId' => 'testAttemptFormModal',
        'modalTitle' => 'Create New Test Attempt',
        'formAction' => route('test-attempts.store'),
        'submitButtonLabel' => 'Save Test Attempt',
        'fields' => [
            ['name' => 'user_id', 'label' => 'User', 'type' => 'select', 'col' => 6, 'options' => $users->pluck('name', 'id')->toArray()],
            ['name' => 'paper_id', 'label' => 'Paper', 'type' => 'select', 'col' => 6, 'options' => $papers->pluck('name', 'id')->toArray()],
            ['name' => 'start_time', 'label' => 'Start Time', 'type' => 'text', 'col' => 6], // Consider datetime input
            ['name' => 'end_time', 'label' => 'End Time', 'type' => 'text', 'col' => 6],     // Consider datetime input
            ['name' => 'score', 'label' => 'Score', 'type' => 'number', 'col' => 6],
        ],
    ], key('test-attempt-create-modal'))

    @livewire('form-modal', [
        'modalId' => 'testAttemptFormModal',
        'modalTitle' => 'Edit Test Attempt',
        'formAction' => route('test-attempts.update', ['test_attempt' => '__modelId__']), // Placeholder
        'submitButtonLabel' => 'Update Test Attempt',
        'fields' => [
            ['name' => 'user_id', 'label' => 'User', 'type' => 'select', 'col' => 6, 'options' => $users->pluck('name', 'id')->toArray()],
            ['name' => 'paper_id', 'label' => 'Paper', 'type' => 'select', 'col' => 6, 'options' => $papers->pluck('name', 'id')->toArray()],
            ['name' => 'start_time', 'label' => 'Start Time', 'type' => 'text', 'col' => 6], // Consider datetime input
            ['name' => 'end_time', 'label' => 'End Time', 'type' => 'text', 'col' => 6],     // Consider datetime input
            ['name' => 'score', 'label' => 'Score', 'type' => 'number', 'col' => 6],
        ],
        'model' => null
    ], key('test-attempt-edit-modal'))


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
                let modal = $('#testAttemptFormModal');
                let form = modal.find('form');
                let title = modal.find('.modal-title');
                let submitButton = modal.find('button[type="submit"]');

                if (data && data.modelType === 'test-attempt' && data.modelId) { // Edit mode
                    title.text('Edit Test Attempt');
                    form.attr('action', "{{ route('test-attempts.update', '') }}/" + data.modelId);
                    submitButton.text('Update Test Attempt');
                     // Placeholder for data loading - implement fetching test attempt data if needed
                } else { // Create mode
                    title.text('Create New Test Attempt');
                    form.attr('action', "{{ route('test-attempts.store') }}");
                    submitButton.text('Save Test Attempt');
                    form[0].reset();
                }
                modal.modal('show');
            });
        })
    </script>
@stop