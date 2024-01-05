<script setup>
import logo from "@images/logo.png";
import { useForm, Head } from "@inertiajs/vue3";

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const isPasswordVisible = ref(false);
</script>
<template>
    <Head title="Login" />
    <div class="min-h-screen flex justify-center items-center bg-gray-50">
        <VCard class="auth-card pa-4 pt-7" max-width="448">
            <VCardItem class="justify-center">
                <template #prepend>
                    <div class="d-flex">
                        <img
                            :src="logo"
                            alt="Yurishine"
                            class="w-[200px] h-auto"
                        />
                    </div>
                </template>
            </VCardItem>

            <VCardText>
                <p class="mb-0">
                    Please sign-in to your account and start the adventure
                </p>
            </VCardText>

            <VCardText>
                <VForm @submit.prevent="form.post('/login')">
                    <VRow>
                        <VCol cols="12">
                            <VTextField
                                v-model="form.email"
                                autofocus
                                placeholder="johndoe@email.com"
                                label="Email"
                                type="email"
                                :error-messages="form.errors.email"
                            />
                        </VCol>

                        <VCol cols="12">
                            <VTextField
                                v-model="form.password"
                                label="Password"
                                placeholder="· · · · · · · · · · · ·"
                                :type="isPasswordVisible ? 'text' : 'password'"
                                :append-inner-icon="
                                    isPasswordVisible ? 'bx-hide' : 'bx-show'
                                "
                                @click:append-inner="
                                    isPasswordVisible = !isPasswordVisible
                                "
                                :error-messages="form.errors.password"
                            />

                            <VBtn block type="submit" class="mt-5">
                                Login
                            </VBtn>
                        </VCol>
                    </VRow>
                </VForm>
            </VCardText>
        </VCard>
    </div>
</template>
<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";
</style>
