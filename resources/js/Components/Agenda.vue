<script setup>
defineProps({
    agendas: Array
});

const formatDay = (dateStr) => {
    return new Date(dateStr).getDate();
};

const formatMonth = (dateStr) => {
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    return months[new Date(dateStr).getMonth()];
};

const formatTime = (timeStr) => {
    return timeStr ? timeStr.substring(0, 5) : '';
};
</script>

<template>
    <section id="agenda">
        <p class="section-tag reveal">Kalender Kegiatan</p>
        <h2 class="section-title reveal reveal-delay-1">Agenda <em>Desa</em></h2>
        <div class="agenda-grid">
            <div v-for="(item, index) in agendas" :key="item.id" 
                 class="agenda-item reveal" 
                 :class="'reveal-delay-' + (index % 2)">
                <div class="agenda-date-box">
                    <div class="agenda-day">{{ formatDay(item.date) }}</div>
                    <div class="agenda-month">{{ formatMonth(item.date) }}</div>
                </div>
                <div>
                    <p class="agenda-event">{{ item.title }}</p>
                    <p class="agenda-meta">🕘 {{ formatTime(item.time) }} WIB · {{ item.location }}</p>
                </div>
            </div>
        </div>
    </section>
</template>
