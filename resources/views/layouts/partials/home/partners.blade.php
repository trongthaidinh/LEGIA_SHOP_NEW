    <div class="bg-primary-dark py-10 px-4 border-t border-white/10">
        <h2 class="text-xl font-bold mb-6 text-white border-b border-white pb-2">ĐỐI TÁC LIÊN KẾT</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($partners as $partner)
                <a href="{{ $partner->website_url }}" target="_blank" 
                   class="block bg-white group border rounded-lg py-2 hover:shadow-md transition-all duration-300">
                    <div class="aspect-[4/3] flex items-center justify-center">
                        @if($partner->logo)
                            <img src="{{  Storage::url($partner->logo) }}" 
                                 alt="{{ $partner->name }}" 
                                 class="max-h-full w-auto object-contain group-hover:scale-105 transition-transform duration-300">
                        @else
                            <span class="text-center text-gray-600 group-hover:text-[white] transition-colors duration-300">
                                {{ $partner->name }}
                            </span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
