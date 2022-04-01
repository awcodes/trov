<?php

namespace Trov\Forms\Components;

use Trov\Models\Media;
use Livewire\Component;
use Filament\Facades\Filament;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;

class MediaPicker extends Component implements HasForms
{
    use InteractsWithForms;

    public $selected = null;
    public $data;

    public function updatedSelected($value)
    {
        if ($value) {
            $item = Media::firstWhere('id', $value['id']);
            if ($item) {
                $this->data = [
                    'alt' => $item->alt,
                    'title' => $item->title,
                    'caption' => $item->caption,
                    'description' => $item->description,
                ];
            }
        }
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('alt')
                ->label('Alt Text')
                ->helperText('<a href="https://www.w3.org/WAI/tutorials/images/decision-tree" target="_blank" rel="noopener" class="underline text-primary-500 hover:text-primary-600 focus:text-primary-600">Learn how to describe the purpose of the image</a>. Leave empty if the image is purely decorative.'),
            TextInput::make('title'),
            Textarea::make('caption')
                ->rows(2),
            Textarea::make('description')
                ->rows(2),
        ];
    }

    public function update(): void
    {
        $item = Media::where('id', $this->selected['id'])->first();
        Filament::notify('success', 'Item updated successfully.');
        $item->update($this->data);
    }

    public function destroy(): void
    {
        $item = Media::where('id', $this->selected['id'])->first();
        $this->data = null;
        $this->selected = null;
        $this->dispatchBrowserEvent('remove-media', ['media' => $item]);
        $item->delete();
    }

    public function render()
    {
        return view('trov::components.media-picker');
    }
}
