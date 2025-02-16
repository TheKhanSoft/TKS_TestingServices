<div>
    <div class="modal fade" id="{{ $modalId }}" data-show="@if($show) true @else false @endif" wire:ignore.self> {{-- Using data-show with standard Bootstrap modal --}}
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">{{ $modalTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="submitForm" id="{{ $modalId }}Form">
                    <div class="modal-body">
                        <div class="row">
                            @foreach($fields as $field)
                                <div class="col-md-{{ $field['col'] ?? '12' }}">
                                    @if ($field['type'] === 'text')
                                        <x-adminlte-input name="{{ $field['name'] }}" label="{{ $field['label'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" fgroup-class="col-md-12" wire:model="formData.{{ $field['name'] }}" />
                                    @elseif ($field['type'] === 'textarea')
                                        <x-adminlte-textarea name="{{ $field['name'] }}" label="{{ $field['label'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" rows="{{ $field['rows'] ?? 3 }}" fgroup-class="col-md-12" wire:model="formData.{{ $field['name'] }}"/>
                                    @elseif ($field['type'] === 'select')
                                        <x-adminlte-select2 name="{{ $field['name'] }}" label="{{ $field['label'] }}" fgroup-class="col-md-12" wire:model="formData.{{ $field['name'] }}">
                                            <option value="">-- Select {{ $field['label'] }} --</option>
                                            @foreach($field['options'] as $optionValue => $optionLabel)
                                                <option value="{{ $optionValue }}">{{ $optionLabel }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    @elseif ($field['type'] === 'number')
                                        <x-adminlte-input type="number" name="{{ $field['name'] }}" label="{{ $field['label'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" fgroup-class="col-md-12" wire:model="formData.{{ $field['name'] }}"/>
                                    @elseif ($field['type'] === 'checkbox')
                                        <div class="form-group col-md-12"> {{-- Adjust class 'col-md-12' as needed --}}
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" name="{{ $field['name'] }}" id="{{ $field['name'] }}" wire:model="{{ $field['name'] }}">
                                                <label for="{{ $field['name'] }}" class="custom-control-label">{{ $field['label'] }}</label>
                                            </div>
                                        </div>
                                    @elseif ($field['type'] === 'password')
                                        <x-adminlte-input type="password" name="{{ $field['name'] }}" label="{{ $field['label'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" fgroup-class="col-md-12" wire:model="formData.{{ $field['name'] }}" />
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <x-adminlte-button class="btn-secondary" style="margin-right: 5px;" data-dismiss="modal" label="Close" wire:click="closeModal"/>
                        <x-adminlte-button class="btn-primary" type="submit" label="{{ $submitButtonLabel }}"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('show-form-modal', (modalId) => {
                console.log('Modal ID received:', modalId); // Add this line
                $('#' + modalId).modal('show');
            });
        });
    </script>
@endpush


