<x-adminlte-modal id="paperViewModal{{ $paper->id }}" title="View Paper Details" theme="info" icon="fas fa-eye" size='lg' v-centered>
    <div class="modal-body">
        <dl>
            <dt>ID</dt>
            <dd>{{ $paper->id }}</dd>
            <dt>Name</dt>
            <dd>{{ $paper->name }}</dd>
            <dt>Paper Category</dt>
            <dd>{{ $paper->paperCategory->name?? 'N/A' }}</dd>
            <dt>Subject</dt>
            <dd>{{ $paper->subject->name?? 'N/A' }}</dd>
            <dt>Total Marks</dt>
            <dd>{{ $paper->total_marks }}</dd>
            <dt>Time (Minutes)</dt>
            <dd>{{ $paper->time_minutes }}</dd>
            <dt>Created At</dt>
            <dd>{{ $paper->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $paper->updated_at }}</dd>
        </dl>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button class="btn-secondary" style="margin-right: 5px;" data-dismiss="modal" label="Close"/>
    </x-slot>
</x-adminlte-modal>