@php
    $extraAlpineAttributes = $getExtraAlpineAttributes();
    $id = $getId();
    $isConcealed = $isConcealed();
    $isDisabled = $isDisabled();
    $isPrefixInline = $isPrefixInline();
    $isSuffixInline = $isSuffixInline();
    $prefixActions = $getPrefixActions();
    $prefixIcon = $getPrefixIcon();
    $prefixLabel = $getPrefixLabel();
    $suffixActions = $getSuffixActions();
    $suffixIcon = $getSuffixIcon();
    $suffixLabel = $getSuffixLabel();
    $statePath = $getStatePath();
    $numberInput = $getNumberInput();
    $isAutofocused = $isAutofocused();
    $inputType = $getType();
    $autocomplete = $getAutocomplete();
    $isRtl = $getInputsContainerDirection();
@endphp
@php
    // Obtém a altura e a largura do campo de entrada
    $height = $getHeight();
    $width = $getWidth();

    //Adicionar alinha do otp
    $align = $getAlign(); // Recebe a propriedade de alinhamento
    $alignmentClass = '';
    if ($align === 'left') {
        $alignmentClass = 'justify-start';
    } elseif ($align === 'center') {
        $alignmentClass = 'justify-center';
    } elseif ($align === 'right') {
        $alignmentClass = 'justify-end';
    }
@endphp

<div class="flex {{$alignmentClass}} items-center w-full">
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-actions="$getHintActions()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
<div x-data="{
    state: $wire.$entangle('{{ $getStatePath() }}'),
    length: {{$numberInput}},
    autoFocus: '{{$isAutofocused}}',
    type: '{{$inputType}}',
    clearOnEnter: {{ $shouldClearOnEnter() ? 'true' : 'false' }},
    init: function(){
        if (this.autoFocus){
            this.$refs[1].focus();
        }
    },
    handleInput(e, i) {
        const input = e.target;
        if(input.value.length > 1){
            input.value = input.value.substring(0, 1);
        }

        this.state = Array.from(Array(this.length), (element, i) => {
            const el = this.$refs[(i + 1)];
            return el.value ? el.value : '';
        }).join('');

        if (i < this.length) {
            this.$refs[i+1].focus();
            this.$refs[i+1].select();
        }
        if(i == this.length  && this.clearOnEnter){
            @this.set('{{ $getStatePath() }}', this.state)
        }
    },

    handlePaste(e) {
        const paste = e.clipboardData.getData('text');
        this.value = paste;
        const inputs = Array.from(Array(this.length));

        inputs.forEach((element, i) => {
            this.$refs[(i+1)].focus();
            this.$refs[(i+1)].value = paste[i] || '';
        });
    },

    handleBackspace(e) {
        const ref = e.target.getAttribute('x-ref');
        e.target.value = '';
        const previous = ref - 1;
        this.$refs[previous] && this.$refs[previous].focus();
        this.$refs[previous] && this.$refs[previous].select();
        e.preventDefault();
    },

    handleEnter(e) {
        if (e.key === 'Enter') {
            Array.from(Array(this.length), (element, i) => {
                const el = this.$refs[(i + 1)];
                if (el) el.value = '';
            });
            this.state = '';
            @this.set('{{ $getStatePath() }}', '');
        }
    },
}">
<div class="flex flex-row items-center space-x-4" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <!-- Primeiro Grupo de 3 Inputs -->
    <div class="flex items-center gap-1 md:gap-2 ">
        @foreach(range(1, 3) as $column)
        <x-filament::input.wrapper
        :disabled="$isDisabled"
                :inline-prefix="$isPrefixInline"
                :inline-suffix="$isSuffixInline"
                :prefix="$prefixLabel"
                :prefix-actions="$prefixActions"
                :prefix-icon="$prefixIcon"
                :prefix-icon-color="$getPrefixIconColor()"
                :suffix="$suffixLabel"
                :suffix-actions="$suffixActions"
                :suffix-icon="$suffixIcon"
                :suffix-icon-color="$getSuffixIconColor()"
                :valid="! $errors->has($statePath)"
                :attributes="
                    \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                    ->class(['fi-fo-text-input overflow-hidden'])
                ">
                <input
                    {{$isDisabled ? 'disabled' : ''}}
                    type="{{$inputType}}"
                    maxlength="1"
                    x-ref="{{$column}}"
                     
                    autocomplete="{{$autocomplete}}"
                    class="fi-input fi-otp-input responsive-input block w-full border-none  p-0 text-lg text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 dark:text-white dark:placeholder:text-gray-500 leading-8 bg-white/0 text-center"
                    x-on:input="handleInput($event, {{$column}})"
                    x-on:paste="handlePaste($event)"
                    x-on:keydown.backspace="handleBackspace($event)"
                    x-on:keydown.enter="handleEnter($event)"
                /> 
            </x-filament::input.wrapper>
        @endforeach
    </div>

    <!-- Traço Separador -->
    <div class="text-gray-500 span-separete ">-</div>

    <!-- Segundo Grupo de 3 Inputs -->
    <div class="flex items-center gap-1 md:gap-2 ">
        @foreach(range(4, 6) as $column)
           
        <x-filament::input.wrapper
        :disabled="$isDisabled"
                :inline-prefix="$isPrefixInline"
                :inline-suffix="$isSuffixInline"
                :prefix="$prefixLabel"
                :prefix-actions="$prefixActions"
                :prefix-icon="$prefixIcon"
                :prefix-icon-color="$getPrefixIconColor()"
                :suffix="$suffixLabel"
                :suffix-actions="$suffixActions"
                :suffix-icon="$suffixIcon"
                :suffix-icon-color="$getSuffixIconColor()"
                :valid="! $errors->has($statePath)"
                :attributes="
                    \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                    ->class(['fi-fo-text-input overflow-hidden'])
                "
        >
                <input
                    {{$isDisabled ? 'disabled' : ''}}
                    type="{{$inputType}}"
                    maxlength="1" 
                    x-ref="{{$column}}"
                    autocomplete="{{$autocomplete}}"
                    class="fi-input fi-otp-input responsive-input block w-full border-none p-0 text-lg text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 dark:text-white dark:placeholder:text-gray-500 leading-8 bg-white/0 text-center"
                    x-on:input="handleInput($event, {{$column}})"
                    x-on:paste="handlePaste($event)"
                    x-on:keydown.backspace="handleBackspace($event)"
                    x-on:keydown.enter="handleEnter($event)"
                /> 
            </x-filament::input.wrapper>
        @endforeach
    </div>

    <!-- Traço Separador -->
    <div class="text-gray-500 span-separete">-</div>

    <!-- Terceiro Grupo de 3 Inputs -->
    <div class="flex items-center gap-1 md:gap-2">
        @foreach(range(7, 9) as $column)
        <x-filament::input.wrapper
        :disabled="$isDisabled"
                :inline-prefix="$isPrefixInline"
                :inline-suffix="$isSuffixInline"
                :prefix="$prefixLabel"
                :prefix-actions="$prefixActions"
                :prefix-icon="$prefixIcon"
                :prefix-icon-color="$getPrefixIconColor()"
                :suffix="$suffixLabel"
                :suffix-actions="$suffixActions"
                :suffix-icon="$suffixIcon"
                :suffix-icon-color="$getSuffixIconColor()"
                :valid="! $errors->has($statePath)"
                :attributes="
                    \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                    ->class(['fi-fo-text-input overflow-hidden'])
                "
        >
                <input
                    {{$isDisabled ? 'disabled' : ''}}
                    type="{{$inputType}}"
                    maxlength="1"
                    x-ref="{{$column}}"
                    autocomplete="{{$autocomplete}}"
                     
                    class="fi-input fi-otp-input responsive-input block w-full border-none  p-0 text-lg text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 dark:text-white dark:placeholder:text-gray-500 leading-8 bg-white/0 text-center"
                    x-on:input="handleInput($event, {{$column}})"
                    x-on:paste="handlePaste($event)"
                    x-on:keydown.backspace="handleBackspace($event)"
                    x-on:keydown.enter="handleEnter($event)"
                /> 
            </x-filament::input.wrapper>
        @endforeach
    </div>
</div>

    
    </div>

</x-dynamic-component>
</div>
<style>
    input.fi-otp-input[type=number] {
        -webkit-appearance: textfield;
        -moz-appearance: textfield;
        appearance: textfield;
        overflow: visible;
    }

    input.fi-otp-input[type=number]::-webkit-inner-spin-button,
    input.fi-otp-input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0
    }
    .responsive-input {
        height: {{ $height ?? '40px' }};
        width: {{ $width ?? '40px' }};
        
    }
    .span-separete{
            padding: 0 10px;
        }
    /* Estilos para dispositivos móveis (largura de tela de até 768px) */
    @media (max-width: 768px) {
        .span-separete{
            padding: 0 5px;
        }
        .responsive-input {
           text-align: center; /* Centraliza o texto */
            height: 40px; /* Altura menor para dispositivos móveis */
            width:100%;  /* Largura menor para dispositivos móveis */
            margin: 0 2px; /* Espaçamento para garantir alinhamento */
        }
    }
</style>
