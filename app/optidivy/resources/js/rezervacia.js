const TIMES    = ['9:00', '10:00', '11:00', '15:00', '16:00'];
const DAYS     = ['Po', 'Ut', 'Str', 'Štv', 'Pia'];
const DAY_NAMES = ['Pondelok', 'Utorok', 'Streda', 'Štvrtok', 'Piatok'];

// AVAILABLE_SLOTS príde z Blade ako JSON:
// { "2026-04-28": [0,1,2], "2026-04-29": [0,2,4], ... }
// číslo = index v poli TIMES

let currentMonday = getThisMonday();
let selected = null;

function getThisMonday() {
    const today = new Date();
    const day   = today.getDay();
    const diff  = (day === 0) ? -6 : 1 - day;
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

function toISODate(date) {
    return date.toISOString().split('T')[0]; // "2026-04-28"
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
        const col  = document.getElementById(`col-${dayIdx}`);
        col.querySelectorAll('.slot').forEach(el => el.remove());

        const date    = addDays(currentMonday, dayIdx);
        const dateStr = toISODate(date);
        const freeSlots = AVAILABLE_SLOTS[dateStr] || [];

        TIMES.forEach((time, timeIdx) => {
            const slot = document.createElement('div');
            slot.className = 'slot';
            slot.textContent = time;

            const isAvailable = freeSlots.includes(timeIdx);

            if (!isAvailable) {
                slot.classList.add('unavailable');
            } else {
                if (
                    selected &&
                    selected.dateStr === dateStr &&
                    selected.timeIdx === timeIdx
                ) {
                    slot.classList.add('selected');
                }
                slot.addEventListener('click', () =>
                    selectSlot(slot, dayIdx, timeIdx, time, date, dateStr)
                );
            }

            col.appendChild(slot);
        });
    });
}

function selectSlot(slotEl, dayIdx, timeIdx, time, date, dateStr) {
    document.querySelectorAll('.slot.selected')
        .forEach(el => el.classList.remove('selected'));

    slotEl.classList.add('selected');

    selected = { dayIdx, timeIdx, time, date, dateStr };

    // Nastav hidden inputy pre formulár
    document.getElementById('input-date').value = dateStr;
    document.getElementById('input-slot').value = timeIdx;

    document.getElementById('selected-info').textContent =
        `Vybraný termín: ${DAY_NAMES[dayIdx]} ${fmt(date)} o ${time}`;

    document.getElementById('btn-confirm').disabled = false;
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

renderWeekLabel();
renderSlots();
