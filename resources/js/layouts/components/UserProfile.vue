<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import avatar from "@images/avatars/avatar.png";

const page = usePage();

const user = computed(() => page.props.auth.user);
</script>

<template>
    <VBadge
        dot
        location="bottom right"
        offset-x="3"
        offset-y="3"
        color="success"
        bordered
    >
        <VAvatar class="cursor-pointer" color="primary" variant="tonal">
            <VImg :src="avatar" />
            <VMenu
                activator="parent"
                width="230"
                location="bottom end"
                offset="24px"
            >
                <VList>
                    <!-- 👉 User Avatar & Name -->
                    <VListItem>
                        <template #prepend>
                            <VListItemAction start>
                                <VBadge
                                    dot
                                    location="bottom right"
                                    offset-x="3"
                                    offset-y="3"
                                    color="success"
                                >
                                    <VAvatar color="primary" variant="tonal">
                                        <VImg :src="avatar" />
                                    </VAvatar>
                                </VBadge>
                            </VListItemAction>
                        </template>

                        <VListItemTitle class="font-weight-semibold">
                            {{ user?.name }}
                        </VListItemTitle>
                        <VListItemSubtitle>{{ user?.email }}</VListItemSubtitle>
                    </VListItem>
                    <VDivider class="my-2" />

                    <Link href="/profile" class="text-gray-500">
                        <VListItem link>
                            <template #prepend>
                                <VIcon class="me-2" icon="bx-user" size="22" />
                            </template>

                            <VListItemTitle class="text-sm">
                                Profile
                            </VListItemTitle>
                        </VListItem>
                    </Link>

                    <Link href="/settings">
                        <VListItem link>
                            <template #prepend>
                                <VIcon class="me-2" icon="bx-cog" size="22" />
                            </template>

                            <VListItemTitle class="text-sm">
                                Settings
                            </VListItemTitle>
                        </VListItem>
                    </Link>

                    <VDivider class="my-2" />

                    <!-- 👉 Logout -->
                    <Link href="/logout">
                        <VListItem link>
                            <template #prepend>
                                <VIcon
                                    class="me-2"
                                    icon="bx-log-out"
                                    size="22"
                                />
                            </template>

                            <VListItemTitle class="text-sm">
                                Logout
                            </VListItemTitle>
                        </VListItem>
                    </Link>
                </VList>
            </VMenu>
        </VAvatar>
    </VBadge>
</template>
