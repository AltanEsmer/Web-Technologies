<form id="searchForm" 
      action="{{ route('playlists.searchSpotify', $playlist) }}" 
      method="GET" 
      class="mb-8">
    <div class="flex gap-4">
        <input type="text" 
               name="query" 
               value="{{ $query }}"
               placeholder="Search for songs" 
               class="flex-1 p-3 border rounded-lg border-gray-300 focus:border-[#006D77] transition-colors duration-200"
               required>
        <button type="submit" 
                class="px-6 py-3 bg-white text-[#006D77] border border-[#006D77] rounded-lg hover:bg-[#006D77] hover:text-white transition-all duration-200">
            <span class="button-text">Search</span>
            <span class="loading-text hidden">
                <i class="fas fa-spinner fa-spin mr-2"></i>Searching...
            </span>
        </button>
    </div>
</form> 