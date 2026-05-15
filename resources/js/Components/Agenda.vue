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
        <p class="section-tag" data-aos="fade-up">Kalender Kegiatan</p>
        <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Agenda <em>Desa</em></h2>
        <div class="agenda-grid">
            <div v-for="(item, index) in agendas" :key="item.id" 
                 class="agenda-item" 
                 data-aos="fade-up" 
                 :data-aos-delay="(index % 2) * 100">
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
