<x-layouts.app title="Reports - GCMS">
    <div class="mb-4">
        <h1 class="h3 mb-1">Reports</h1>
        <p class="text-muted mb-0">Open a report, apply filters, and print the table.</p>
    </div>

    <div class="row g-3">
        @foreach ([
            ['title' => 'Member Report', 'route' => route('admin.reports.members')],
            ['title' => 'Payment Report', 'route' => route('admin.reports.payments')],
            ['title' => 'Due Payment Report', 'route' => route('admin.reports.due-payments')],
            ['title' => 'Event Report', 'route' => route('admin.reports.events')],
            ['title' => 'Date-wise Collection Report', 'route' => route('admin.reports.date-wise-collection')],
            ['title' => 'Member-wise Payment Report', 'route' => route('admin.reports.member-wise-payments')],
        ] as $report)
            <div class="col-md-6 col-xl-4">
                <a href="{{ $report['route'] }}" class="card border-0 shadow-sm h-100 text-decoration-none text-body">
                    <div class="card-body">
                        <h2 class="h5 mb-2">{{ $report['title'] }}</h2>
                        <p class="text-muted mb-0">View filters and printable table.</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</x-layouts.app>
