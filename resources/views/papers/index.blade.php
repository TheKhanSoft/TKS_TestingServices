@extends('adminlte::page')

@section('title', 'Papers')

@section('content_header')
    <h1>Papers</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Papers Listing</h3>
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
                    <i class="fas fa-plus"></i> Add New Paper
                </button>
            </div>
            <table class="table table-bordered dataTable dtr-inline collapsed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Paper Category</th>
                        <th>Subject</th>
                        <th>Total Marks</th>
                        <th>Time (Minutes)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($papers as $paper)
                    <tr>
                        <td>{{ $paper->id }}</td>
                        <td>{{ $paper->name }}</td>
                        <td>{{ $paper->paperCategory->name?? 'N/A' }}</td>
                        <td>{{ $paper->subject->name?? 'N/A' }}</td>
                        <td>{{ $paper->total_marks }}</td>
                        <td>{{ $paper->time_minutes }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#paperViewModal{{ $paper->id }}"><i class="fas fa-eye"></i> View</button>
                            <button type="button" class="btn btn-primary btn-sm" wire:click="$emitTo('form-modal', 'showModal', {{ json_encode(['modelId' => $paper->id, 'modelType' => 'paper']) }})"><i class="fas fa-edit"></i> Edit</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure you want to delete this paper?')) { document.getElementById('delete-paper-{{ $paper->id }}').submit(); }"><i class="fas fa-trash"></i> Delete</button>
                            <form id="delete-paper-{{ $paper->id }}" action="{{ route('papers.destroy', $paper->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @include('papers._view_modal', ['paper' => $paper])
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">
                            {{ $papers->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer">
            Papers Management
        </div>
    </div>

    @livewire('form-modal', [
        'modalId' => 'paperFormModal',
        'modalTitle' => 'Create New Paper',
        'formAction' => route('papers.store'),
        'submitButtonLabel' => 'Save Paper',
        'fields' => [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'col' => 6],
            ['name' => 'paper_category_id', 'label' => 'Category', 'type' => 'select', 'col' => 6, 'options' => $paperCategories->pluck('name', 'id')->toArray()],
            ['name' => 'subject_id', 'label' => 'Subject', 'type' => 'select', 'col' => 6, 'options' => $subjects->pluck('name', 'id')->toArray()],
            ['name' => 'total_marks', 'label' => 'Total Marks', 'type' => 'number', 'col' => 6],
            ['name' => 'time_minutes', 'label' => 'Time (Minutes)', 'type' => 'number', 'col' => 6],
        ],
    ], key('paper-create-modal'))

    @livewire('form-modal', [
        'modalId' => 'paperFormModal',
        'modalTitle' => 'Edit Paper',
        'formAction' => route('papers.update', ['paper' => '__modelId__']), // Placeholder
        'submitButtonLabel' => 'Update Paper',
        'fields' => [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'col' => 6],
            ['name' => 'paper_category_id', 'label' => 'Category', 'type' => 'select', 'col' => 6, 'options' => $paperCategories->pluck('name', 'id')->toArray()],
            ['name' => 'subject_id', 'label' => 'Subject', 'type' => 'select', 'col' => 6, 'options' => $subjects->pluck('name', 'id')->toArray()],
            ['name' => 'total_marks', 'label' => 'Total Marks', 'type' => 'number', 'col' => 6],
            ['name' => 'time_minutes', 'label' => 'Time (Minutes)', 'type' => 'number', 'col' => 6],
        ],
        'model' => null
    ], key('paper-edit-modal'))


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
                let modal = $('#paperFormModal');
                let form = modal.find('form');
                let title = modal.find('.modal-title');
                let submitButton = modal.find('button[type="submit"]');

                if (data && data.modelType === 'paper' && data.modelId) { // Edit mode
                    title.text('Edit Paper');
                    form.attr('action', "{{ route('papers.update', '') }}/" + data.modelId);
                    submitButton.text('Update Paper');
                    // Placeholder for data loading - implement fetching paper data if needed
                } else { // Create mode
                    title.text('Create New Paper');
                    form.attr('action', "{{ route('papers.store') }}");
                    submitButton.text('Save Paper');
                    form[0].reset();
                }
                modal.modal('show');
            });
        })
    </script>
@stop