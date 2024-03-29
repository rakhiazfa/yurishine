<script setup>
import { Head, usePage, router, Link } from "@inertiajs/vue3";
import Layout from "@/layouts/Default.vue";
import Pagination from "@/components/Pagination.vue";
import { formatDate } from "@/helpers/date";

let urlPrevious = usePage().props.urlPrevious;

defineProps({ patient: Object, medicalRecords: Array });
defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Detail Pasien" />
    <div>
        <el-card class="mb-5">
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Detail Pasien</h1>
                <el-button size="small" @click="router.visit(urlPrevious)">
                    Kembali
                </el-button>
            </div>

            <el-descriptions class="margin-top" :column="1" border>
                <el-descriptions-item label-class-name="w-[250px]">
                    <template #label> Nomor Induk </template>
                    {{ patient?.registrasion_number ?? "-" }}
                </el-descriptions-item>
                <el-descriptions-item label-class-name="w-[250px]">
                    <template #label> Nama </template>
                    <p class="font-bold">{{ patient?.name ?? "-" }}</p>
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Umur </template>
                    {{ patient?.age ? patient?.age + " Tahun" : "-" }}
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Jenis Kelamin </template>
                    <el-tag type="info">{{ patient?.gender ?? "-" }}</el-tag>
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Jenis Kulit </template>
                    <el-tag type="info">{{ patient?.skin_type ?? "-" }}</el-tag>
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Alamat </template>
                    {{ patient?.address ?? "-" }}
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Nomor Telepon </template>
                    {{ patient?.phone ?? "-" }}
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Merokok </template>
                    <el-tag :type="patient?.is_smoked ? 'danger' : ''">{{
                        patient?.is_smoked ? "Ya" : "Tidak"
                    }}</el-tag>
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Menggunakan KB </template>
                    {{ patient?.using_kb ?? "-" }}
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Sedang Menggunakan Skincare? </template>
                    <el-tag :type="patient?.using_skincare ? '' : 'danger'">{{
                        patient?.using_skincare ? "Ya" : "Tidak"
                    }}</el-tag>
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label>
                        Pernah Menggunakan Cream Racik?
                    </template>
                    <el-tag
                        :type="patient?.already_use_mixed_cream ? '' : 'danger'"
                        >{{
                            patient?.already_use_mixed_cream ? "Ya" : "Tidak"
                        }}</el-tag
                    >
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Membership? </template>
                    <el-tag
                        :type="patient?.membership_count > 0 ? '' : 'danger'"
                        >{{
                            patient?.membership_count > 0 ? "Ya" : "Tidak"
                        }}</el-tag
                    >
                </el-descriptions-item>
            </el-descriptions>
        </el-card>

        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Riwayat Perawatan</h1>
            </div>

            <el-table :data="medicalRecords.data" class="w-auto" border stripe>
                <el-table-column type="expand">
                    <template #default="props">
                        <div class="p-5">
                            <el-descriptions
                                direction="vertical"
                                :column="1"
                                border
                                class="mb-5"
                            >
                                <el-descriptions-item label="Keterangan">
                                    <div
                                        class="ck-editor-result"
                                        v-html="props.row?.description"
                                    ></div>
                                </el-descriptions-item>
                            </el-descriptions>

                            <div class="flex items-start gap-5">
                                <el-descriptions
                                    direction="vertical"
                                    :column="1"
                                    border
                                    class="mb-5"
                                >
                                    <el-descriptions-item
                                        label="Resep / Skincare"
                                    >
                                        <el-table
                                            :data="props.row.skincares"
                                            class="w-max"
                                            border
                                            stripe
                                        >
                                            <el-table-column
                                                prop="name"
                                                label="Nama Skincare"
                                                width="250px"
                                            />
                                        </el-table>
                                    </el-descriptions-item>
                                </el-descriptions>
                                <el-descriptions
                                    direction="vertical"
                                    :column="1"
                                    border
                                    class="mb-5"
                                >
                                    <el-descriptions-item label="Treatment">
                                        <el-table
                                            :data="props.row.treatments"
                                            class="w-max"
                                            border
                                            stripe
                                        >
                                            <el-table-column
                                                prop="name"
                                                label="Nama"
                                                width="250px"
                                            />
                                        </el-table>
                                    </el-descriptions-item>
                                </el-descriptions>
                            </div>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column type="index" label="No" width="50px" />
                <el-table-column
                    label="Dokter Yang Menangani"
                    min-width="150px"
                >
                    <template #default="scope">
                        <Link
                            :href="`/doctors/${scope.row.doctor?.id}`"
                            class="text-blue-500 hover:underline"
                        >
                            {{ scope.row.doctor?.name ?? "-" }}
                        </Link>
                    </template>
                </el-table-column>
                <el-table-column label="Tanggal Pemeriksaan" min-width="150px">
                    <template #default="scope">
                        <p>{{ formatDate(scope.row.inspection_date) }}</p>
                    </template>
                </el-table-column>
                <el-table-column
                    label="Menggunakan Membership?"
                    min-width="150px"
                >
                    <template #default="scope">
                        <el-tag>{{
                            scope.row.use_membership ? "Ya" : "Tidak"
                        }}</el-tag>
                    </template>
                </el-table-column>
            </el-table>
            <div class="mt-5">
                <Pagination :links="medicalRecords.links" />
            </div>
        </el-card>
    </div>
</template>
