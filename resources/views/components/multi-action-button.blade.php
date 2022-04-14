@php
$actions = $getActions();
$buttonClasses = [];
$primaryAction = $actions[0];
if (!$primaryAction) {
    $primaryWireClickAction = null;
} elseif ($shouldOpenModal() || $primaryAction instanceof \Closure) {
    $primaryWireClickAction = "mountAction('{$primaryAction->getName()}')";
} else {
    $primaryWireClickAction = $primaryAction->getAction();
}
unset($actions[0]);
@endphp

<div x-data="{
    open: false,
    toggle() {
        if (this.open) { return this.close(); } this.$refs.button.focus();
        this.open = true;
    },
    close(focusAfter) {
        if (!this.open) return;
        this.open = false;
        focusAfter && focusAfter.focus();
    }
}"
    x-on:keydown.escape.prevent.stop="close($refs.button)"
    x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
    x-id="['dropdown-button']"
    x-bind:class="{'gap-2': open}"
    @class([
        'inline-flex items-center justify-center font-medium tracking-tight rounded-xl border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset relative filament-button p-1',
        'text-gray-800 bg-white border-gray-300 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600',
        'dark:bg-gray-800 dark:border-gray-600 dark:hover:border-gray-500 dark:text-gray-200 dark:focus:text-primary-400 dark:focus:border-primary-400 dark:focus:bg-gray-800' => config(
            'filament.dark_mode'
        ),
    ])>

    <x-filament::button :form="$primaryAction->getForm()"
        :tag="!$primaryAction->getAction() && $primaryAction->getUrl() ? 'a' : 'button'"
        :wire:click="$primaryAction->isEnabled() ? $primaryWireClickAction : null"
        :href="$primaryAction->isEnabled() ? $primaryAction->getUrl() : null"
        :target="$primaryAction->shouldOpenUrlInNewTab() ? '_blank' : null"
        :type="$primaryAction->canSubmitForm() ? 'submit' : 'button'"
        :color="$primaryAction->getColor()"
        :disabled="$primaryAction->isDisabled()"
        class="filament-page-button-action">
        {{ $primaryAction->getLabel() }}
    </x-filament::button>

    <div x-ref="panel"
        x-show="open"
        x-on:click.outside="close($refs.button)"
        x-bind:id="$id('dropdown-button')"
        style="display: none;"
        class="flex items-center gap-2">

        @foreach ($actions as $action)
            @php
                if (!$action) {
                    $wireClickAction = null;
                } elseif ($shouldOpenModal() || $action instanceof \Closure) {
                    $wireClickAction = "mountAction('{$action->getName()}')";
                } else {
                    $wireClickAction = $action->getAction();
                }
            @endphp
            @if (!$action->isHidden())
                <x-filament::button :form="$action->getForm()"
                    :tag="!$action->getAction() && $action->getUrl() ? 'a' : 'button'"
                    :wire:click="$action->isEnabled() ? $wireClickAction : null"
                    :href="$action->isEnabled() ? $action->getUrl() : null"
                    :target="$action->shouldOpenUrlInNewTab() ? '_blank' : null"
                    :type="$action->canSubmitForm() ? 'submit' : 'button'"
                    :color="$action->getColor()"
                    :disabled="$action->isDisabled()"
                    class="filament-page-button-action">
                    {{ $action->getLabel() }}
                </x-filament::button>
            @endif
        @endforeach
    </div>
    <button type="button"
        x-ref="button"
        x-on:click="toggle()"
        x-bind:aria-expanded="open"
        x-bind:aria-controls="$id('dropdown-button')"
        class="self-stretch px-2">
        <x-heroicon-o-dots-vertical class="w-4 h-4" />
    </button>
</div>
