{{--
  Shared spec picker — a Khmer24-style tap-to-open field that opens a searchable
  bottom-sheet of options and writes the chosen string back to a Livewire prop.

  Morph-safe: it is pure markup with a self-contained inline Alpine x-data object
  bound via @entangle. No <script> / no @push here, so it works even when this block
  is rendered into the page by a Livewire morph (the step1→step2 transition).
  Requires _spec-picker-styles.blade.php to be loaded once via the page's @push('styles').

  Params:
    $field        Livewire property name, e.g. 'cpu'        (required)
    $label        Field label, e.g. 'CPU'                   (required)
    $options      array<string> of choices                 (required)
    $required     bool, shows the red *                     (default false)
    $placeholder  empty-state text                          (default 'Select…')
    $searchable   bool; auto-true when options > 8          (default auto)
--}}
@php
    $required    = $required    ?? false;
    $placeholder = $placeholder ?? 'Select…';
    $searchable  = $searchable  ?? (count($options) > 8);
@endphp

<div class="pp-field" x-data="{
        isOpen: false,
        query: '',
        value: @entangle($field),
        options: @js(array_values($options)),
        searchable: {{ $searchable ? 'true' : 'false' }},
        open() {
            this.isOpen = true; this.query = '';
            document.body.style.overflow = 'hidden';
            this.$nextTick(() => { this.$refs.q && this.$refs.q.focus(); });
        },
        close() { this.isOpen = false; document.body.style.overflow = ''; },
        choose(o) { this.value = o; this.close(); },
        get filtered() {
            const q = this.query.trim().toLowerCase();
            return q ? this.options.filter(o => o.toLowerCase().includes(q)) : this.options;
        }
   }"
   @keydown.escape.window="isOpen && close()">

    <label>{{ $label }} @if($required)<span class="pp-req">*</span>@endif</label>

    <button type="button" class="pp-picker" :class="!value && 'is-empty'" @click="open()">
        <span class="pp-picker-val" x-text="value || @js($placeholder)"></span>
        <span class="pp-picker-caret">▼</span>
    </button>

    @error($field) <div class="pp-err">{{ $message }}</div> @enderror

    <template x-if="isOpen">
        <div class="pp-sheet-backdrop" @click="close()" x-transition.opacity.duration.150ms>
            <div class="pp-sheet" @click.stop
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <div class="pp-sheet-head">
                    <span>{{ $label }}</span>
                    <button type="button" class="pp-sheet-close" @click="close()" title="Close">✕</button>
                </div>

                <template x-if="searchable">
                    <input x-ref="q" x-model="query" type="text" class="pp-sheet-search"
                           placeholder="Search {{ strtolower($label) }}…">
                </template>

                <div class="pp-sheet-list">
                    <template x-for="opt in filtered" :key="opt">
                        <button type="button" class="pp-sheet-opt" :class="opt === value && 'on'"
                                @click="choose(opt)" x-text="opt"></button>
                    </template>
                    <div class="pp-sheet-empty" x-show="filtered.length === 0">No matches</div>
                </div>
            </div>
        </div>
    </template>
</div>
