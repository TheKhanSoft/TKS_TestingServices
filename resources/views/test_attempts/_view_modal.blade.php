<x-adminlte-modal id="testAttemptViewModal{{ $testAttempt->id }}" title="View Test Attempt Details" theme="info" icon="fas fa-eye" size='lg' v-centered>
    <div class="modal-body">
        <dl>
            <dt>ID</dt>
            <dd>{{ $testAttempt->id }}</dd>
            <dt>User</dt>
            <dd>{{ $testAttempt->user->name?? 'N/A' }}</dd>
            <dt>Paper</dt>
            <dd>{{ $testAttempt->paper->name?? 'N/A' }}</dd>
            <dt>Start Time</dt>
            <dd>{{ $testAttempt->start_time }}</dd>
            <dt>End Time</dt>
            <dd>{{ $testAttempt->end_time }}</dd>
            <dt>Score</dt>
            <dd>{{ $testAttempt->score }}</dd>
            <dt>Created At</dt>
            <dd>{{ $testAttempt->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $testAttempt->updated_at }}</dd>
        </dl>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button class="btn-secondary" style="margin-right: 5px;" data-dismiss="modal" label="Close"/>
    </x-slot>
</x-adminlte-modal>