@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border border-base-100 bg-base-300 rounded-lg placeholder-gray-600 dark:placeholder-gray-400
                           transition duration-150 ease-out
                           focus:ring-indigo-600 focus:outline-none focus:ring-2']) }}>
