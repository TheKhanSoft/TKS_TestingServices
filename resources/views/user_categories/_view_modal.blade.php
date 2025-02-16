<x-adminlte-modal id="userCategoryViewModal{{ $userCategory->id }}" title="View User Category Details" theme="info" icon="fas fa-eye" size='sm' v-centered>
    <div class="modal-body">
        <dl>
            <dt>ID</dt>
            <dd>{{ $userCategory->id }}</dd>
            <dt>Name</dt>
            <dd>{{ $userCategory->name }}</dd>
            <dt>Description</dt>
            <dd>{{ $userCategory->description }}</dd>
            <dt>Created At</dt>
            <dd>{{ $userCategory->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $userCategory->updated_at }}</dd>
        </dl>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button class="btn-secondary" style="margin-right: 5px;" data-dismiss="modal" label="Close"/>
    </x-slot>
</x-adminlte-modal>