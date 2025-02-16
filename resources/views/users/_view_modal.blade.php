<x-adminlte-modal id="userViewModal{{ $user->id }}" title="View User Details" theme="info" icon="fas fa-eye" size='sm' v-centered>
    <div class="modal-body">
        <dl>
            <dt>ID</dt>
            <dd>{{ $user->id }}</dd>
            <dt>Name</dt>
            <dd>{{ $user->name }}</dd>
            <dt>Email</dt>
            <dd>{{ $user->email }}</dd>
            <dt>User Category</dt>
            <dd>{{ $user->userCategory->name?? 'N/A' }}</dd>
            <dt>Created At</dt>
            <dd>{{ $user->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $user->updated_at }}</dd>
        </dl>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button class="btn-secondary" style="margin-right: 5px;" data-dismiss="modal" label="Close"/>
    </x-slot>
</x-adminlte-modal>