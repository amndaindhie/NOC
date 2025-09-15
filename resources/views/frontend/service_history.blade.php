@if(isset($tickets) && $tickets->count() > 0)
    <div class="service-history-list container mt-4">
        <ul class="list-group">
            @foreach($tickets as $ticket)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $ticket['nomor_tiket'] }}</span>
                    <button class="btn btn-sm btn-outline-secondary copy-btn" data-copy-target="ticket-{{ $loop->index }}">
                        SALIN
                    </button>
                    <input type="hidden" id="ticket-{{ $loop->index }}" value="{{ $ticket['nomor_tiket'] }}">
                </li>
            @endforeach
        </ul>
    </div>
@else
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="bx bx-history display-1 text-muted"></i>
        </div>
        <h4 class="text-muted mb-3">Belum ada riwayat pelayanan</h4>
        <p class="text-muted mb-4">Anda belum mengajukan permintaan layanan apapun.</p>
        <p class="text-muted small">Debug: {{ isset($tickets) ? 'Tickets variable exists' : 'Tickets variable not set' }}</p>
        @if(isset($tickets))
            <p class="text-muted small">Debug: Tickets count = {{ $tickets->count() }}</p>
        @endif
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Ajukan Permintaan Baru
        </a>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const copyButtons = document.querySelectorAll('.copy-btn');
    copyButtons.forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.getAttribute('data-copy-target');
            const input = document.getElementById(targetId);
            if (input) {
                const textToCopy = input.value.trim();
                navigator.clipboard.writeText(textToCopy).then(() => {
                    this.textContent = 'Tersalin!';
                    setTimeout(() => {
                        this.textContent = 'SALIN';
                    }, 2000);
                }).catch(() => {
                    alert('Gagal menyalin teks.');
                });
            }
        });
    });
});
</script>
