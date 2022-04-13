<div @if ($isCollapsible()) x-data="{ isCollapsed: {{ $isCollapsed() ? 'true' : 'false' }} }"
        x-on:expand-concealing-component.window="if ($event.detail.id === $el.id) isCollapsed = false" @endif
    id="{{ $getId() }}"
    {{ $attributes->merge($getExtraAttributes())->class([
            'bg-white rounded-xl border border-gray-300 filament-forms-section-component',
            'dark:border-gray-600 dark:bg-gray-800' => config('forms.dark_mode'),
        ]) }}
    {{ $getExtraAlpineAttributeBag() }}>
    <div @class([
        'flex items-center px-4 py-2 bg-gray-200 rtl:space-x-reverse overflow-hidden rounded-t-xl',
        'dark:bg-gray-900' => config('forms.dark_mode'),
    ])
        x-bind:class="{'rounded-b-xl': isCollapsed}">
        <div class="flex-1">
            <h3 class="text-xl font-bold tracking-tight">
                {{ $getHeading() }}
            </h3>

            @if ($description = $getDescription())
                <p @class([
                    'text-sm text-gray-500',
                    'dark:text-gray-400' => config('forms.dark_mode'),
                ])>
                    {{ $description }}
                </p>
            @endif
        </div>

        @if ($isCollapsible())
            <button x-on:click="isCollapsed = ! isCollapsed"
                x-bind:class="{
                    '-rotate-180': ! isCollapsed,
                }"
                type="button"
                class="flex items-center justify-center w-8 h-8 transform rounded-full text-primary-500 hover:bg-gray-500/5 focus:bg-primary-500/10 focus:outline-none">
                <svg class="w-6 h-6"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        @endif
    </div>

    <div
        @if ($isCollapsible()) x-bind:class="{ 'invisible h-0 !m-0 overflow-y-hidden': isCollapsed }"
            x-bind:aria-expanded="(! isCollapsed).toString()" @endif>
        <div class="p-6">
            {{ $getChildComponentContainer() }}
        </div>
    </div>
</div>
