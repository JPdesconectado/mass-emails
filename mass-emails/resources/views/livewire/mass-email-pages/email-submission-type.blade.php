<div>
    <div class="w-full py-2 pr-2 font-bold text-xl px-2">1. {{__('mass-emails::menu.btn_send')}}</div>

    <div class="grid grid-rows-3" wire:key="submission">
        <div class="space-y-2 mt-4 px-6">
            <input wire:model.lazy="send_type" type="radio" name="send_type" id="send_type" value="properties"required>
            <label for="send_type" class="col-md-4 col-form-label text-md-right">{{__('mass-emails::menu.properties')}}</label>
        </div>

        <div class="space-y-2 mt-4 px-6">
            <input wire:model.lazy="send_type" type="radio" name="send_type" id="send_type" value="owners" required>
            <label for="send_type" class="col-md-4 col-form-label text-md-right">{{__('mass-emails::menu.owners')}}</label>
        </div>
        <div class="space-y-2 mt-4 px-6">
            @error('send_type') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>
    </div>
</div>
