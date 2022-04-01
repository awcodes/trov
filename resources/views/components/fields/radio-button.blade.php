<x-forms::field-wrapper :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()">
    @if ($isInline())
        <x-slot name="labelSuffix">
    @endif
    <div {{ $attributes->merge($getExtraAttributes())->class(['filament-forms-radio-component flex']) }}>
        @php
            $isDisabled = $isDisabled();
        @endphp

        @foreach ($getOptions() as $value => $label)
            <div @class([
                'flex items-start group border w-full transition duration-75 shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600 py-2.5 px-3 gap-2',
                'rounded-l-lg' => $loop->first,
                'rounded-r-lg' => $loop->last,
            ])>
                <div class="flex items-center h-5">
                    <input name="{{ $getId() }}"
                        id="{{ $getId() }}-{{ $value }}"
                        type="radio"
                        value="{{ $value }}"
                        {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}"
                        {{ $getExtraInputAttributeBag()->class(['focus:ring-primary-500 h-4 w-4 text-primary-600','dark:bg-gray-700 dark:checked:bg-primary-500' => config('forms.dark_mode'),'border-gray-300' => !$errors->has($getStatePath()),'dark:border-gray-500' => !$errors->has($getStatePath()) && config('forms.dark_mode'),'border-danger-600 ring-danger-600' => $errors->has($getStatePath())]) }}
                        {!! $isDisabled || $isOptionDisabled($value, $label) ? 'disabled' : null !!} />
                </div>

                <div class="text-sm">
                    <label for="{{ $getId() }}-{{ $value }}"
                        @class([
                            'font-medium',
                            'text-gray-700' => !$errors->has($getStatePath()),
                            'dark:text-gray-200' =>
                                !$errors->has($getStatePath()) && config('forms.dark_mode'),
                            'text-danger-600' => $errors->has($getStatePath()),
                        ])>
                        {{ $label }}
                    </label>

                    @if ($hasDescription($value))
                        <p @class([
                            'text-gray-500',
                            'dark:text-gray-400' => config('forms.dark_mode'),
                        ])>
                            {{ $getDescription($value) }}
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    @if ($isInline())
        </x-slot>
    @endif
</x-forms::field-wrapper>
