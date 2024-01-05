<script setup>
import { Head } from "@inertiajs/vue3";
import Layout from "@/layouts/Default.vue";
import chart from "@images/cards/chart-success.png";

defineProps({ entityCounts: Object });
defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Dashboard" />
    <div class="grid md:grid-cols-5 gap-5">
        <CardStatisticsVertical
            v-bind="{
                title: 'Total Dokter',
                image: chart,
                stats: entityCounts.totalDoctor,
            }"
        />

        <CardStatisticsVertical
            v-bind="{
                title: 'Total Pasien',
                image: chart,
                stats: entityCounts.totalPatient,
            }"
        />

        <CardStatisticsVertical
            v-bind="{
                title: 'Total Obat',
                image: chart,
                stats: entityCounts.totalMedicine,
            }"
        />

        <CardStatisticsVertical
            v-bind="{
                title: 'Total Poliklinik',
                image: chart,
                stats: entityCounts.totalPolyclinic,
            }"
        />

        <CardStatisticsVertical
            v-bind="{
                title: 'Total Rekam Medis',
                image: chart,
                stats: entityCounts.totalMedicalRecord,
            }"
        />
    </div>
</template>
