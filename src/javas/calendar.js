const daysContainer = document.getElementById('calendar-grid');
const monthYearElement = document.getElementById('calendar-month-year');
const prevButton = document.getElementById('calendar-prev');
const nextButton = document.getElementById('calendar-next');

const currentDate = new Date();
let currentMonth = currentDate.getMonth();
const currentYear = currentDate.getFullYear();

const months = [
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];

function updateCalendar() {
    daysContainer.innerHTML = '';

    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);

    monthYearElement.textContent = months[currentMonth] + ' ' + currentYear;

    for (let i = 0; i < firstDay.getDay(); i++) {
        const day = document.createElement('div');
        day.classList.add('calendar-day');
        daysContainer.appendChild(day);
    }

    for (let i = 1; i <= lastDay.getDate(); i++) {
        const day = document.createElement('div');
        day.classList.add('calendar-day');
        day.textContent = i;

        if (currentDate.getDate() === i && currentDate.getMonth() === currentMonth) {
            day.classList.add('current-day');
        }

        daysContainer.appendChild(day);
    }
}

updateCalendar();

prevButton.addEventListener('click', () => {
    if (currentMonth > 0) {
        currentMonth--;
    } else {
        currentYear--;
        currentMonth = 11;
    }
    updateCalendar();
});

nextButton.addEventListener('click', () => {
    if (currentMonth < 11) {
        currentMonth++;
    } else {
        currentYear++;
        currentMonth = 0;
    }
    updateCalendar();
});
// Código para el gráfico de asistencia
const canvas = document.getElementById('asistencia-chart');
const data = {
    labels: ['Asistencia', 'Faltas'],
    datasets: [{
        data: [85, 15],
        backgroundColor: ['#36A2EB', '#FFCE56'],
    }]
};
const config = {
    type: 'doughnut',
    data: data,
    options: {
        plugins: {
            legend: {
                display: false,
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.formattedValue || '';
                        return `${label}: ${value}%`;
                    },
                },
            },
        },
    },
};
const asistenciaChart = new Chart(canvas, config);