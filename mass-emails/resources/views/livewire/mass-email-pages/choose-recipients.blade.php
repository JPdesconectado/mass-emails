<div>
  <div class="w-full py-2 pr-2 font-bold text-xl px-2">4. {{__('mass-emails::menu.recipients_message')}}</div>

  <div class="grid grid-rows-3">
      <div class="space-y-2 mt-4 ml-6">
          <input wire:model.lazy="recipients" type="radio" name="recipients" id="recipients" value="contact"required>
          <label for="recipients" class="col-md-4 col-form-label text-md-right">{{__('mass-emails::menu.contact_email')}}</label>
      </div>

      <div class="space-y-2 mt-4 ml-6">
          <input wire:model.lazy="recipients" type="radio" name="recipients" id="recipients" value="reservation" required>
          <label for="recipients" class="col-md-4 col-form-label text-md-right">{{__('mass-emails::menu.reservation_email')}}</label>
      </div>
      <div class="space-y-2 mt-4 ml-6">
          @error('recipients') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
      </div>
  </div>


</div>
