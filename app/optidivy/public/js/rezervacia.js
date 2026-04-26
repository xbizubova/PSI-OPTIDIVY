(function () {
    const SLOTS = ['9:00', '10:00', '11:00', '15:00', '16:00'];
    const DAY_LABELS = ['Po', 'Ut', 'Str', 'Štv', 'Pia'];

    const form        = document.getElementById('rezervacia-form');
    const inputDate   = document.getElementById('input-date');
    const inputSlot   = document.getElementById('input-slot');
    const btnConfirm  = document.getElementById('btn-confirm');
    const weekLabel   = document.getElementById('week-label');
    const prevBtn     = document.getElementById('prev-week');
    const nextBtn     = document.getElementById('next-week');

    let weekOffset = 0;
    let selectedBtn = null;

    function mondayOf(offsetWeeks) {
        const d = new Date();
        d.setHours(0, 0, 0, 0);
        const day = d.getDay();
        const diffToMon = day === 0 ? 1 : 1 - day;
        d.setDate(d.getDate() + diffToMon + offsetWeeks * 7);
        return d;
    }

    function fmtDate(d) {
        const y = d.getFullYear();
        const m = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        return `${y}-${m}-${day}`;
    }

    function fmtShort(d) {
        return `${String(d.getDate()).padStart(2, '0')}.${String(d.getMonth() + 1).padStart(2, '0')}`;
    }

    function clearSelection() {
        if (selectedBtn) selectedBtn.classList.remove('selected');
        selectedBtn = null;
        inputDate.value = '';
        inputSlot.value = '';
        btnConfirm.disabled = true;
    }

    function render() {
        const monday = mondayOf(weekOffset);
        const friday = new Date(monday);
        friday.setDate(monday.getDate() + 4);
        weekLabel.textContent = `${fmtShort(monday)} – ${fmtShort(friday)}`;

        clearSelection();

        for (let i = 0; i < 5; i++) {
            const col = document.getElementById(`col-${i}`);
            col.querySelectorAll('.slot, .day-date').forEach(el => el.remove());

            const date = new Date(monday);
            date.setDate(monday.getDate() + i);
            const dateStr = fmtDate(date);

            const dateEl = document.createElement('div');
            dateEl.className = 'day-date';
            dateEl.textContent = fmtShort(date);
            col.appendChild(dateEl);

            const available = AVAILABLE_SLOTS[dateStr] || [];
            const isPast = date < new Date(new Date().setHours(0, 0, 0, 0));

            SLOTS.forEach((label, slotIdx) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'slot';
                btn.textContent = label;
                const free = available.includes(slotIdx) && !isPast;
                if (!free) {
                    btn.disabled = true;
                    btn.classList.add('unavailable');
                } else {
                    btn.addEventListener('click', () => {
                        if (selectedBtn) selectedBtn.classList.remove('selected');
                        selectedBtn = btn;
                        btn.classList.add('selected');
                        inputDate.value = dateStr;
                        inputSlot.value = slotIdx;
                        btnConfirm.disabled = false;
                    });
                }
                col.appendChild(btn);
            });
        }
    }

    prevBtn.addEventListener('click', () => { if (weekOffset > 0) { weekOffset--; render(); } });
    nextBtn.addEventListener('click', () => { weekOffset++; render(); });

    render();
})();
