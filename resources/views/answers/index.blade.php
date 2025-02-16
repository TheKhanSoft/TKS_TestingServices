@extends('adminlte::page')

@section('title', 'Answers')

@section('content_header')
    <h1>Answers</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Answers Listing</h3>
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
                    <i class="fas fa-plus"></i> Add New Answer
                </button>
            </div>
            <table class="table table-bordered dataTable dtr-inline collapsed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Test Attempt</th>
                        <th>Question Option</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($answers as $answer)
                    <tr>
                        <td>{{ $answer->id }}</td>
                        <td>{{ $answer->testAttempt->id?? 'N/A' }}</td>
                        <td>{{ $answer->questionOption->option_text?? 'N/A' }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#answerViewModal{{ $answer->id }}"><i class="fas fa-eye"></i> View</button>
                            <button type="button" class="btn btn-primary btn-sm" wire:click="$emitTo('form-modal', 'showModal', {{ json_encode(['modelId' => $answer->id, 'modelType' => 'answer']) }})"><i class="fas fa-edit"></i> Edit</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure you want to delete this answer?')) { document.getElementById('delete-answer-{{ $answer->id }}').submit(); }"><i class="fas fa-trash"></i> Delete</button>
                            <form id="delete-answer-{{ $answer->id }}" action="{{ route('answers.destroy', $answer->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @include('answers._view_modal', ['answer' => $answer])
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            {{ $answers->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer">
            Answers Management
        </div>
    </div>

    @livewire('form-modal', [
        'modalId' => 'answerFormModal',
        'modalTitle' => 'Create New Answer',
        'formAction' => route('answers.store'),
        'submitButtonLabel' => 'Save Answer',
        'fields' => [
            ['name' => 'test_attempt_id', 'label' => 'Test Attempt', 'type' => 'select', 'col' => 6, 'options' => $testAttempts->pluck('id', 'id')->toArray()], // Adjust pluck fields as needed
            ['name' => 'question_option_id', 'label' => 'Question Option', 'type' => 'select', 'col' => 6, 'options' => $questionOptions->pluck('option_text', 'id')->toArray()], // Adjust pluck fields as needed
        ],
    ], key('answer-create-modal'))

    @livewire('form-modal', [
        'modalId' => 'answerFormModal',
        'modalTitle' => 'Edit Answer',
        'formAction' => route('answers.update', ['answer' => '__modelId__']), // Placeholder
        'submitButtonLabel' => 'Update Answer',
        'fields' => [
            ['name' => 'test_attempt_id', 'label' => 'Test Attempt', 'type' => 'select', 'col' => 6, 'options' => $testAttempts->pluck('id', 'id')->toArray()], // Adjust pluck fields as needed
            ['name' => 'question_option_id', 'label' => 'Question Option', 'type' => 'select', 'col' => 6, 'options' => $questionOptions->pluck('option_text', 'id')->toArray()], // Adjust pluck fields as needed
        ],
        'model' => null
    ], key('answer-edit-modal'))


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
                let modal = $('#answerFormModal');
                let form = modal.find('form');
                let title = modal.find('.modal-title');
                let submitButton = modal.find('button[type="submit"]');

                if (data && data.modelType === 'answer' && data.modelId) { // Edit mode
                    title.text('Edit Answer');
                    form.attr('action', "{{ route('answers.update', '') }}/" + data.modelId);
                    submitButton.text('Update Answer');
                     // Placeholder for data loading - implement fetching answer data if needed
                } else { // Create mode
                    title.text('Create New Answer');
                    form.attr('action', "{{ route('answers.store') }}");
                    submitButton.text('Save Answer');
                    form[0].reset();
                }
                modal.modal('show');
            });
        })
    </script>
@stop