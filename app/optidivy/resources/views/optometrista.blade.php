@extends('layouts.app')
@section('title', 'Optometrista')

@section('content')
    <div class="optom-layout">

        {{-- ── Sidebar ── --}}
        <aside class="patient-sidebar">
            <p class="sidebar-title">DNEŠNÉ REZERVÁCIE</p>
            <ul class="patient-list">
                @forelse($appointments as $index => $appointment)
                    <li class="patient-item {{ $index === 0 ? 'active' : '' }}"
                        data-index="{{ $index }}"
                        data-id="{{ $appointment->id }}"
                        data-customer="{{ $appointment->customer_id }}"
                        data-name="{{ $appointment->customer->first_name }} {{ $appointment->customer->last_name }}"
                        data-time="{{ \App\Http\Controllers\OptometristaController::SLOTS[$appointment->slot] }}">
                        <div class="patient-info">
            <span class="patient-name">
              {{ $appointment->customer->first_name }}
                {{ $appointment->customer->last_name }}
            </span>
                            <span class="patient-time">
              {{ \App\Http\Controllers\OptometristaController::SLOTS[$appointment->slot] }}
            </span>
                        </div>
                        <div class="patient-radio"></div>
                    </li>
                @empty
                    <li style="font-size:12px; color:var(--grey-dark);">
                        Dnes žiadne rezervácie.
                    </li>
                @endforelse
            </ul>
        </aside>

        {{-- ── Exam panel ── --}}
        <main class="exam-panel">

            @if($appointments->isNotEmpty())
                @php $first = $appointments->first(); @endphp

                <div class="exam-header">
                    <h1 class="exam-patient-name" id="exam-name">
                        {{ $first->customer->first_name }} {{ $first->customer->last_name }}
                    </h1>
                    <span class="exam-time" id="exam-time">
          {{ \App\Http\Controllers\OptometristaController::SLOTS[$first->slot] }}
        </span>
                </div>

                @if(session('success'))
                    <p style="color:green; font-size:12px; margin-bottom:16px;">
                        {{ session('success') }}
                    </p>
                @endif

                <form method="POST"
                      action="{{ route('optometrista.prescription.store') }}"
                      id="exam-form">
                    @csrf
                    <input type="hidden" name="appointment_id" id="input-appointment"
                           value="{{ $first->id }}"/>
                    <input type="hidden" name="customer_id" id="input-customer"
                           value="{{ $first->customer_id }}"/>

                    <div class="eye-grid">

                        {{-- OD – pravé oko --}}
                        <div class="eye-card">
                            <span class="eye-label">OD</span>
                            <div class="eye-field">
                                <label>Zraková Ostrosť</label>
                                <input type="text" name="od_ostrost" id="od-ostrost"/>
                            </div>
                            <div class="eye-field">
                                <label>SPH</label>
                                <input type="number" step="0.25" name="sphere_right" id="od-sph"/>
                            </div>
                            <div class="eye-field">
                                <label>CYL</label>
                                <input type="number" step="0.25" name="cylinder" id="od-cyl"/>
                            </div>
                            <div class="eye-field">
                                <label>AX</label>
                                <input type="number" name="axis" id="od-ax"/>
                            </div>
                            <div class="eye-field">
                                <label>Pupilárna Vzdialenosť</label>
                                <input type="number" step="0.5" name="pupil_distance" id="od-pv"/>
                            </div>
                        </div>

                        {{-- OS – ľavé oko --}}
                        <div class="eye-card">
                            <span class="eye-label">OS</span>
                            <div class="eye-field">
                                <label>Zraková Ostrosť</label>
                                <input type="text" name="os_ostrost" id="os-ostrost"/>
                            </div>
                            <div class="eye-field">
                                <label>SPH</label>
                                <input type="number" step="0.25" name="sphere_left" id="os-sph"/>
                            </div>
                            <div class="eye-field">
                                <label>CYL</label>
                                <input type="number" step="0.25" name="os_cylinder" id="os-cyl"/>
                            </div>
                            <div class="eye-field">
                                <label>AX</label>
                                <input type="number" name="os_axis" id="os-ax"/>
                            </div>
                            <div class="eye-field">
                                <label>Pupilárna Vzdialenosť</label>
                                <input type="number" step="0.5" name="os_pupil_distance" id="os-pv"/>
                            </div>
                        </div>

                    </div>

                    <div class="exam-actions">
                        <button type="button" class="btn-sklá">
                            Odporúčané sklá
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </button>
                        <button type="submit" class="btn-potvrdit">Potvrdiť</button>
                    </div>

                </form>

            @else
                <p style="font-size:14px; color:var(--grey-dark); padding:40px;">
                    Dnes nemáte žiadne rezervácie.
                </p>
            @endif

        </main>
    </div>
@endsection

@push('scripts')
    <script>
        const patients = @json($appointments->map(fn($a) => [
    'id'         => $a->id,
    'customerId' => $a->customer_id,
    'name'       => $a->customer->first_name . ' ' . $a->customer->last_name,
    'time'       => \App\Http\Controllers\OptometristaController::SLOTS[$a->slot],
  ])->values());

        document.querySelectorAll('.patient-item').forEach((el, i) => {
            el.addEventListener('click', () => {
                document.querySelectorAll('.patient-item')
                    .forEach(e => e.classList.remove('active'));
                el.classList.add('active');

                const p = patients[i];
                document.getElementById('exam-name').textContent   = p.name;
                document.getElementById('exam-time').textContent   = p.time;
                document.getElementById('input-appointment').value = p.id;
                document.getElementById('input-customer').value    = p.customerId;

                document.querySelectorAll('.eye-field input')
                    .forEach(inp => inp.value = '');
            });
        });

        const header = document.getElementById('site-header');
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 10);
        });
    </script>
@endpush
