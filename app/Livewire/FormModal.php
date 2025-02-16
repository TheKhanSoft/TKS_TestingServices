<?php

namespace App\Livewire;

use Livewire\Component;

class FormModal extends Component
{
    public bool $show = false;
    public string $modalId;
    public string $modalTitle;
    public string $formAction;
    public string $submitButtonLabel;
    public array $fields = []; // Array to hold form fields configuration
    public $model = null; // To hold the model instance for editing

    public array $formData = []; 

    public function mount(string $modalId, string $modalTitle, string $formAction, string $submitButtonLabel, array $fields, $model = null)
    {
        $this->modalId = $modalId;
        $this->modalTitle = $modalTitle;
        $this->formAction = $formAction;
        $this->submitButtonLabel = $submitButtonLabel;
        $this->fields = $fields;
        $this->model = $model;
        
        $this->initializeFormData(); 

        if ($this->model) {
            $this->loadModelData(); // Load model data if in edit mode
        }
    }

    public function showModal()
    {
        console.log('Modal ID received:', modalId);
        $this->emit('show-form-modal', $this->modalId);
        $this->show = true;
    }

    private function initializeFormData()
    {
        foreach ($this->fields as $field) {
            $this->formData[$field['name']] = ''; // Initialize each field in formData
        }
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function submitForm()
    {
        // Validation and submission logic will be implemented in child components or handled based on formAction
        // For now, just close the modal
        $this->closeModal();
        session()->flash('message', 'Form submitted successfully!'); // Example flash message
    }

    private function loadModelData()
    {
        if ($this->model) {
            foreach ($this->fields as $field) {
                $fieldName = $field['name'];
                if (isset($this->model->$fieldName)) {
                    $this->formData[$fieldName] = $this->model->$fieldName; // Load data into formData
                    //$this->{$fieldName} = $this->model->$fieldName; // Dynamically set property based on field name
                }
            }
        }
    }


    public function render()
    {
        return view('livewire.form-modal');
    }
}