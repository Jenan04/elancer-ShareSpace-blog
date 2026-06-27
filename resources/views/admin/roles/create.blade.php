<x-layouts.app>
    <x-slot:title>Dashboard - Create New Role</x-slot>

    <x-navbar />

    <main class="min-h-screen bg-surface pt-32 pb-24 px-6 md:px-12 max-w-3xl mx-auto font-sans relative z-10">
        <div class="border-b border-outline-variant/20 pb-6 mb-8">
            <a href="{{ route('roles.index') }}" class="text-sm font-semibold text-primary hover:underline flex items-center gap-1 mb-4">
                <span class="material-symbols-outlined text-base">arrow_back</span> Back to Roles
            </a>
            <h1 class="text-3xl font-bold text-on-surface">Create New Role</h1>
        </div>

        <form action="{{ route('roles.store') }}" method="POST" class="bg-surface-container-lowest rounded-3xl p-8 border border-outline-variant/20 shadow-sm space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-on-surface mb-2">Role Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       placeholder="e.g., Senior Editor, Moderator"
                       class="w-full px-4 py-3 rounded-2xl border border-outline-variant/30 bg-surface focus:outline-none focus:border-primary transition-all text-on-surface">
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-on-surface mb-3">Assign Abilities & Permissions</label>
                @error('abilities')
                    <p class="text-xs text-red-600 mb-3">{{ $message }}</p>
                @enderror
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($abilities as $key => $label)
                        <label class="flex items-start gap-3 p-4 rounded-2xl border border-outline-variant/20 hover:border-primary/40 bg-surface-container-low/40 cursor-pointer transition-all group">
                            <input type="checkbox" name="abilities[]" value="{{ $key }}" 
                                   {{ is_array(old('abilities')) && in_array($key, old('abilities')) ? 'checked' : '' }}
                                   class="w-5 h-5 rounded border-outline-variant/50 text-primary focus:ring-primary mt-0.5 cursor-pointer">
                            <div>
                                <span class="text-sm font-semibold text-on-surface group-hover:text-primary transition-colors block">{{ $label }}</span>
                                <span class="text-xs text-on-surface-variant/60 font-mono">{{ $key }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="pt-6 border-t border-outline-variant/10 flex items-center justify-end gap-4">
                <a href="{{ route('roles.index') }}" class="px-6 py-2.5 rounded-full text-sm font-semibold text-on-surface-variant hover:bg-surface-container-high transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-full text-sm font-semibold bg-primary text-white hover:bg-primary/95 shadow-sm transition-all">
                    Save Role
                </button>
            </div>
        </form>
    </main>
</x-layouts.app>