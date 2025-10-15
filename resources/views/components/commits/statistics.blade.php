<div class="grid grid-cols-3 gap-6 mb-6">
    <div class="text-center">
        <div class="text-2xl font-bold text-gray-900">{{ $statistics['total_commits'] }}</div>
        <div class="text-sm text-gray-500">Total Commits</div>
    </div>
    <div class="text-center">
        <div class="text-2xl font-bold text-gray-900">{{ $statistics['total_repositories'] }}
        </div>
        <div class="text-sm text-gray-500">Repositories</div>
    </div>
    <div class="text-center">
        <div class="text-2xl font-bold text-gray-900">
            {{ count($statistics['commits_by_hour']) }}
        </div>
        <div class="text-sm text-gray-500">Active Hours</div>
    </div>
</div>
