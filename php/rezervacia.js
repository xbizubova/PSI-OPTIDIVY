const TIMES = ['9:00', '10:00', '11:00', '15:00', '16:00'];
const DAYS  = ['Po', 'Ut', 'Str', 'Štv', 'Pia'];

// Randomly mark some slots unavailable for demo purposes
const UNAVAILABLE = new Set([
    '1-9:00', '1-11:00', '3-10:00', '4-16:00'
]);

let currentMonday = getThisMonday();
let selected = null; // { dayIndex, time, date }

function getThisMonday() {
    const today = new Date();
    const day = today.getDay(); // 0=Sun
    const diff = (day === 0) ? -6 : 1 - day;
    const monday = new Date(today);
    monday.setDate(today.getDate() + diff);
    monday.setHours(0, 0, 0, 0);
    return monday;
}

function addDays(date, n) {
    const d = new Date(date);
    d.setDate(d.getDate() + n);
    return d;
}

function fmt(date) {
    return `${date.getDate()}.${date.getMonth() + 1}.`;
}

function renderWeekLabel() {
    const friday = addDays(currentMonday, 4);
    document.getElementById('week-label').textContent =
        `${fmt(currentMonday)} – ${fmt(friday)}`;
}

function renderSlots() {
    DAYS.forEach((_, dayIdx) => {
        const col = document.getElementById(`col-${dayIdx}`);

        // Remove old slots, keep header
        col.querySelectorAll('.slot').forEach(el => el.remove());

        const date = addDays(currentMonday, dayIdx);

        TIMES.forEach(time => {
            const key = `${dayIdx}-${time}`;
            const slot = document.createElement('div');
            slot.className = 'slot';
            slot.textContent = time;

            if (UNAVAILABLE.has(key)) {
                slot.classList.add('unavailable');
            } else {
                // Restore selected state across re-renders
                if (
                    selected &&
                    selected.dayIndex === dayIdx &&
                    selected.time === time &&
                    selected.weekStart === currentMonday.toISOString()
                ) {
                    slot.classList.add('selected');
                }

                slot.addEventListener('click', () => selectSlot(slot, dayIdx, time, date));
            }

            col.appendChild(slot);
        });
    });
}

function selectSlot(slotEl, dayIdx, time, date) {
    // Deselect all
    document.querySelectorAll('.slot.selected').forEach(el => el.classList.remove('selected'));

    slotEl.classList.add('selected');

    selected = {
        dayIndex: dayIdx,
        time,
        date,
        weekStart: currentMonday.toISOString()
    };

    const dayNames = ['Pondelok', 'Utorok', 'Streda', 'Štvrtok', 'Piatok'];
    document.getElementById('selected-info').textContent =
        `Vybraný termín: ${dayNames[dayIdx]} ${fmt(date)} o ${time}`;

    const btn = document.getElementById('btn-confirm');
    btn.disabled = false;
}

document.getElementById('prev-week').addEventListener('click', () => {
    currentMonday = addDays(currentMonday, -7);
    renderWeekLabel();
    renderSlots();
});

document.getElementById('next-week').addEventListener('click', () => {
    currentMonday = addDays(currentMonday, 7);
    renderWeekLabel();
    renderSlots();
});

document.getElementById('btn-confirm').addEventListener('click', () => {
    if (!selected) return;
    const dayNames = ['Pondelok', 'Utorok', 'Streda', 'Štvrtok', 'Piatok'];
    alert(`✓ Rezervácia potvrdená!\n${dayNames[selected.dayIndex]} ${fmt(selected.date)} o ${selected.time}`);
});

// Init
renderWeekLabel();
renderSlots();