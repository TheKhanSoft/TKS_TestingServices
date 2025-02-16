<x-adminlte-modal id="paperCategoryViewModal{{ $paperCategory->id }}" title="View Paper Category Details" theme="info" icon="fas fa-eye" size='sm' v-centered>
    <div class="modal-body">
        <dl>
            <dt>ID</dt>
            <dd>{{ $paperCategory->id }}</dd>
            <dt>Name</dt>
            <dd>{{ $paperCategory->name }}</dd>
            <dt>Description</dt>
            <dd>{{ $paperCategory->description }}</dd>
            <dt>Created At</dt>
            <dd>{{ $paperCategory->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $paperCategory->updated_at }}</dd>
        </dl>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button class="btn-secondary" style="margin-right: 5px;" data-dismiss="modal" label="Close"/>
    </x-slot>
</x-adminlte-modal>