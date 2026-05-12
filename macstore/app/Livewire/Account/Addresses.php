<?php

namespace App\Livewire\Account;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Addresses extends Component
{
    public $showModal = false;
    public $editingId = null;

    public $label = '';
    public $address_line1 = '';
    public $address_line2 = '';
    public $city = '';
    public $state = '';
    public $postal_code = '';
    public $country = 'Cambodia';
    public $phone = '';
    public $is_default = false;

    protected $rules = [
        'label' => 'required|string|max:255',
        'address_line1' => 'required|string|max:255',
        'address_line2' => 'nullable|string|max:255',
        'city' => 'required|string|max:255',
      'state' => 'required|string|max:255',
     'postal_code' => 'required|string|max:20',
        'country' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
     'is_default' => 'boolean',
    ];

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }
    public function editAddress($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        $this->editingId = $id;
        $this->label = $address->label;
      $this->address_line1 = $address->address_line1;
        $this->address_line2 = $address->address_line2;
        $this->city = $address->city;
        $this->state = $address->state;
        $this->postal_code = $address->postal_code;
        $this->country = $address->country;
        $this->phone = $address->phone;
        $this->is_default = $address->is_default;

        $this->showModal = true;
    }

    public function saveAddress()
    {
        $this->validate();

        if ($this->is_default) {
       Auth::user()->addresses()->update(['is_default' => false]);
      }

        if ($this->editingId) {
            $address = Auth::user()->addresses()->findOrFail($this->editingId);
          $address->update([
                'label' => $this->label,
                'address_line1' => $this->address_line1,
           'address_line2' => $this->address_line2,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
              'country' => $this->country,
              'phone' => $this->phone,
                'is_default' => $this->is_default,
         ]);

            session()->flash('success', __('Address updated successfully'));
        } else {
            Auth::user()->addresses()->create([
                'label' => $this->label,
              'address_line1' => $this->address_line1,
                'address_line2' => $this->address_line2,
              'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
                'country' => $this->country,
                'phone' => $this->phone,
            'is_default' => $this->is_default,
         ]);

            session()->flash('success', __('Address added successfully'));
        }

        $this->closeModal();
    }

    public function deleteAddress($id)
    {
        Auth::user()->addresses()->findOrFail($id)->delete();
        session()->flash('success', __('Address deleted successfully'));
    }

    public function setDefault($id)
    {
        Auth::user()->addresses()->update(['is_default' => false]);
        Auth::user()->addresses()->findOrFail($id)->update(['is_default' => true]);
        session()->flash('success', __('Default address updated'));
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->label = '';
        $this->address_line1 = '';
        $this->address_line2 = '';
        $this->city = '';
        $this->state = '';
        $this->postal_code = '';
        $this->country = 'Cambodia';
        $this->phone = '';
        $this->is_default = false;
        $this->resetErrorBag();
    }

    public function render()
    {
        $addresses = Auth::user()->addresses;

      return view('livewire.account.addresses', [
          'addresses' => $addresses,
        ]);
    }
}
