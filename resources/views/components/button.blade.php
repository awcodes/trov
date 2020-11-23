@props([
'type' => 'button',
'kind' => 'default',
'kinds' => [
'default' => 'bg-gray-800 text-white hover:text-white hover:bg-gray-700 active:bg-gray-900 focus:text-white focus:border-gray-900 focus:bg-gray-700',
'primary' => 'bg-pink-600 text-white hover:text-white hover:bg-pink-500 active:bg-pink-700 focus:text-white focus:border-pink-700 focus:bg-pink-500',
'secondary' => 'bg-white border-gray-400 text-gray-800 hover:bg-gray-300 hover:text-gray-800 active:bg-gray-300 focus:text-gray-800 focus:border-gray-300 focus:bg-gray-300',
'danger' => 'bg-red-700 text-white hover:text-white hover:bg-red-600 active:bg-red-800 focus:text-white focus:border-red-800 focus:bg-red-600',
'warning' => 'bg-yellow-400 text-yellow-900 hover:text-yellow-900 hover:bg-yellow-300 active:bg-yellow-500 focus:text-yellow-900 focus:border-yellow-300 focus:bg-yellow-300',
'success' => 'bg-green-700 text-white hover:text-white hover:bg-green-600 active:bg-green-800 focus:text-white focus:border-green-800 focus:bg-green-600',
]
])

<button {{ $attributes->merge(['type' => $type, 'class' => $kinds[$kind] . ' inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>