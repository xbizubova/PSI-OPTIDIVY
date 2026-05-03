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
                    <p class="exam-success">{{ session('success') }}</p>
                @endif

                @if($errors->any())
                    <div class="exam-errors">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('optometrista.prescription.store') }}"
                      id="exam-form">
                    @csrf
                    <input type="hidden" name="appointment_id" id="input-appointment" value="{{ $first->id }}"/>
                    <input type="hidden" name="customer_id"    id="input-customer"    value="{{ $first->customer_id }}"/>

                    {{-- ── 3 stĺpce: OD | OS | Sklá ── --}}
                    <div class="exam-grid">

                        {{-- OD – pravé oko --}}
                        <div class="eye-card">
                            <span class="eye-label">OD – Pravé oko</span>
                            <div class="eye-field">
                                <label>Zraková Ostrosť <span class="range-hint">(0.32 – 0.8)</span></label>
                                <select name="od_ostrost" id="od-ostrost" class="eye-select">
                                    <option value="">– vybrať –</option>
                                    @foreach(['0.8-1.0', '0.4-0.6', '0.1-0.32'] as $v)
                                        <option value="{{ $v }}" {{ old('od_ostrost') == $v ? 'selected' : '' }}>{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="eye-field">
                                <label>SPH <span class="range-hint">(-20 až +20)</span></label>
                                <input type="number" step="0.25" min="-20" max="20"
                                       name="sphere_right" id="od-sph"
                                       value="{{ old('sphere_right') }}" placeholder="napr. -1.75"/>
                            </div>
                            <div class="eye-field">
                                <label>CYL <span class="range-hint">(-6.0 až -0.25)</span></label>
                                <input type="number" step="0.25" min="-6.0" max="-0.25"
                                       name="cylinder" id="od-cyl"
                                       value="{{ old('cylinder') }}" placeholder="napr. -0.75"/>
                            </div>
                            <div class="eye-field">
                                <label>AX <span class="range-hint">(0° – 180°)</span></label>
                                <input type="number" step="1" min="0" max="180"
                                       name="axis" id="od-ax"
                                       value="{{ old('axis') }}" placeholder="napr. 90"/>
                            </div>
                            <div class="eye-field">
                                <label>Pupilárna Vzdialenosť <span class="range-hint">(50 – 75 mm)</span></label>
                                <input type="number" step="0.5" min="50" max="75"
                                       name="pupil_distance" id="od-pv"
                                       value="{{ old('pupil_distance') }}" placeholder="napr. 62"/>
                            </div>
                        </div>

                        {{-- OS – ľavé oko --}}
                        <div class="eye-card">
                            <span class="eye-label">OS – Ľavé oko</span>
                            <div class="eye-field">
                                <label>Zraková Ostrosť <span class="range-hint">(0.32 – 0.8)</span></label>
                                <select name="os_ostrost" id="os-ostrost" class="eye-select">
                                    <option value="">– vybrať –</option>
                                    @foreach(['0.8-1.0', '0.4-0.6', '0.1-0.32'] as $v)
                                        <option value="{{ $v }}" {{ old('os_ostrost') == $v ? 'selected' : '' }}>{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="eye-field">
                                <label>SPH <span class="range-hint">(-20 až +20)</span></label>
                                <input type="number" step="0.25" min="-20" max="20"
                                       name="sphere_left" id="os-sph"
                                       value="{{ old('sphere_left') }}" placeholder="napr. -1.75"/>
                            </div>
                            <div class="eye-field">
                                <label>CYL <span class="range-hint">(-6.0 až -0.25)</span></label>
                                <input type="number" step="0.25" min="-6.0" max="-0.25"
                                       name="os_cylinder" id="os-cyl"
                                       value="{{ old('os_cylinder') }}" placeholder="napr. -0.75"/>
                            </div>
                            <div class="eye-field">
                                <label>AX <span class="range-hint">(0° – 180°)</span></label>
                                <input type="number" step="1" min="0" max="180"
                                       name="os_axis" id="os-ax"
                                       value="{{ old('os_axis') }}" placeholder="napr. 90"/>
                            </div>
                            <div class="eye-field">
                                <label>Pupilárna Vzdialenosť <span class="range-hint">(50 – 75 mm)</span></label>
                                <input type="number" step="0.5" min="50" max="75"
                                       name="os_pupil_distance" id="os-pv"
                                       value="{{ old('os_pupil_distance') }}" placeholder="napr. 62"/>
                            </div>
                        </div>

                        {{-- Sklá – 3. stĺpec --}}
                        <div class="eye-card lens-card">
                            <span class="eye-label">Odporúčané sklá</span>
                            <div class="lens-list">
                                @foreach($lensTypes as $key => $label)
                                    <label class="lens-option {{ old('lens_type') === $key ? 'selected' : '' }}">
                                        <input type="radio" name="lens_type" value="{{ $key }}"
                                            {{ old('lens_type') === $key ? 'checked' : '' }}/>
                                        <span class="lens-dot"></span>
                                        <span>{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                    </div>{{-- end .exam-grid --}}

                    <div class="exam-actions">
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
        const patients = @json($patients);

        document.querySelectorAll('.patient-item').forEach((el, i) => {
            el.addEventListener('click', () => {
                document.querySelectorAll('.patient-item')
                    .forEach(e => e.classList.remove('active'));
                el.classList.add('active');

                const p = patients[i];
                document.getElementById('exam-name').textContent    = p.name;
                document.getElementById('exam-time').textContent    = p.time;
                document.getElementById('input-appointment').value  = p.id;
                document.getElementById('input-customer').value     = p.customerId;

                document.querySelectorAll('.eye-field input, .eye-field select')
                    .forEach(inp => inp.tagName === 'SELECT' ? inp.selectedIndex = 0 : inp.value = '');
                document.querySelectorAll('.lens-option').forEach(l => l.classList.remove('selected'));
                document.querySelectorAll('input[name="lens_type"]').forEach(r => r.checked = false);
            });
        });

        document.querySelectorAll('.lens-option').forEach(label => {
            label.addEventListener('click', () => {
                document.querySelectorAll('.lens-option').forEach(l => l.classList.remove('selected'));
                label.classList.add('selected');
            });
        });

        const header = document.getElementById('site-header');
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 10);
        });
    </script>
@endpush
