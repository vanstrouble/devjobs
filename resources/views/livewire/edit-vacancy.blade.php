<form class="md:w-1/2 space-y-5" wire:submit.prevent='editVacancy'>
    {{-- Vacancy title --}}
    <div>
        <x-input-label for="title" :value="__('Vacante')" />

        <x-text-input
            id="title"
            class="block mt-1 w-full"
            type="text"
            wire:model="title"
            :value="old('title')"
            placeholder="Título de la vacante"
        />
        @error('title')
            <livewire:show-alert :message="$message"/>
        @enderror
    </div>

    {{-- Salary --}}
    <div>
        <x-input-label for="salary" :value="__('Salario Mensual')" />

        <select
            id="salary"
            wire:model="salary"
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
        >
            <option value="">-- Seleccione --</option>
                @foreach ($salaries as $salary)
                    <option value="{{ $salary->id }}">{{$salary->salary}}</option>
                @endforeach
        </select>

        @error('salary')
            <livewire:show-alert :message="$message"/>
        @enderror
    </div>

    {{-- Category --}}
    <div>
        <x-input-label for="category" :value="__('Categoría')" />

        <select
            id="category"
            wire:model="category"
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
        >
            <option value="">-- Seleccione --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{$category->category}}</option>
                @endforeach
        </select>

        @error('category')
            <livewire:show-alert :message="$message"/>
        @enderror
    </div>

    {{-- Company --}}
    <div>
        <x-input-label for="company" :value="__('Empresa')" />

        <x-text-input
            id="company"
            class="block mt-1 w-full"
            type="text"
            wire:model="company"
            :value="old('company')"
            placeholder="Empresa: ej. Netflix, Uber, Shopify"
        />
        @error('company')
            <livewire:show-alert :message="$message"/>
        @enderror
    </div>

    {{-- Last day --}}
    <div>
        <x-input-label for="last_day" :value="__('Fecha Límite')" />

        <x-text-input
            id="last_day"
            class="block mt-1 w-full"
            type="date"
            wire:model="last_day"
            :value="old('last_day')"
        />
        @error('last_day')
            <livewire:show-alert :message="$message"/>
        @enderror
    </div>

    {{-- Description --}}
    <div>
        <x-input-label for="description" :value="__('Descripción del Puesto')" />

        <textarea
            wire:model="description"
            placeholder="Descripción general del puesto"
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full h-72"
            >
        </textarea>
        @error('description')
            <livewire:show-alert :message="$message"/>
        @enderror
    </div>

    {{-- Image --}}
    <div>
        <x-input-label for="image" :value="__('Imagen')" />

        <x-text-input
            id="image"
            class="block mt-1 w-full"
            type="file"
            wire:model="new_image"
            accept='image/*'
        />

        <div class=" my-5 w-80">
            <x-input-label :value="__('Imagen Actual')" />
            <img src="{{ asset('storage/vacancies/' . $image) }}" alt="{{ 'Imagen Vacante ' . $title }}">
        </div>

        <div class=" my-5 w-80 block text-sm text-gray-600 font-bold uppercase mb-2">
            @if ($new_image)
                Imagen Nueva:
                <img src="{{$new_image->temporaryUrl()}}" alt="">
            @endif
        </div>

        @error('new_image')
            <livewire:show-alert :message="$message"/>
        @enderror
    </div>

    <x-primary-button>
        Guardar Cambios
    </x-primary-button>

</form>
