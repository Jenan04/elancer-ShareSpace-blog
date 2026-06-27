<x-layouts.app>
    <x-slot:title>Dashboard - Manage Roles</x-slot>

    <x-navbar />

    <main class="min-h-screen bg-surface pt-32 pb-24 px-6 md:px-12 max-w-7xl mx-auto font-sans relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-outline-variant/20 pb-8 mb-12">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold text-on-surface tracking-tight mb-3">
                    System Roles
                </h1>
                <p class="text-on-surface-variant/80 text-lg max-w-2xl">
                    Define access levels, control writer actions, and manage granular security capabilities.
                </p>
            </div>
            
            <div class="mt-6 md:mt-0">
                <x-button variant="primary" href="{{ route('roles.create') }}" class="rounded-full shadow-sm">
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">add</span> Create New Role
                    </span>
                </x-button>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/20 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-high/50 border-b border-outline-variant/20">
                            <th class="p-6 text-sm font-semibold text-on-surface">Role Name</th>
                            <th class="p-6 text-sm font-semibold text-on-surface">Assigned Users</th>
                            <th class="p-6 text-sm font-semibold text-on-surface">Abilities / Permissions</th>
                            <th class="p-6 text-sm font-semibold text-on-surface text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @foreach($roles as $role)
                            <tr class="hover:bg-surface-container-low/30 transition-colors duration-200">
                                <td class="p-6">
                                    <span class="font-bold text-on-surface text-base block">{{ $role->name }}</span>
                                </td>
                                <td class="p-6">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-secondary-container text-on-secondary-container">
                                        {{ $role->users_count }} Users
                                    </span>
                                </td>
                                <td class="p-6">
                                    <div class="flex flex-wrap gap-1.5 max-w-xl">
                                        @foreach($role->abilities as $ability)
                                            <span class="text-xs bg-surface-container px-2.5 py-1 rounded-md text-on-surface-variant/90 border border-outline-variant/10 font-mono">
                                                {{ $ability }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="p-6 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('roles.edit', $role->id) }}" 
                                           class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-base">edit</span> Edit
                                        </a>

                                        @if($role->name !== 'Super Admin') {{-- حماية السوبر أدمن من الحذف العشوائي --}}
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-800 transition-colors flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-base">delete</span> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</x-layouts.app>