<x-student-layout title="Payment Receipts">
    <link rel="icon" type="image/png/jpg" href="{{ Storage::url($company->favicon ?? 'default.png') }}" alt="FinHedge Logo" class="h-auto w-auto">
<div class="max-w-5xl mx-auto py-8 px-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">My Payment Receipts</h1>
    <p class="text-gray-600 mb-8">Click on any receipt to view and print</p>

    @if($receipts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($receipts as $receipt)
                @php
                    $course = $receipt->course;
                    $discount = $course->price - $receipt->amount_paid;
                @endphp

                <a href="{{ route('student.receipt.show', $receipt->id) }}" target="_blank"
                   class="block bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-200 overflow-hidden transform hover:scale-[1.02]">

                    <!-- Header -->
                    <div class="bg-gradient-to-r from-primary to-indigo-700 text-white p-5">
                        <h3 class="font-bold text-lg line-clamp-2">{{ $course->title }}</h3>
                        <p class="text-sm opacity-90 mt-1">Enrolled: {{ $receipt->enrolled_at->format('d M Y') }}</p>
                    </div>

                    <!-- Body -->
                    <div class="p-5 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Amount Paid</span>
                            <span class="font-bold text-green-600 text-lg">
                                NPR {{ number_format($receipt->amount_paid) }}
                            </span>
                        </div>

                        @if($discount > 0)
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Discount Applied</span>
                                <span class="text-red-600 font-medium">- NPR {{ number_format($discount) }}</span>
                            </div>
                        @endif

                        <div class="text-xs text-gray-500 border-t pt-3">
                            <div class="flex justify-between">
                                <span>Ref:</span>
                                <span class="font-mono text-primary">{{ $receipt->reference_code }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Hint -->
                    <div class="bg-gray-50 px-5 py-4 text-center text-sm text-gray-600 border-t">
                        Click to view & print receipt
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-2xl shadow-md border border-gray-200">
            <svg class="mx-auto h-20 w-20 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Receipts Found</h3>
            <p class="text-gray-600 mb-6">You haven't enrolled in any course yet.</p>
            <a href="{{ route('student.enroll') }}"
               class="inline-flex items-center px-8 py-4 bg-primary text-white font-bold rounded-lg hover:bg-indigo-700 transition">
                Enroll Now
            </a>
        </div>
    @endif
</div>

</x-student-layout>
