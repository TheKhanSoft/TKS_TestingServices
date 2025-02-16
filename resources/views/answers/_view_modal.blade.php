<x-adminlte-modal id="answerViewModal{{ $answer->id }}" title="View Answer Details" theme="info" icon="fas fa-eye" size='sm' v-centered>
    <div class="modal-body">
        <dl>
            <dt>ID</dt>
            <dd>{{ $answer->id }}</dd>
            <dt>Test Attempt</dt>
            <dd>{{ $answer->testAttempt->id?? 'N/A' }}</dd>
            <dt>Question Option</dt>
            <dd>{{ $answer->questionOption->option_text?? 'N/A' }}</dd>
            <dt>Created At</dt>
            <dd>{{ $answer->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $answer->updated_at }}</dd>
        </dl>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button class="btn-secondary" style="margin-right: 5px;" data-dismiss="modal" label="Close"/>
    </x-slot>
</x-adminlte-modal>