<script setup>
import { Head, Link, router, useForm } from "@inertiajs/vue3";
import { ElMessage, ElMessageBox } from "element-plus";
import Layout from "@/layouts/Default.vue";
import { reactive, ref, watch } from "vue";
import logo from "@images/logo.png";
import currency from "../../helpers/currency";

const createMembershipDrawer = ref(false);
const addBalanceDrawer = ref(false);
const useBalanceDrawer = ref(false);

watch(
    () => createMembershipDrawer.value,
    (value) => {
        if (value === false) {
            form.patient_id = null;
            form.balance = null;
        }
    }
);

watch(
    () => addBalanceDrawer.value,
    (value) => {
        if (value === false) {
            formAddBalance.membership_id = null;
            formAddBalance.payload = null;
        }
    }
);

watch(
    () => useBalanceDrawer.value,
    (value) => {
        if (value === false) {
            formUseBalance.membership_id = null;
            formUseBalance.payload = null;
        }
    }
);

const form = useForm({
    patient_id: null,
    balance: null,
});
const formAddBalance = useForm({
    membership_id: null,
    payload: null,
});
const formUseBalance = useForm({
    membership_id: null,
    payload: null,
});

const formFilter = reactive({
    column: "",
    keyword: "",
});

const handleCreateMembership = () => {
    form.post("/memberships", {
        onSuccess: () => {
            ElMessage({
                type: "success",
                message: "Berhasil menambahkan membership.",
            });

            form.patient_id = null;
            form.balance = null;

            createMembershipDrawer.value = false;
        },
        preserveScroll: (page) => Object.keys(page.props.errors).length,
    });
};

const handleAddBalance = () => {
    formAddBalance.patch(
        `/memberships/${formAddBalance.membership_id}/add-balance`,
        {
            onSuccess: () => {
                ElMessage({
                    type: "success",
                    message: "Berhasil menambahkan saldo.",
                });

                formAddBalance.membership_id = null;
                formAddBalance.payload = null;

                addBalanceDrawer.value = false;
            },
            preserveScroll: (page) => Object.keys(page.props.errors).length,
        }
    );
};

const handleUseBalance = () => {
    formUseBalance.patch(
        `/memberships/${formUseBalance.membership_id}/use-balance`,
        {
            onSuccess: () => {
                ElMessage({
                    type: "success",
                    message: "Berhasil menggunakan saldo.",
                });

                formUseBalance.membership_id = null;
                formUseBalance.payload = null;

                useBalanceDrawer.value = false;
            },
            preserveScroll: (page) => Object.keys(page.props.errors).length,
        }
    );
};

const handleDeleteMembership = (id) => {
    ElMessageBox.confirm(
        "Apakah anda yakin ingin menghapus membership ini?",
        "Warning",
        {
            confirmButtonText: "OK",
            cancelButtonText: "Cancel",
            type: "warning",
        }
    )
        .then(() => {
            router.delete(`/memberships/${id}`, {
                onSuccess: () => {
                    ElMessage({
                        type: "success",
                        message: "Berhasil menghapus data.",
                    });
                },
                preserveScroll: (page) => Object.keys(page.props.errors).length,
            });
        })
        .catch(() => {});
};

const changeFilterColumn = () => {
    formFilter.keyword = null;
};

const search = () => {
    router.get(
        "/memberships",
        {
            column: formFilter.column,
            keyword: formFilter.keyword,
        },
        {
            preserveState: true,
            preserveScroll: true,
            only: ["memberships"],
        }
    );
};

defineProps({ memberships: Object, patients: Array });
defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Membership" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Membership</h1>
                <el-button size="small" @click="createMembershipDrawer = true">
                    Tambah Membership
                </el-button>
            </div>

            <el-form
                :inline="true"
                :model="formFilter"
                @submit.prevent="search"
            >
                <el-form-item>
                    <template #label>
                        <el-select
                            v-model="formFilter.column"
                            @change="changeFilterColumn"
                            placeholder="Cari berdasarkan kolom"
                            filterable
                            clearable
                        >
                            <el-option value="" label="Semua" />
                            <el-option
                                value="registrasion_number"
                                label="Nomor Induk"
                            />
                            <el-option value="name" label="Nama" />
                            <el-option value="age" label="Umur" />
                            <el-option value="gender" label="Jenis Kelamin" />
                            <el-option value="skin_type" label="Jenis Kulit" />
                            <el-option value="address" label="Alamat" />
                            <el-option value="phone" label="Nomor Telepon" />
                        </el-select>
                    </template>
                    <div class="flex space-x-2">
                        <el-input-number
                            v-if="formFilter.column === 'age'"
                            v-model="formFilter.keyword"
                            class="w-220px"
                            clearable
                        />
                        <el-select
                            v-else-if="formFilter.column === 'gender'"
                            v-model="formFilter.keyword"
                            placeholder="Pilih jenis kelamin"
                            filterable
                            clearable
                        >
                            <el-option value="Pria" label="Pria" />
                            <el-option value="Wanita" label="Wanita" />
                        </el-select>
                        <el-select
                            v-else-if="formFilter.column === 'skin_type'"
                            v-model="formFilter.keyword"
                            placeholder="Pilih jenis kulit"
                            filterable
                            clearable
                        >
                            <el-option value="Normal" label="Normal" />
                            <el-option value="Oily" label="Oily" />
                            <el-option value="Dry" label="Dry" />
                            <el-option value="Acne" label="Acne" />
                            <el-option value="Kombinasi" label="Kombinasi" />
                        </el-select>
                        <el-input
                            v-else
                            v-model="formFilter.keyword"
                            placeholder="Masukan kata kunci"
                            class="w-220px"
                            clearable
                        />
                        <el-button @click="search" native-type="submit">
                            Cari
                        </el-button>
                    </div>
                </el-form-item>
            </el-form>

            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 place-items-center gap-5 mt-5"
            >
                <div
                    v-for="membership in memberships.data"
                    :key="membership.id"
                >
                    <Link :href="`/patients/${membership.patient.id}`">
                        <el-card
                            class="relative w-[300px] h-[175px] rounded-md"
                        >
                            <div class="flex justify-between items-start gap-5">
                                <h1
                                    class="text-[#785189] font-semibold uppercase"
                                >
                                    Member Card
                                </h1>
                                <img
                                    :src="logo"
                                    alt="Yurishine"
                                    class="w-[32.5%] mb-7"
                                />
                            </div>

                            <div class="absolute bottom-5 right-5 text-right">
                                <span
                                    class="block text-[0.7rem] font-medium uppercase mb-1"
                                >
                                    {{ membership.patient.registrasion_number }}
                                </span>
                                <span
                                    class="block text-xs font-medium uppercase"
                                >
                                    {{ membership.patient.name }}
                                </span>
                            </div>

                            <div class="absolute bottom-20 left-5 text-left">
                                <span
                                    class="block text-xs font-medium uppercase mb-1"
                                >
                                    Saldo
                                </span>
                                <span class="block text-[0.7rem] uppercase">
                                    {{ currency.format(membership.balance) }}
                                </span>
                            </div>
                        </el-card>
                    </Link>
                    <div class="mt-3">
                        <el-button
                            size="small"
                            @click="
                                addBalanceDrawer = true;
                                formAddBalance.membership_id = membership.id;
                            "
                        >
                            Tambah Saldo
                        </el-button>
                        <el-button
                            size="small"
                            @click="
                                useBalanceDrawer = true;
                                formUseBalance.membership_id = membership.id;
                            "
                        >
                            Gunakan Saldo
                        </el-button>
                        <el-button
                            size="small"
                            @click="handleDeleteMembership(membership.id)"
                        >
                            Delete
                        </el-button>
                    </div>
                </div>
            </div>
        </el-card>

        <el-drawer v-model="createMembershipDrawer" :show-close="false">
            <template #header="{ titleId, titleClass }">
                <h4 :id="titleId" :class="`${titleClass} font-semibold`">
                    Tambah Membership
                </h4>
            </template>
            <el-form
                label-position="top"
                @submit.prevent="handleCreateMembership"
            >
                <el-form-item label="Pasien" :error="form.errors.patient_id">
                    <el-select
                        v-model="form.patient_id"
                        class="w-full"
                        filterable
                        clearable
                    >
                        <el-option
                            v-for="patient in patients"
                            :key="patient.id"
                            :value="patient.id"
                            :label="`${patient.registrasion_number} - ${patient.name}`"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item label="Harga" :error="form.errors.balance">
                    <el-input
                        v-model="form.balance"
                        :formatter="
                            (value) =>
                                `Rp. ${value}`.replace(
                                    /\B(?=(\d{3})+(?!\d))/g,
                                    ','
                                )
                        "
                        :parser="(value) => value.replace(/\Rp.\s?|(,*)/g, '')"
                    />
                </el-form-item>
                <div class="flex justify-end">
                    <el-button size="small" @click="handleCreateMembership">
                        Simpan
                    </el-button>
                </div>
            </el-form>
        </el-drawer>

        <el-drawer v-model="addBalanceDrawer" :show-close="false">
            <template #header="{ titleId, titleClass }">
                <h4 :id="titleId" :class="`${titleClass} font-semibold`">
                    Tambah Saldo
                </h4>
            </template>
            <el-form label-position="top" @submit.prevent="handleAddBalance">
                <el-form-item
                    label="Jumlah Saldo"
                    :error="formAddBalance.errors.payload"
                >
                    <el-input
                        v-model="formAddBalance.payload"
                        :formatter="
                            (value) =>
                                `Rp. ${value}`.replace(
                                    /\B(?=(\d{3})+(?!\d))/g,
                                    ','
                                )
                        "
                        :parser="(value) => value.replace(/\Rp.\s?|(,*)/g, '')"
                    />
                </el-form-item>
                <div class="flex justify-end">
                    <el-button size="small" @click="handleAddBalance">
                        Tambah
                    </el-button>
                </div>
            </el-form>
        </el-drawer>

        <el-drawer v-model="useBalanceDrawer" :show-close="false">
            <template #header="{ titleId, titleClass }">
                <h4 :id="titleId" :class="`${titleClass} font-semibold`">
                    Gunakan Saldo
                </h4>
            </template>
            <el-form label-position="top" @submit.prevent="handleUseBalance">
                <el-form-item
                    label="Jumlah Saldo"
                    :error="formUseBalance.errors.payload"
                >
                    <el-input
                        v-model="formUseBalance.payload"
                        :formatter="
                            (value) =>
                                `Rp. ${value}`.replace(
                                    /\B(?=(\d{3})+(?!\d))/g,
                                    ','
                                )
                        "
                        :parser="(value) => value.replace(/\Rp.\s?|(,*)/g, '')"
                    />
                </el-form-item>
                <div class="flex justify-end">
                    <el-button size="small" @click="handleUseBalance">
                        Gunakan
                    </el-button>
                </div>
            </el-form>
        </el-drawer>
    </div>
</template>
