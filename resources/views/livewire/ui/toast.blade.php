<div x-data="{ show: @entangle('visible') }"
     x-show="show"
     x-init="$watch('show', value => { if (value) setTimeout(() => show = false, 4000); })"
     x-transition
     class="fixed bottom-5 right-5 px-4 py-3 rounded-md text-white shadow-lg"
     :class="{
         'bg-green-500': '{{ $severity }}' === 'success',
         'bg-red-500': '{{ $severity }}' === 'error',
         'bg-yellow-500': '{{ $severity }}' === 'warning',
         'bg-blue-500': '{{ $severity }}' === 'info'
     }">

    <span>{{ $message }}</span>

    <button x-on:click="show = false" class="ml-4 text-white opacity-75 hover:opacity-100">
        &times;
    </button>
</div>
