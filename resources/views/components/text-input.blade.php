@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#E85D40] focus:ring-[#E85D40] rounded-md shadow-sm']) }}>
