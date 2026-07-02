<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import {
    House,
    LayoutGrid,
    Users,
    KeyRound,
    LockKeyhole,
} from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard, modulos } from '@/routes';
import usuarios from '@/routes/admin';
import type { NavItem } from '@/types';

const page = usePage();
const auth = computed(() => page.props.auth || {});

const mainNavItems: NavItem[] = [
    {
        title: 'Inicio',
        href: dashboard(),
        icon: House,
    },
    {
        title: 'Modulos',
        href: modulos(),
        icon: LayoutGrid,
    },
    {
        title: 'Usuarios',
        href: '/admin/usuarios',
        icon: Users,
        // can: usuarios
    },
    {
        title: 'Roles y permisos',
        href: '/admin/roles',
        icon: KeyRound,
    },
    {
        title: 'Permisos',
        href: 'permisos',
        icon: LockKeyhole,
    },
];

const footerNavItems: NavItem[] = [
    // {
    //     title: 'Repository',
    //     href: 'https://github.com/laravel/vue-starter-kit',
    //     icon: FolderGit2,
    // },
    // {
    //     title: 'Documentation',
    //     href: 'https://laravel.com/docs/starter-kits#vue',
    //     icon: BookOpen,
    // },
];

const visibleMainNavItems = computed(() => {
    const permissions = Array.isArray(auth.value.permissions)
        ? auth.value.permissions
        : [];

    return mainNavItems.filter(
        (item) => !item.permission || permissions.includes(item.permission),
    );
});
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="visibleMainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
